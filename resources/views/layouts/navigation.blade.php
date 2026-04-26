@php
    $user = auth()->user();
@endphp

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- LEFT -->
            <div class="flex">

                <!-- LOGO -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- MENU -->
                <div class="hidden space-x-8 sm:ms-10 sm:flex">

                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>

                    <x-nav-link :href="route('tasks.index')" :active="request()->routeIs('tasks.*')">
                        Task
                    </x-nav-link>

                    <x-nav-link :href="route('monitoring.index')" :active="request()->routeIs('monitoring.*')">
                        Monitoring
                    </x-nav-link>

                    @if($user && $user->role === 'ketua')
                        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                            Users
                        </x-nav-link>

                        <x-nav-link :href="route('divisions.index')" :active="request()->routeIs('divisions.*')">
                            Divisi
                        </x-nav-link>

                        <x-nav-link :href="route('attendance.index')" :active="request()->routeIs('attendance.*')">
                            Presensi
                        </x-nav-link>
                    @endif

                </div>
            </div>

            <!-- RIGHT -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">

                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm text-gray-500 hover:text-gray-700">
                            <div>{{ $user?->name }}</div>
                        </button>
                    </x-slot>

                    <x-slot name="content">

                        {{-- PROFILE (optional) --}}
                        @if(Route::has('profile.edit'))
                            <x-dropdown-link :href="route('profile.edit')">
                                Profile
                            </x-dropdown-link>
                        @endif

                        <!-- 🔥 FIX LOGOUT -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left">
                            Logout
                            </button>
                        </form>

                    </x-slot>

                </x-dropdown>
            </div>

            <!-- MOBILE BUTTON -->
            <div class="sm:hidden flex items-center">
                <button @click="open = !open">
                    ☰
                </button>
            </div>

        </div>
    </div>

</nav>