<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    public function create()
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only admins can manage channels');
        }

        return view('admin.channels.create');
    }

    public function store(Request $request)
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only admins can manage channels');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:channels',
            'description' => 'nullable|string',
            'type' => 'required|in:text,announcement',
            'is_private' => 'boolean',
            'allowed_roles' => 'nullable|array',
            'allowed_roles.*' => 'in:admin,paid_member,free_member',
        ]);

        // If allowed_roles is not set, default to all roles
        if (!isset($validated['allowed_roles']) || empty($validated['allowed_roles'])) {
            $validated['allowed_roles'] = ['admin', 'paid_member', 'free_member'];
        }

        $validated['allowed_roles'] = json_encode($validated['allowed_roles']);
        $validated['is_private'] = $request->boolean('is_private');

        $channel = Channel::create($validated);

        return redirect()->route('dashboard')
            ->with('success', 'Channel created successfully!');
    }

    public function index()
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only admins can manage channels');
        }

        $channels = Channel::orderBy('display_order')->paginate(20);
        return view('admin.channels.index', compact('channels'));
    }

    public function edit(Channel $channel)
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only admins can manage channels');
        }

        return view('admin.channels.edit', compact('channel'));
    }

    public function update(Request $request, Channel $channel)
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only admins can manage channels');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:channels,name,' . $channel->id,
            'description' => 'nullable|string',
            'type' => 'required|in:text,announcement',
            'is_private' => 'boolean',
            'allowed_roles' => 'nullable|array',
            'allowed_roles.*' => 'in:admin,paid_member,free_member',
            'is_active' => 'boolean',
        ]);

        if (!isset($validated['allowed_roles']) || empty($validated['allowed_roles'])) {
            $validated['allowed_roles'] = ['admin', 'paid_member', 'free_member'];
        }

        $validated['allowed_roles'] = json_encode($validated['allowed_roles']);
        $validated['is_private'] = $request->boolean('is_private');
        $validated['is_active'] = $request->boolean('is_active', true);

        $channel->update($validated);

        return redirect()->route('admin.channels.index')
            ->with('success', 'Channel updated successfully!');
    }

    public function destroy(Channel $channel)
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only admins can manage channels');
        }

        $channel->delete();
        return redirect()->route('admin.channels.index')
            ->with('success', 'Channel deleted successfully!');
    }
}
