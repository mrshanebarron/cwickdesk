<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\KbArticle;
use App\Models\KbArticleFeedback;
use App\Models\Ticket;
use App\Models\TicketPriority;
use App\Models\TicketStatus;
use App\Models\TicketTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicPortalController extends Controller
{
    public function index()
    {
        return view('portal.index');
    }

    public function submitTicketForm()
    {
        $priorities = TicketPriority::orderBy('sort_order')->get();
        $templates = TicketTemplate::active()->ordered()->get();
        $assets = Asset::where('status', 'active')
            ->orderBy('name')
            ->get(['id', 'asset_tag', 'name', 'manufacturer', 'model']);
        return view('portal.submit-ticket', compact('priorities', 'templates', 'assets'));
    }

    public function storeTicket(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'priority_id' => 'required|exists:ticket_priorities,id',
            'asset_id' => 'nullable|exists:assets,id',
        ]);

        // Get default status
        $defaultStatus = TicketStatus::where('is_default', true)->first();

        // Create ticket for authenticated user
        $ticket = Ticket::create([
            'subject' => $validated['subject'],
            'description' => $validated['description'],
            'requester_id' => Auth::id(),
            'priority_id' => $validated['priority_id'],
            'status_id' => $defaultStatus->id,
            'asset_id' => $validated['asset_id'] ?? null,
            'source' => 'web',
            'is_internal' => false,
        ]);

        return redirect()->route('portal.ticket.success', $ticket->ticket_number)
            ->with('success', 'Your ticket has been submitted successfully!');
    }

    public function ticketSuccess($ticketNumber)
    {
        $ticket = Ticket::where('ticket_number', $ticketNumber)->firstOrFail();
        return view('portal.ticket-success', compact('ticket'));
    }

    public function lookupTicket(Request $request)
    {
        $request->validate([
            'ticket_number' => 'required|string',
        ]);

        $ticket = Ticket::where('ticket_number', $request->ticket_number)
            ->with(['status', 'priority', 'assignedTo'])
            ->first();

        if (!$ticket) {
            return back()->with('error', 'Ticket not found. Please check the ticket number and try again.');
        }

        // Security: Only ticket owner or IT staff can view
        $user = Auth::user();
        $isTicketOwner = $user && $ticket->requester_id === $user->id;
        $isITStaff = $user && $user->hasAnyRole(['admin', 'agent', 'super_admin']);

        if (!$isTicketOwner && !$isITStaff) {
            return back()->with('error', 'You do not have permission to view this ticket. Only the ticket owner or IT staff can access this ticket.');
        }

        return view('portal.ticket-status', compact('ticket'));
    }

    public function knowledgeBase()
    {
        $articles = KbArticle::where('is_published', true)
            ->where('is_featured', true)
            ->orderBy('view_count', 'desc')
            ->limit(10)
            ->get();

        $categories = \App\Models\KbCategory::whereHas('articles', function ($query) {
            $query->where('is_published', true);
        })->get();

        return view('portal.knowledge-base', compact('articles', 'categories'));
    }

    public function viewArticle($slug)
    {
        $article = KbArticle::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Increment view count
        $article->increment('view_count');

        // Get user's existing feedback (if logged in)
        $userFeedback = null;
        if (Auth::check()) {
            $userFeedback = KbArticleFeedback::where('kb_article_id', $article->id)
                ->where('user_id', Auth::id())
                ->first();
        }

        return view('portal.article', compact('article', 'userFeedback'));
    }

    // Authentication Methods
    public function loginForm()
    {
        return view('portal.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('portal.index'))
                ->with('success', 'Welcome back, ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('portal.index')
            ->with('success', 'You have been logged out successfully.');
    }

    public function registerForm()
    {
        return view('portal.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'extension' => 'nullable|string|max:50',
            'cell' => 'nullable|string|max:50',
            'department' => 'nullable|string|max:255',
        ]);

        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'extension' => $validated['extension'] ?? null,
            'cell' => $validated['cell'] ?? null,
            'department' => $validated['department'] ?? null,
        ]);

        // Assign default 'user' role
        $user->assignRole('user');

        Auth::login($user);

        return redirect()->route('portal.index')
            ->with('success', 'Registration successful! Welcome to the IT Help Desk Portal.');
    }

    public function myTickets()
    {
        $tickets = Ticket::where('requester_id', Auth::id())
            ->with(['status', 'priority', 'assignedTo'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('portal.my-tickets', compact('tickets'));
    }

    public function submitArticleFeedback(Request $request)
    {
        $validated = $request->validate([
            'article_id' => 'required|exists:kb_articles,id',
            'is_helpful' => 'required|boolean',
        ]);

        // Check if user already submitted feedback for this article
        $existingFeedback = KbArticleFeedback::where('kb_article_id', $validated['article_id'])
            ->where('user_id', Auth::id())
            ->first();

        if ($existingFeedback) {
            // Update existing feedback
            $existingFeedback->update([
                'is_helpful' => $validated['is_helpful'],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Thank you! Your feedback has been updated.',
            ]);
        }

        // Create new feedback
        KbArticleFeedback::create([
            'kb_article_id' => $validated['article_id'],
            'user_id' => Auth::id(),
            'is_helpful' => $validated['is_helpful'],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thank you for your feedback!',
        ]);
    }
}
