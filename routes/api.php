<?php

use App\Http\Controllers\Api\AssetController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\InboundEmailController;
use App\Http\Controllers\Api\KbArticleController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

// Inbound email webhook (SendGrid Inbound Parse)
Route::post('/inbound-email/{tenant}', [InboundEmailController::class, 'handle'])->name('api.inbound-email');

// Authentication endpoints
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);

// Protected API routes (require Sanctum token)
Route::middleware(['auth:sanctum', 'tenant'])->group(function () {
    // Auth
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/user', [AuthController::class, 'user']);

    // Tickets
    Route::apiResource('tickets', TicketController::class);
    Route::post('/tickets/{ticket}/comments', [TicketController::class, 'addComment']);
    Route::post('/tickets/{ticket}/assign', [TicketController::class, 'assign']);
    Route::post('/tickets/{ticket}/close', [TicketController::class, 'close']);
    Route::post('/tickets/{ticket}/reopen', [TicketController::class, 'reopen']);

    // Assets
    Route::apiResource('assets', AssetController::class);
    Route::post('/assets/{asset}/checkout', [AssetController::class, 'checkout']);
    Route::post('/assets/{asset}/checkin', [AssetController::class, 'checkin']);

    // Knowledge Base
    Route::apiResource('kb-articles', KbArticleController::class);
    Route::post('/kb-articles/{kbArticle}/feedback', [KbArticleController::class, 'submitFeedback']);

    // Users
    Route::apiResource('users', UserController::class);

    // Webhooks (for Zapier integration)
    Route::get('/webhooks', function () {
        return response()->json([
            'webhooks' => [
                'ticket.created',
                'ticket.updated',
                'ticket.assigned',
                'ticket.closed',
                'asset.created',
                'asset.updated',
                'asset.checked_out',
                'asset.checked_in',
                'kb.article.published',
                'user.created',
            ]
        ]);
    });
});
