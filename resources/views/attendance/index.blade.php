<x-app-layout>

<x-slot name="header">
    <h2 class="font-bold text-xl">Presensi Matrix</h2>
</x-slot>

<div class="p-6">

    <!-- CREATE SESSION -->
    <form method="POST" action="{{ route('attendance.session.create') }}" class="mb-4 flex gap-2">
        @csrf
        <input name="name" placeholder="Session (Week 1)" class="border p-2 rounded">
        <button class="bg-blue-600 text-white px-3 rounded">+ Session</button>
    </form>

    <!-- TABLE -->
    <div class="overflow-x-auto">
        <table class="w-full border">

            <thead>
                <tr>
                    <th class="border p-2">Nama</th>

                    @foreach($sessions as $session)
                        <th class="border p-2">
                            <div class="flex justify-between items-center">
                                {{ $session }}

                                <form method="POST"
                                      action="{{ route('attendance.session.delete', $session) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-500 text-xs">x</button>
                                </form>
                            </div>
                        </th>
                    @endforeach
                </tr>
            </thead>

            <tbody>
                @foreach($users as $user)
                <tr>
                    <td class="border p-2">{{ $user->name }}</td>

                    @foreach($sessions as $session)
                        @php
                            $exists = isset($attendances[$user->id][$session]);
                        @endphp

                        <td class="border text-center">

                            <button
                                class="w-5 h-5 rounded-full mx-auto
                                {{ $exists ? 'bg-green-500' : 'bg-gray-300' }}"
                                onclick="toggle({{ $user->id }}, '{{ $session }}')">
                            </button>

                        </td>
                    @endforeach

                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>

<script>
function toggle(user_id, session) {
    fetch("{{ route('attendance.toggle') }}", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ user_id, session })
    })
    .then(() => location.reload());
}
</script>

</x-app-layout>