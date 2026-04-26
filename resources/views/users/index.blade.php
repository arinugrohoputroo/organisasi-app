<x-app-layout>
    <div class="p-6">

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">User Management</h1>

            <button onclick="document.getElementById('modal').classList.remove('hidden')"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">
                + Tambah User
            </button>
        </div>

        <!-- LIST USER -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach($users as $user)
                <div class="bg-white p-5 rounded-lg shadow hover:shadow-md transition">

                    <!-- NAME -->
                    <h2 class="font-semibold text-lg mb-1">
                        {{ $user->name }}
                    </h2>

                    <!-- EMAIL -->
                    <p class="text-sm text-gray-500">
                        {{ $user->email }}
                    </p>

                    <!-- ROLE BADGE -->
                    <span class="inline-block mt-3 px-3 py-1 text-xs font-semibold bg-gray-200 rounded-full">
                        {{ ucfirst($user->role) }}
                    </span>

                    <!-- ACTION -->
                    @if(auth()->user()->role === 'ketua' && auth()->id() !== $user->id)
                    <form method="POST"
                          action="{{ route('users.delete', $user->id) }}"
                          class="mt-4">

                        @csrf
                        @method('DELETE')

                        <button onclick="return confirm('Yakin hapus user ini?')"
                            class="w-full bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded">
                            Hapus User
                        </button>

                    </form>
                    @endif

                </div>
            @endforeach

        </div>

    </div>

    <!-- MODAL CREATE USER -->
    <div id="modal"
         class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">

        <div class="bg-white p-6 rounded-lg w-96 shadow-lg">

            <h2 class="text-xl font-bold mb-4">Tambah User</h2>

            <form method="POST" action="{{ route('users.store') }}">
                @csrf

                <input type="text" name="name"
                    class="w-full border p-2 rounded mb-3"
                    placeholder="Nama">

                <input type="email" name="email"
                    class="w-full border p-2 rounded mb-3"
                    placeholder="Email">

                <input type="password" name="password"
                    class="w-full border p-2 rounded mb-3"
                    placeholder="Password">

                <select name="role"
                    class="w-full border p-2 rounded mb-4">
                    <option value="ketua">Ketua</option>
                    <option value="koordinator">Koordinator</option>
                    <option value="anggota">Anggota</option>
                </select>

                <div class="flex justify-end gap-2">

                    <button type="button"
                        onclick="document.getElementById('modal').classList.add('hidden')"
                        class="px-4 py-2 bg-gray-300 rounded">
                        Cancel
                    </button>

                    <button class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded">
                        Simpan
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>