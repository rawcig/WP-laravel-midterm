<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * list all users
     */
    public function index()
    {
        $users = User::latest()->paginate(15);
        return view('backend.pages.users.index', compact('users'));
    }

    /**
     * show user details
     */
    public function show(User $user)
    {
        $user->load('events', 'guests');
        return view('backend.pages.users.show', compact('user'));
    }

    /**
     * show edit form
     */
    public function edit(User $user)
    {
        return view('backend.pages.users.edit', compact('user'));
    }

    /**
     * update user
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
            'role' => 'required|in:admin,organizer,user',
        ]);

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    /**
     * delete user
     */
    public function destroy(User $user)
    {
        // prevent deleting yourself
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account!');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }
}
