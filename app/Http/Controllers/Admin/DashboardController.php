<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Channel;
use App\Models\ForumTopic;
use App\Models\Recommendation;
use App\Models\Message;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only admins can access the admin dashboard');
        }

        $stats = [
            'total_users' => User::count(),
            'paid_members' => User::where('role', 'paid_member')->count(),
            'free_members' => User::where('role', 'free_member')->count(),
            'total_channels' => Channel::count(),
            'total_topics' => ForumTopic::count(),
            'total_recommendations' => Recommendation::count(),
            'total_messages' => Message::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
