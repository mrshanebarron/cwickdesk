<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\PublicPortalController;
use App\Http\Controllers\SignupController;
use App\Models\Tenant;
use Illuminate\Support\Facades\Route;

// Root route - dispatch based on tenant detection
Route::get('/', function () {
    if (Tenant::checkCurrent()) {
        return app(PublicPortalController::class)->index();
    }
    return app(LandingController::class)->index();
});

// Tenant portal routes - only accessible when tenant is detected
Route::middleware('tenant')->prefix('/')->group(function () {
    Route::get('/knowledge-base', [PublicPortalController::class, 'knowledgeBase'])->name('portal.kb');
    Route::get('/kb/{slug}', [PublicPortalController::class, 'viewArticle'])->name('portal.article');
    Route::get('/login', [PublicPortalController::class, 'loginForm'])->name('portal.login');
    Route::post('/login', [PublicPortalController::class, 'login'])->name('portal.login.submit');
    Route::post('/logout', [PublicPortalController::class, 'logout'])->name('portal.logout');
    Route::get('/register', [PublicPortalController::class, 'registerForm'])->name('portal.register');
    Route::post('/register', [PublicPortalController::class, 'register'])->name('portal.register.submit');
    Route::get('/auth/{provider}/redirect', [\App\Http\Controllers\Auth\SocialiteController::class, 'redirect'])->name('auth.sso.redirect');
    Route::get('/auth/{provider}/callback', [\App\Http\Controllers\Auth\SocialiteController::class, 'callback'])->name('auth.sso.callback');

    Route::middleware('auth')->group(function () {
        Route::get('/submit-ticket', [PublicPortalController::class, 'submitTicketForm'])->name('portal.submit');
        Route::post('/submit-ticket', [PublicPortalController::class, 'storeTicket'])->name('portal.ticket.store');
        Route::get('/ticket/{ticketNumber}/success', [PublicPortalController::class, 'ticketSuccess'])->name('portal.ticket.success');
        Route::get('/ticket/lookup', [PublicPortalController::class, 'lookupTicket'])->name('portal.ticket.lookup');
        Route::get('/my-tickets', [PublicPortalController::class, 'myTickets'])->name('portal.my-tickets');
        Route::post('/kb/feedback', [PublicPortalController::class, 'submitArticleFeedback'])->name('portal.article.feedback');
    });
});

// Landlord routes - only accessible when NO tenant is detected
Route::get('/pricing', [LandingController::class, 'pricing'])->name('landing.pricing');
Route::get('/features', [LandingController::class, 'features'])->name('landing.features');

// Legal pages
Route::view('/terms', 'legal.terms')->name('legal.terms');
Route::view('/privacy', 'legal.privacy')->name('legal.privacy');

// Signup flow with Stripe
Route::get('/signup', [SignupController::class, 'index'])->name('signup.index');
Route::post('/signup', [SignupController::class, 'store'])->name('signup.store');
Route::get('/signup/success', [SignupController::class, 'success'])->name('signup.success');

// Stripe webhook for subscription events
Route::post('/stripe/webhook', [SignupController::class, 'webhook'])->name('stripe.webhook');

// Impersonation routes (platform admin feature)
Route::impersonate();
