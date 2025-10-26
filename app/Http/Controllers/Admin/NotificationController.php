<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\AdminMessage;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function create()
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only admins can send notifications');
        }

        return view('admin.notifications.create');
    }

    public function store(Request $request)
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only admins can send notifications');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
            'action_url' => 'nullable|url|max:255',
            'action_text' => 'nullable|string|max:50',
            'priority' => 'required|in:info,success,warning,error',
            'recipients' => 'required|in:all,admin,paid_member,free_member',
        ]);

        // Get recipients based on selection
        $query = User::query();

        if ($validated['recipients'] !== 'all') {
            $query->where('role', $validated['recipients']);
        }

        $users = $query->get();

        // Send notification to each user
        foreach ($users as $user) {
            $user->notify(new AdminMessage(
                $validated['title'],
                $validated['message'],
                $validated['action_url'] ?? null,
                $validated['action_text'] ?? null,
                $validated['priority']
            ));
        }

        return redirect()->route('admin.notifications.create')
            ->with('success', "Notification sent to {$users->count()} " . ($users->count() === 1 ? 'user' : 'users') . '!');
    }
}
