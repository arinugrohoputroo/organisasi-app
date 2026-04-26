<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index', [
            'users' => User::all()
        ]);
    }

    public function store(Request $request)
    {
        abort_if(auth()->user()->role !== 'ketua', 403);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return back()->with('success', 'User dibuat');
    }

    public function destroy(User $user)
    {
        abort_if(auth()->user()->role !== 'ketua', 403);

        $user->delete();

        return back()->with('success', 'User dihapus');
    }
}