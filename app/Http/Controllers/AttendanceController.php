<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $users = User::all();
        $sessions = Attendance::select('session')->distinct()->pluck('session');

        $attendances = Attendance::all()->groupBy(['user_id', 'session']);

        return view('attendance.index', compact('users', 'sessions', 'attendances'));
    }

    // klik titik hijau
    public function toggle(Request $request)
    {
        $attendance = Attendance::where('user_id', $request->user_id)
            ->where('session', $request->session)
            ->first();

        if ($attendance) {
            $attendance->delete();
            return response()->json(['status' => 'deleted']);
        }

        Attendance::create([
            'user_id' => $request->user_id,
            'session' => $request->session,
            'status' => 'hadir',
            'recorded_by' => auth()->id(),
        ]);

        return response()->json(['status' => 'created']);
    }

    // create session
    public function createSession(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Attendance::create([
            'user_id' => 0,
            'session' => $request->name,
            'status' => 'session_marker',
        ]);

        return back();
    }

    // delete session
    public function deleteSession($session)
    {
        Attendance::where('session', $session)->delete();
        return back();
    }
}