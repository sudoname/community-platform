<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ForumTopic;
use App\Models\ForumCategory;
use Illuminate\Http\Request;

class ForumTopicController extends Controller
{
    public function create()
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only admins can manage forum topics');
        }

        $categories = ForumCategory::active()->ordered()->get();
        return view('admin.forums.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only admins can manage forum topics');
        }

        $validated = $request->validate([
            'category_id' => 'required|exists:forum_categories,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_pinned' => 'boolean',
            'allowed_roles' => 'nullable|array',
            'allowed_roles.*' => 'in:admin,paid_member,free_member',
        ]);

        // If allowed_roles is not set, default to all roles
        if (!isset($validated['allowed_roles']) || empty($validated['allowed_roles'])) {
            $validated['allowed_roles'] = ['admin', 'paid_member', 'free_member'];
        }

        $validated['allowed_roles'] = json_encode($validated['allowed_roles']);
        $validated['is_pinned'] = $request->boolean('is_pinned');
        $validated['user_id'] = auth()->id();

        $topic = ForumTopic::create($validated);

        return redirect()->route('dashboard')
            ->with('success', 'Forum topic created successfully!');
    }

    public function index()
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only admins can manage forum topics');
        }

        $topics = ForumTopic::with(['category', 'user'])
            ->orderByDesc('is_pinned')
            ->orderByDesc('last_activity_at')
            ->paginate(20);
        return view('admin.forums.index', compact('topics'));
    }

    public function edit(ForumTopic $forum)
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only admins can manage forum topics');
        }

        $categories = ForumCategory::active()->ordered()->get();
        return view('admin.forums.edit', compact('forum', 'categories'));
    }

    public function update(Request $request, ForumTopic $forum)
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only admins can manage forum topics');
        }

        $validated = $request->validate([
            'category_id' => 'required|exists:forum_categories,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_pinned' => 'boolean',
            'is_locked' => 'boolean',
            'allowed_roles' => 'nullable|array',
            'allowed_roles.*' => 'in:admin,paid_member,free_member',
        ]);

        if (!isset($validated['allowed_roles']) || empty($validated['allowed_roles'])) {
            $validated['allowed_roles'] = ['admin', 'paid_member', 'free_member'];
        }

        $validated['allowed_roles'] = json_encode($validated['allowed_roles']);
        $validated['is_pinned'] = $request->boolean('is_pinned');
        $validated['is_locked'] = $request->boolean('is_locked');

        $forum->update($validated);

        return redirect()->route('admin.forums.index')
            ->with('success', 'Forum topic updated successfully!');
    }

    public function destroy(ForumTopic $forum)
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only admins can manage forum topics');
        }

        $forum->delete();
        return redirect()->route('admin.forums.index')
            ->with('success', 'Forum topic deleted successfully!');
    }
}
