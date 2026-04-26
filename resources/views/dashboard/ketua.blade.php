<x-app-layout>

<div class="p-6 space-y-6">

    <h2 class="text-xl font-bold">
        MATRIX PRESENSI FINAL
    </h2>

    {{-- ================= INPUT ================= --}}
    <form method="POST" action="{{ route('attendance.store') }}"
        class="bg-white p-4 rounded shadow space-y-4">
        @csrf

        {{-- SESSION SELECT --}}
        <div>
            <label class="font-medium">Pilih Session Lama</label>
            <select name="session" class="border p-2 w-full rounded">
                <option value="">-- pilih session --</option>

                @foreach($sessions as $s)
                    <option value="{{ $s }}">{{ $s }}</option>
                @endforeach
            </select>
        </div>

        {{-- SESSION BARU --}}
        <div>
            <label class="font-medium">Atau Tambah Session Baru</label>
            <input type="text"
                name="new_session"
                placeholder="contoh: session-3 / 2026-04-30"
                class="border p-2 w-full rounded">
        </div>

        {{-- USER LIST --}}
        <div class="space-y-2">

            @foreach($users as $user)
                <div class="flex justify-between border-b py-2">

                    <span>{{ $user->name }}</span>

                    <select name="status[{{ $user->id }}]"
                        class="border p-1 rounded">
                        <option value="hadir">Hadir</option>
                        <option value="izin">Izin</option>
                        <option value="alpha">Alpha</option>
                    </select>

                </div>
            @endforeach

        </div>

        <button class="bg-green-600 text-white px-4 py-2 rounded">
            Simpan Presensi
        </button>

    </form>

    {{-- ================= MATRIX ================= --}}
    <div class="bg-white p-4 rounded shadow overflow-x-auto">

        <table class="w-full border text-sm">

            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-2 text-left">Nama</th>

                    @foreach($sessions as $session)
                        <th class="border p-2">{{ $session }}</th>
                    @endforeach

                    <th class="border p-2">Total</th>
                    <th class="border p-2">%</th>
                </tr>
            </thead>

            <tbody>

                @foreach($users as $user)
                    <tr>

                        <td class="border p-2 font-semibold">
                            {{ $user->name }}
                        </td>

                        @foreach($sessions as $session)

                            @php
                                $att = $attendances[$user->id][$session][0] ?? null;
                            @endphp

                            <td class="border p-2 text-center">

                                @if($att)
                                    @if($att->status == 'hadir')
                                        ✔
                                    @elseif($att->status == 'izin')
                                        I
                                    @else
                                        ✘
                                    @endif

                                    {{-- DELETE --}}
                                    <form method="POST"
                                        action="/attendance/{{ $att->id }}"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')

                                        <button class="text-red-500 text-xs">
                                            x
                                        </button>
                                    </form>

                                @else
                                    -
                                @endif

                            </td>

                        @endforeach

                        <td class="border p-2 text-center font-bold">
                            {{ $summary[$user->id]['hadir'] ?? 0 }}
                            /
                            {{ $summary[$user->id]['total'] ?? 0 }}
                        </td>

                        <td class="border p-2 text-center font-bold">
                            {{ $summary[$user->id]['percent'] ?? 0 }}%
                        </td>

                    </tr>
                @endforeach

            </tbody>

        </table>

    </div>

</div>

</x-app-layout>