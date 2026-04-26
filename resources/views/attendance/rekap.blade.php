<x-app-layout>

<div class="py-6">
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">

        <h2 class="text-2xl font-bold text-gray-800">
            Rekap Presensi
        </h2>

        <input type="text"
               placeholder="Cari nama..."
               class="border rounded-lg px-3 py-2 text-sm"
               id="searchBox">

    </div>

    <!-- TABLE CARD -->
    <div class="bg-white shadow rounded-xl overflow-hidden border">

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <!-- HEADER -->
                <thead class="bg-gray-50 text-gray-600 sticky top-0">
                    <tr>
                        <th class="p-4 text-left">Nama</th>

                        @foreach($sessions as $session)
                            <th class="p-4 text-center whitespace-nowrap">
                                <span class="px-2 py-1 bg-gray-200 rounded text-xs">
                                    {{ $session }}
                                </span>
                            </th>
                        @endforeach

                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <!-- BODY -->
                <tbody id="tableBody" class="divide-y">

                @foreach($users as $user)
                <tr class="hover:bg-gray-50 transition">

                    <!-- NAMA -->
                    <td class="p-4 font-semibold text-gray-800">
                        {{ $user->name }}
                    </td>

                    <!-- SESSION CELL -->
                    @foreach($sessions as $session)

                        @php
                            $record = $attendances[$user->id][$session][0] ?? null;
                        @endphp

                        <td class="p-4 text-center">

                            @if($record)

                                @if($record->status == 'hadir')
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                        Hadir
                                    </span>

                                @elseif($record->status == 'izin')
                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">
                                        Izin
                                    </span>

                                @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">
                                        Alpha
                                    </span>
                                @endif

                            @else
                                <span class="text-gray-300">-</span>
                            @endif

                        </td>

                    @endforeach

                    <!-- ACTION -->
                    <td class="p-4 text-center space-y-2">

                        @if(isset($record) && auth()->user()->role === 'ketua')

                            <!-- DELETE -->
                            <form method="POST"
                                  action="{{ route('attendance.destroy', $record->id) }}">
                                @csrf
                                @method('DELETE')

                                <button class="text-red-600 text-xs hover:underline"
                                        onclick="return confirm('Hapus presensi ini?')">
                                    Hapus
                                </button>
                            </form>

                            <!-- EDIT SESSION -->
                            <form method="POST"
                                  action="{{ route('attendance.updateSession', $record->id) }}">
                                @csrf

                                <input type="text"
                                       name="session"
                                       value="{{ $record->session }}"
                                       class="text-xs border rounded px-2 py-1 w-24">

                                <button class="text-blue-600 text-xs hover:underline">
                                    Update
                                </button>
                            </form>

                        @endif

                    </td>

                </tr>
                @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>
</div>

<!-- SEARCH JS -->
<script>
document.getElementById('searchBox').addEventListener('keyup', function () {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll('#tableBody tr');

    rows.forEach(row => {
        let name = row.children[0].innerText.toLowerCase();
        row.style.display = name.includes(filter) ? '' : 'none';
    });
});
</script>

</x-app-layout>