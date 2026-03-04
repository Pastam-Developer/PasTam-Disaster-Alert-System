<nav class="bg-[#1E88E5] border-b border-gray-200 sticky top-0 z-20">
    <div class="px-6 py-3 flex items-center justify-between">
        <div class="flex items-center">
            <button class="text-white focus:outline-none mr-4" onclick="toggleSidebar()">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>

            <div class="flex items-center">
                @if(file_exists(public_path('images/logo.png')))
                    {{-- <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" class="h-8"> --}}
                    <h1 class="text-white font-semibold ml-2 text-xl">Risk Disaster Management</h1>
                @else
                    <div class="logo-placeholder">{{ substr(config('app.name', 'L'), 0, 1) }}</div>
                    <span class="ml-2 text-xl font-semibold text-white">{{ config('app.name', 'Laravel') }}</span>
                @endif
            </div>
        </div>

        <div class="flex items-center">
            <form method="GET" action="{{ route('incidents.index', [], false) }}" class="relative mr-4 hidden md:block">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fa-solid fa-search text-gray-400"></i>
                </div>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search incidents..."
                    class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
            </form>

            @php
                $pendingNotifications = \App\Models\IncidentReport::pending()->orderByDesc('created_at')->limit(5)->get();
                $pendingCount = \App\Models\IncidentReport::pending()->count();
            @endphp

            <div class="ml-4 relative">
                <button
                    id="notificationsButton"
                    type="button"
                    class="p-2 text-white hover:text-blue-700 focus:outline-none relative"
                    aria-haspopup="true"
                    aria-expanded="false"
                >
                    <i class="fa-solid fa-bell text-xl"></i>
                    @if($pendingCount > 0)
                        <span class="absolute top-0 right-0 bg-red-500 text-white rounded-full min-w-4 h-4 px-1 text-[10px] flex items-center justify-center">
                            {{ $pendingCount > 99 ? '99+' : $pendingCount }}
                        </span>
                    @endif
                </button>

                <div
                    id="notificationsDropdown"
                    class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-200 overflow-hidden"
                    role="menu"
                >
                    <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <span class="font-semibold text-gray-800">Pending Reports</span>
                            <a href="{{ route('incidents.index', ['status' => 'pending'], false) }}" class="text-sm text-blue-600 hover:text-blue-800">View all</a>
                        </div>
                    </div>
                    <div class="max-h-96 overflow-y-auto">
                        @forelse($pendingNotifications as $incident)
                            <a
                                href="{{ route('incidents.show', $incident->id, false) }}"
                                class="block px-4 py-3 hover:bg-gray-50"
                                role="menuitem"
                            >
                                <div class="text-sm font-medium text-gray-900">{{ \Illuminate\Support\Str::limit($incident->title, 60) }}</div>
                                <div class="text-xs text-gray-500 mt-1">{{ $incident->created_at->diffForHumans() }} • {{ \Illuminate\Support\Str::limit($incident->location, 40) }}</div>
                            </a>
                        @empty
                            <div class="px-4 py-6 text-center text-sm text-gray-500">No pending incidents.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="ml-4 relative">
                <button class="flex items-center focus:outline-none">
                    <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold">U</div>
                       <p class="text-sm font-medium text-white">
                            {{-- {{ auth()->user()->first_name }} {{ auth()->user()->last_name }} --}}
                        </p>
                </button>
            </div>
        </div>
    </div>
</nav>
