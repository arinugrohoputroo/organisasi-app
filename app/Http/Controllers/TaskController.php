<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskSubmission;
use App\Models\Division;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    // LIST TASK + DIVISION (WAJIB ADA)
    public function index()
    {
        return view('tasks.index', [
            'tasks' => Task::with('division')->latest()->get(),
            'divisions' => Division::all(),
        ]);
    }

    // CREATE TASK
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'division_id' => $request->division_id,
            'due_date' => $request->due_date,
            'created_by' => auth()->id()
        ]);

        return back()->with('success', 'Task berhasil dibuat');
    }

    // DETAIL / PREVIEW TASK (INI YANG KAMU BILANG HILANG)
    public function show(Task $task)
    {
        return view('tasks.show', [
            'task' => $task->load('division', 'submissions.user')
        ]);
    }

    // DELETE TASK (KETUA ONLY)
    public function destroy(Task $task)
    {
        if (auth()->user()->role !== 'ketua') {
            abort(403, 'Akses ditolak');
        }

        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Task dihapus');
    }

    // SUBMIT TASK (ANGGOTA)
    public function submit(Request $request, Task $task)
    {
        $request->validate([
            'content' => 'required|string',
            'file' => 'nullable|file|max:10240'
        ]);

        $filePath = null;

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $filePath = $request->file('file')->store('submissions', 'public');
        }

        TaskSubmission::create([
            'task_id' => $task->id,
            'user_id' => auth()->id(),
            'content' => $request->content,
            'file_path' => $filePath,
        ]);

        return back()->with('success', 'Task berhasil disubmit');
    }

    // DELETE SUBMISSION (OWNER ATAU KETUA)
    public function deleteSubmission(TaskSubmission $submission)
    {
        if (
            auth()->id() !== $submission->user_id &&
            auth()->user()->role !== 'ketua'
        ) {
            abort(403, 'Akses ditolak');
        }

        if ($submission->file_path) {
            Storage::disk('public')->delete($submission->file_path);
        }

        $submission->delete();

        return back()->with('success', 'Submission dihapus');
    }
}