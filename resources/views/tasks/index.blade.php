<x-app-layout>
    <div class="p-6">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Tasks</h1>

            <button onclick="document.getElementById('modal').classList.remove('hidden')"
                class="bg-blue-500 text-white px-4 py-2 rounded">
                + Tambah Task
            </button>
        </div>

        <!-- LIST TASK -->
        <div class="grid grid-cols-2 gap-4">

            @foreach($tasks as $task)
                <div class="bg-white p-4 rounded shadow">

                    <a href="{{ route('tasks.show', $task->id) }}" class="font-semibold text-lg text-blue-600">
                    {{ $task->title }}
                    </a>

                    <p class="text-sm text-gray-500">
                        Divisi: {{ $task->division->name }}
                    </p>

                    <p class="text-sm mt-2">
                        {{ $task->description }}
                    </p>

                    <p class="text-xs text-red-500 mt-2">
                        Deadline: {{ $task->due_date }}
                    </p>

                </div>
            @endforeach

        </div>

    </div>

    <!-- MODAL CREATE TASK -->
    <div id="modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">

        <div class="bg-white p-6 rounded w-96">

            <h2 class="text-xl font-bold mb-4">Tambah Task</h2>

            <form method="POST" action="{{ route('tasks.store') }}">
                @csrf

                <input type="text" name="title"
                    class="w-full border p-2 rounded mb-3"
                    placeholder="Judul Task">

                <textarea name="description"
                    class="w-full border p-2 rounded mb-3"
                    placeholder="Deskripsi"></textarea>

                <select name="division_id"
                    class="w-full border p-2 rounded mb-3">
                    @foreach($divisions as $division)
                        <option value="{{ $division->id }}">
                            {{ $division->name }}
                        </option>
                    @endforeach
                </select>

                <input type="date" name="due_date"
                    class="w-full border p-2 rounded mb-3">

                <div class="flex justify-end gap-2">

                    <button type="button"
                        onclick="document.getElementById('modal').classList.add('hidden')"
                        class="px-4 py-2 bg-gray-300 rounded">
                        Cancel
                    </button>

                    <button class="px-4 py-2 bg-blue-500 text-white rounded">
                        Simpan
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>