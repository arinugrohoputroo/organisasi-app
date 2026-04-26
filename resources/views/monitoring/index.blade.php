<x-app-layout>
    <div class="p-6">

        <h1 class="text-2xl font-bold mb-6">Monitoring Task</h1>

        <!-- FILTER DIVISI -->
        <form method="GET" class="mb-6">

            <select name="division_id" class="border p-2 rounded">
                <option value="">Semua Divisi</option>

                @foreach($divisions as $division)
                    <option value="{{ $division->id }}"
                        {{ $selected == $division->id ? 'selected' : '' }}>
                        {{ $division->name }}
                    </option>
                @endforeach

            </select>

            <button class="bg-blue-500 text-white px-3 py-2 rounded">
                Filter
            </button>

        </form>

        <!-- STAT BOX -->
        <div class="grid grid-cols-3 gap-4">

            <div class="bg-white p-4 rounded shadow text-center">
                <h2 class="text-xl font-bold">{{ $total }}</h2>
                <p>Total Task</p>
            </div>

            <div class="bg-green-100 p-4 rounded shadow text-center">
                <h2 class="text-xl font-bold">{{ $done }}</h2>
                <p>Sudah Selesai</p>
            </div>

            <div class="bg-red-100 p-4 rounded shadow text-center">
                <h2 class="text-xl font-bold">{{ $pending }}</h2>
                <p>Belum Selesai</p>
            </div>

        </div>


        <div class="mt-6 bg-white p-4 rounded shadow text-center">

            <h2 class="text-lg font-bold mb-2">Progress Pengerjaan</h2>

            <div class="text-3xl font-bold">
                {{ $progressData['value'] }}%
            </div>

            <div class="w-full bg-gray-200 rounded-full h-4 mt-3 overflow-hidden">

                <div class="{{ $progressData['color'] }} h-4 rounded-full transition-all duration-500"
                    style="width: {{ $progressData['value'] }}%">
                </div>

            </div>

        </div>

        <div class="mt-6 bg-white p-4 rounded shadow">

    <h2 class="font-bold mb-3">List Task</h2>

    @forelse($tasks as $task)

        <div class="border-b py-2">
            <p class="font-semibold">{{ $task->title }}</p>
            <p class="text-sm text-gray-500">
                Divisi: {{ $task->division_id }}
            </p>
        </div>

    @empty
        <p class="text-gray-500">Tidak ada task</p>
    @endforelse

        </div>

    </div>
</x-app-layout>