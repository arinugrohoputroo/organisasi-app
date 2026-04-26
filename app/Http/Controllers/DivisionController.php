<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Division;

class DivisionController extends Controller
{
    public function index()
    {
        return view('divisions.index', [
            'divisions' => Division::latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        abort_if(auth()->user()->role !== 'ketua', 403);

        $request->validate([
            'name' => 'required'
        ]);

        Division::create([
            'name' => $request->name,
            'created_by' => auth()->id(),
        ]);

        return back()->with('success', 'Divisi dibuat');
    }

    public function assign(Request $request, Division $division)
    {
        $division->users()->syncWithoutDetaching([
            $request->user_id => [
                'assigned_by' => auth()->id()
            ]
        ]);

        return back()->with('success', 'User ditambahkan ke divisi');
    }
}