<x-app-layout>

<div class="min-h-screen bg-gray-50">

    <!-- HEADER -->
    <div class="bg-gradient-to-r from-indigo-600 to-blue-500 text-white p-6 rounded-b-3xl shadow">
        <h1 class="text-2xl font-bold">
            Welcome back, {{ $user->name ?? '-' }}
        </h1>
        <p class="text-sm opacity-80">
            SaaS Dashboard Overview
        </p>
    </div>

    <!-- CONTENT -->
    <div class="max-w-7xl mx-auto p-6 space-y-6">

        <!-- STATS -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <!-- USERS -->
            <div class="bg-white p-5 rounded-2xl shadow hover:shadow-lg transition">
                <p class="text-gray-500 text-sm">Total Users</p>
                <h2 class="text-2xl font-bold text-indigo-600">
                    {{ $totalUsers ?? 0 }}
                </h2>
            </div>

            <!-- TASKS -->
            <div class="bg-white p-5 rounded-2xl shadow hover:shadow-lg transition">
                <p class="text-gray-500 text-sm">Total Tasks</p>
                <h2 class="text-2xl font-bold text-blue-600">
                    {{ $totalTasks ?? 0 }}
                </h2>
            </div>

            <!-- ATTENDANCE -->
            <div class="bg-white p-5 rounded-2xl shadow hover:shadow-lg transition">
                <p class="text-gray-500 text-sm">Total Attendance</p>
                <h2 class="text-2xl font-bold text-green-600">
                    {{ $totalAttendances ?? 0 }}
                </h2>
            </div>

            <!-- TODAY -->
            <div class="bg-white p-5 rounded-2xl shadow hover:shadow-lg transition">
                <p class="text-gray-500 text-sm">Hadir Hari Ini</p>
                <h2 class="text-2xl font-bold text-emerald-600">
                    {{ $hadir ?? 0 }}
                </h2>
            </div>

        </div>

        <!-- GRID CONTENT -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- RECENT TASK -->
            <div class="bg-white rounded-2xl shadow p-5">
                <h3 class="font-semibold mb-4">Recent Tasks</h3>

                <div class="space-y-3">
                    @forelse($latestTasks as $task)
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="font-medium">{{ $task->title }}</p>
                            <p class="text-xs text-gray-500">
                                {{ $task->created_at->diffForHumans() }}
                            </p>
                        </div>
                    @empty
                        <p class="text-gray-400 text-sm">No tasks yet</p>
                    @endforelse
                </div>
            </div>

            <!-- RECENT ATTENDANCE -->
            <div class="bg-white rounded-2xl shadow p-5">
                <h3 class="font-semibold mb-4">Recent Attendance</h3>

                <div class="space-y-3">
                    @forelse($recentAttendances as $att)
                        <div class="p-3 bg-gray-50 rounded-lg flex justify-between">
                            <div>
                                <p class="font-medium">
                                    {{ $att->user->name ?? 'User' }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $att->created_at->diffForHumans() }}
                                </p>
                            </div>

                            <span class="text-green-500 text-sm font-semibold">
                                Present
                            </span>
                        </div>
                    @empty
                        <p class="text-gray-400 text-sm">No attendance yet</p>
                    @endforelse
                </div>
            </div>

        </div>

    </div>
</div>

</x-app-layout>