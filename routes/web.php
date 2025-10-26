<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Chat Routes
Route::get('/chat', App\Livewire\Chat\Index::class)
    ->middleware(['auth'])
    ->name('chat');

// Forum Routes
Route::get('/forums', App\Livewire\Forum\Index::class)
    ->middleware(['auth'])
    ->name('forums');
Route::get('/forums/{slug}', App\Livewire\Forum\TopicShow::class)
    ->middleware(['auth'])
    ->name('forums.topic');

// Social Authentication Routes
Route::get('/auth/{provider}', [App\Http\Controllers\SocialAuthController::class, 'redirect'])
    ->name('social.redirect');
Route::get('/auth/{provider}/callback', [App\Http\Controllers\SocialAuthController::class, 'callback'])
    ->name('social.callback');

// Admin Routes (Admin only)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
        ->name('dashboard');
    Route::resource('users', App\Http\Controllers\Admin\UserManagementController::class)->except(['create', 'store']);
    Route::resource('channels', App\Http\Controllers\Admin\ChannelController::class);
    Route::resource('forums', App\Http\Controllers\Admin\ForumTopicController::class);
    Route::resource('recommendations', App\Http\Controllers\Admin\RecommendationController::class);
    Route::get('notifications/send', [App\Http\Controllers\Admin\NotificationController::class, 'create'])
        ->name('notifications.create');
    Route::post('notifications/send', [App\Http\Controllers\Admin\NotificationController::class, 'store'])
        ->name('notifications.store');
    Route::get('settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])
        ->name('settings.index');
    Route::put('settings', [App\Http\Controllers\Admin\SettingsController::class, 'update'])
        ->name('settings.update');
});

// Notification/Inbox Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])
        ->name('notifications.index');
    Route::post('/notifications/{notification}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])
        ->name('notifications.read');
    Route::post('/notifications/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])
        ->name('notifications.markAllAsRead');
});

// Policy Routes (Public)
Route::get('/policy/terms', [App\Http\Controllers\PolicyController::class, 'terms'])
    ->name('policy.terms');
Route::get('/auth/facebook/deletion', [App\Http\Controllers\PolicyController::class, 'facebookDeletion'])
    ->name('facebook.deletion');
Route::post('/auth/facebook/deletion', [App\Http\Controllers\PolicyController::class, 'handleFacebookDeletion']);

require __DIR__.'/auth.php';
