<x-app-layout>
    <div class="p-6">

        {{-- ================= TASK INFO ================= --}}
        <div class="bg-white p-4 rounded shadow mb-4">

            <div class="flex justify-between items-center">

                <h1 class="text-2xl font-bold">
                    {{ $task->title }}
                </h1>

                @if(auth()->user()->role !== 'anggota')
                    <form method="POST" action="{{ route('tasks.delete', $task->id) }}">
                        @csrf
                        @method('DELETE')

                        <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                            Hapus
                        </button>
                    </form>
                @endif

            </div>

            <p class="text-gray-500">
                Divisi: {{ $task->division->name }}
            </p>

            <p class="mt-2">
                {{ $task->description }}
            </p>

            <p class="text-red-500 mt-2 font-semibold">
                Deadline: {{ $task->due_date }}
            </p>

        </div>

        {{-- ================= SUBMIT FORM ================= --}}
        @if(auth()->user()->role === 'anggota')

        <div class="bg-white p-4 rounded shadow mb-4">

            <h2 class="font-semibold mb-3">Submit Task</h2>

            @if($errors->any())
                <div class="bg-red-100 text-red-700 p-2 rounded mb-3 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-2 rounded mb-3 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST"
                  action="{{ route('tasks.submit', $task->id) }}"
                  enctype="multipart/form-data">

                @csrf

                <textarea name="content"
                    class="w-full border p-2 rounded mb-2"
                    placeholder="Hasil pekerjaan..."
                    required></textarea>

                <input type="file"
                    name="file"
                    accept=".jpg,.jpeg,.png,.webp,.pdf"
                    class="w-full border p-2 rounded mb-3">

                <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                    Submit Task
                </button>

            </form>

        </div>

        @endif

        {{-- ================= SUBMISSION LIST ================= --}}
        <div class="bg-white p-4 rounded shadow">

            <h2 class="font-bold mb-3">Hasil Submission</h2>

            @forelse($task->submissions as $submission)

                <div class="border-b py-4">

                    <div class="flex justify-between items-start gap-4">

                        <div class="w-full">

                            <p class="text-sm text-gray-600 font-semibold">
                                {{ $submission->user->name }}
                            </p>

                            <p class="text-gray-800">
                                {{ $submission->content }}
                            </p>

                            {{-- ================= FILE PREVIEW ================= --}}
                            @if(!empty($submission->file_path))

                                @php
                                    $fileUrl = asset('storage/' . $submission->file_path);
                                    $ext = strtolower(pathinfo($submission->file_path, PATHINFO_EXTENSION));
                                @endphp

                                <div class="mt-3">

                                    <p class="text-sm font-semibold mb-2">
                                        📎 Klik file untuk fullscreen
                                    </p>

                                    {{-- IMAGE --}}
                                    @if(in_array($ext, ['jpg','jpeg','png','webp']))
                                        <img src="{{ $fileUrl }}"
                                             class="max-w-xs md:max-w-md rounded shadow border cursor-pointer"
                                             onclick="openPreview('{{ $fileUrl }}','image')">

                                    {{-- PDF --}}
                                    @elseif($ext === 'pdf')
                                        <button onclick="openPreview('{{ $fileUrl }}','pdf')"
                                                class="text-blue-600 underline">
                                            Lihat PDF Fullscreen
                                        </button>

                                    @else
                                        <a href="{{ $fileUrl }}" target="_blank" class="text-blue-600 underline">
                                            Download File
                                        </a>
                                    @endif

                                </div>

                            @endif

                        </div>

                        {{-- DELETE --}}
                        @if(auth()->id() === $submission->user_id || auth()->user()->role !== 'anggota')

                            <form method="POST"
                                  action="{{ route('submission.delete', $submission->id) }}"
                                  onsubmit="return confirm('Yakin mau hapus submission ini?')">

                                @csrf
                                @method('DELETE')

                                <button class="text-red-600 text-sm underline">
                                    Hapus
                                </button>

                            </form>

                        @endif

                    </div>

                </div>

            @empty
                <p class="text-gray-500">Belum ada submission</p>
            @endforelse

        </div>

    </div>

    {{-- ================= FULLSCREEN MODAL ================= --}}
    <div id="previewModal"
         class="fixed inset-0 bg-black/80 hidden items-center justify-center z-50">

        <div class="relative w-full h-full flex items-center justify-center">

            {{-- CLOSE --}}
            <button onclick="closePreview()"
                    class="absolute top-4 right-4 bg-red-500 text-white px-3 py-1 rounded z-50">
                ✕
            </button>

            {{-- FULLSCREEN BUTTON --}}
            <button onclick="toggleFullScreen()"
                    class="absolute top-4 left-4 bg-blue-500 text-white px-3 py-1 rounded z-50">
                ⛶ Fullscreen
            </button>

            <div id="previewContent"
                 class="w-full h-full flex items-center justify-center p-4">
            </div>

        </div>

    </div>

    {{-- ================= SCRIPT ================= --}}
    <script>
        function openPreview(url, type) {

            let content = document.getElementById('previewContent');

            if (type === 'image') {
                content.innerHTML = `
                    <img src="${url}"
                         class="max-h-[90vh] max-w-[95vw] object-contain">
                `;
            }

            if (type === 'pdf') {
                content.innerHTML = `
                    <iframe src="${url}"
                            class="w-full h-[90vh]"></iframe>
                `;
            }

            document.getElementById('previewModal').classList.remove('hidden');
            document.getElementById('previewModal').classList.add('flex');

            // auto fullscreen (browser supported)
            if (document.documentElement.requestFullscreen) {
                document.documentElement.requestFullscreen().catch(()=>{});
            }

            // optional orientation lock (ONLY mobile support)
            if (screen.orientation && screen.orientation.lock) {
                screen.orientation.lock('landscape').catch(()=>{});
            }
        }

        function closePreview() {

            document.getElementById('previewModal').classList.add('hidden');
            document.getElementById('previewModal').classList.remove('flex');

            document.getElementById('previewContent').innerHTML = '';

            // exit fullscreen
            if (document.exitFullscreen) {
                document.exitFullscreen().catch(()=>{});
            }
        }

        function toggleFullScreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
            } else {
                document.exitFullscreen();
            }
        }
    </script>

</x-app-layout>