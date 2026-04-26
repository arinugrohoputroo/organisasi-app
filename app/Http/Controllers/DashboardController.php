<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use App\Models\Attendance;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $totalUsers = User::count();
        $totalTasks = Task::count();
        $totalAttendances = Attendance::count();

        // FIX: hadir hari ini (biar tidak undefined)
        $hadir = Attendance::whereDate('created_at', today())->count();

        $latestTasks = Task::latest()->take(5)->get();

        // FIX: tanpa relation error (aman walau belum ada relasi user)
        $recentAttendances = Attendance::latest()->take(5)->get();

        return view('dashboard.index', compact(
            'user',
            'totalUsers',
            'totalTasks',
            'totalAttendances',
            'latestTasks',
            'recentAttendances',
            'hadir'
        ));
    }
}