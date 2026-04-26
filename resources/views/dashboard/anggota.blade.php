<div class="bg-white p-4 rounded shadow">

    <h2 class="font-bold mb-2">Status Kehadiran Hari Ini</h2>

    <p>Total Anggota: {{ $total ?? 0 }}</p>
    <p>Hadir: {{ $hadir ?? 0 }}</p>

    @php
        $percent = ($total ?? 0) > 0
            ? (($hadir ?? 0) / $total) * 100
            : 0;
    @endphp

    <div class="w-full bg-gray-200 rounded h-6 overflow-hidden mt-2">

        <div class="bg-blue-500 text-white text-xs flex items-center justify-center h-6 transition-all duration-500"
             style="width: {{ $percent }}%">
            {{ round($percent) }}%
        </div>

    </div>

</div>