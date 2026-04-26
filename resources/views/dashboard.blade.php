<h1 class="text-xl font-bold mb-4">Dashboard</h1>

@if(auth()->user()->role === 'ketua')

    <h2>Ketua Panel</h2>
    <p>Total User: {{ count($data['users']) }}</p>

@elseif(auth()->user()->role === 'koordinator')

    <h2>Koordinator Panel</h2>

    @foreach($data['tasks'] as $task)
        <div>{{ $task->title }}</div>
    @endforeach

@else

    <h2>Anggota Panel</h2>
    <p>Total Task: {{ $data['total'] }}</p>

@endif