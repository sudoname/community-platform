<?php

use App\Http\Controllers\Api\ForumController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/health', function () {
    return response()->json(['status' => 'ok', 'timestamp' => now()]);
});

// Protected API routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // User API endpoints
    Route::apiResource('users', UserController::class);

    // Message API endpoints
    Route::apiResource('messages', MessageController::class);
    Route::get('/messages/channel/{channel}', [MessageController::class, 'byChannel']);

    // Forum API endpoints
    Route::apiResource('forums', ForumController::class);
    Route::get('/forums/category/{category}', [ForumController::class, 'byCategory']);

    // Stock Recommendations API (Free tier - Basic info only)
    Route::middleware('subscription.tier:free_member')->group(function () {
        Route::get('/recommendations/basic', function () {
            return response()->json([
                'data' => \App\Models\Recommendation::active()
                    ->ordered()
                    ->get(['id', 'stock_symbol', 'stock_name', 'action'])
                    ->map(function ($rec) {
                        return [
                            'id' => $rec->id,
                            'symbol' => $rec->stock_symbol,
                            'name' => $rec->stock_name,
                            'action' => $rec->action,
                        ];
                    }),
                'message' => 'Upgrade to paid membership for detailed recommendations with pricing and analysis.'
            ]);
        });
    });

    // Stock Recommendations API (Paid tier - Full details)
    Route::middleware('subscription.tier:paid_member')->group(function () {
        Route::get('/recommendations', function () {
            $recommendations = \App\Models\Recommendation::active()->ordered()->get();
            return response()->json([
                'data' => $recommendations->map(function ($rec) {
                    $data = [
                        'id' => $rec->id,
                        'symbol' => $rec->stock_symbol,
                        'name' => $rec->stock_name,
                        'type' => $rec->type,
                        'action' => $rec->action,
                        'price' => $rec->price,
                        'notes' => $rec->notes,
                        'show_in_marquee' => $rec->show_in_marquee,
                        'display_order' => $rec->display_order,
                    ];

                    // Add options details if it's an option
                    if ($rec->type === 'option') {
                        $data['option_details'] = [
                            'type' => $rec->option_type,
                            'strike_price' => $rec->strike_price,
                            'expiration_date' => $rec->expiration_date?->format('Y-m-d'),
                        ];
                    }

                    return $data;
                }),
                'message' => 'Full recommendations with pricing and analysis.'
            ]);
        });

        Route::get('/recommendations/{id}', function ($id) {
            $rec = \App\Models\Recommendation::findOrFail($id);
            $data = [
                'id' => $rec->id,
                'symbol' => $rec->stock_symbol,
                'name' => $rec->stock_name,
                'type' => $rec->type,
                'action' => $rec->action,
                'price' => $rec->price,
                'notes' => $rec->notes,
            ];

            if ($rec->type === 'option') {
                $data['option_details'] = [
                    'type' => $rec->option_type,
                    'strike_price' => $rec->strike_price,
                    'expiration_date' => $rec->expiration_date?->format('Y-m-d'),
                ];
            }

            return response()->json(['data' => $data]);
        });
    });

    // Admin-only API endpoints
    Route::middleware('subscription.tier:admin')->group(function () {
        Route::get('/admin/stats', function () {
            return response()->json([
                'total_users' => \App\Models\User::count(),
                'paid_members' => \App\Models\User::where('role', 'paid_member')->count(),
                'free_members' => \App\Models\User::where('role', 'free_member')->count(),
                'total_recommendations' => \App\Models\Recommendation::count(),
                'active_recommendations' => \App\Models\Recommendation::active()->count(),
            ]);
        });
    });
});
