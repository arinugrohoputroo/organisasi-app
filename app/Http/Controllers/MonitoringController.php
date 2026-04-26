<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Division;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        $baseQuery = Task::query();

        // FILTER DIVISI
        if ($request->division_id) {
            $baseQuery->where('division_id', $request->division_id);
        }

        // TASK + SUBMISSION
        $tasks = (clone $baseQuery)
            ->with('submissions')
            ->get();

        // TOTAL TASK
        $total = (clone $baseQuery)->count();

        // TASK SELESAI
        $done = (clone $baseQuery)
            ->whereHas('submissions')
            ->count();

        // TASK BELUM
        $pending = $total - $done;

        // PROGRESS %
        $progress = $total
            ? round(($done / $total) * 100, 1)
            : 0;

        return view('monitoring.index', [
            'tasks' => $tasks,
            'total' => $total,
            'done' => $done,
            'pending' => $pending,

            'progressData' => [
                'value' => $progress,
                'color' => match (true) {
                    $progress <= 30 => 'bg-red-500',
                    $progress <= 70 => 'bg-yellow-500',
                    default => 'bg-green-500',
                }
            ],

            'divisions' => Division::all(),
            'selected' => $request->division_id
        ]);
    }
}