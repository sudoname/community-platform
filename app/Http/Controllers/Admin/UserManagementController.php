<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index()
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only admins can manage users');
        }

        $users = User::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only admins can manage users');
        }

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only admins can manage users');
        }

        // Prevent admin from demoting themselves
        if ($user->id === auth()->id() && $request->role !== 'admin') {
            return redirect()->back()
                ->withErrors(['role' => 'You cannot change your own role']);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,paid_member,free_member',
            'paid_expiration' => 'nullable|date|after:now',
        ]);

        // If changing to paid member, set expiration if provided
        if ($validated['role'] === 'paid_member' && $request->filled('paid_expiration')) {
            $validated['paid_expiration'] = $request->input('paid_expiration');
        } else if ($validated['role'] !== 'paid_member') {
            // Clear expiration if not paid member
            $validated['paid_expiration'] = null;
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only admins can manage users');
        }

        // Prevent admin from deleting themselves
        if ($user->id === auth()->id()) {
            return redirect()->back()
                ->withErrors(['delete' => 'You cannot delete your own account']);
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully!');
    }
}
