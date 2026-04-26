<x-app-layout>
    <div class="p-6">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Divisi</h1>

            @if(auth()->user()->role === 'ketua')
            <button onclick="document.getElementById('modal').classList.remove('hidden')"
                class="bg-blue-500 text-white px-4 py-2 rounded">
                + Tambah Divisi
            </button>
            @endif
        </div>

        <!-- LIST DIVISI -->
        <div class="grid grid-cols-3 gap-4">

            @foreach($divisions as $division)
    <div class="bg-white p-4 rounded shadow">

        <h2 class="font-semibold text-lg">{{ $division->name }}</h2>

        <p class="text-sm text-gray-500">
            Dibuat oleh: {{ $division->created_by }}
        </p>

    <div class="mt-3">
    <p class="text-sm font-semibold">Anggota:</p>

    @forelse($division->users->unique('id') as $user)
        <div class="flex justify-between text-sm text-gray-600">
            <span>{{ $user->name }} ({{ $user->role }})</span>
        </div>
    @empty
        <p class="text-sm text-gray-400">Belum ada anggota</p>
    @endforelse
</div>

        <!-- 🔽 TAMBAH DI SINI -->
        <form method="POST" action="{{ route('divisions.assign', $division->id) }}" class="mt-3">
            @csrf

            <select name="user_id" class="border p-1 w-full mb-2">
    <option value="">-- Pilih User --</option>

    @foreach(\App\Models\User::whereNotIn('id', $division->users->pluck('id'))->get() as $user)
        <option value="{{ $user->id }}">
            {{ $user->name }} ({{ $user->role }})
        </option>
    @endforeach
            </select>

            <button class="bg-green-500 text-white px-2 py-1 rounded w-full">
                + Tambah Anggota
            </button>
        </form>

    </div>
@endforeach

        </div>

    </div>

    <!-- MODAL CREATE -->
    <div id="modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">

        <div class="bg-white p-6 rounded w-96">

            <h2 class="text-xl font-bold mb-4">Tambah Divisi</h2>

            <form method="POST" action="{{ route('divisions.store') }}">
                @csrf

                <input type="text" name="name"
                       class="w-full border p-2 rounded mb-4"
                       placeholder="Nama Divisi">

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