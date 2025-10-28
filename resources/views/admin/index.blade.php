<x-app-layout>
    <x-slot name="header">
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold text-white mb-4">Admin - Alle & Verwijderde verhalen</h2>

                @if(session('success'))
                    <div class="mb-4 text-green-400">{{ session('success') }}</div>
                @endif
                @php $tab = request()->get('tab', 'all'); @endphp
                <div class="mb-4">
                    <nav class="flex space-x-2">
                        <a href="{{ route('admin.index', ['tab' => 'all']) }}"
                           class="px-3 py-1 rounded {{ $tab === 'all' ? 'bg-gray-800 text-white' : 'bg-gray-700/40 text-gray-300' }}">
                            Alle verhalen
                        </a>
                        <a href="{{ route('admin.index', ['tab' => 'pending']) }}"
                           class="px-3 py-1 rounded {{ $tab === 'pending' ? 'bg-yellow-500 text-white' : 'bg-gray-700/40 text-gray-300' }}">
                            Pending ({{ $pending->count() }})
                        </a>
                    </nav>
                </div>

                @if($tab === 'pending')
                    <h3 class="text-lg font-semibold text-white mb-2">Pending verhalen</h3>
                    @if($pending->isEmpty())
                        <p class="text-gray-400 mb-4">Geen pending verhalen gevonden.</p>
                    @else
                        <div class="flex flex-col gap-3 mb-6">
                            @foreach($pending as $story)
                                <div class="bg-gray-900/40 p-4 rounded border border-gray-800 flex justify-between">
                                    <div>
                                        <div class="flex items-center gap-3">
                                            <div class="text-lg font-semibold text-white">{{ $story->name }}</div>
                                            <span class="text-xs bg-yellow-500 text-white px-2 py-0.5 rounded">Unpublished</span>
                                        </div>

                                        <div class="text-xs text-white">Door: {{ $story->user_name ?? 'Onbekend' }}
                                            • {{ $story->category->name ?? '-' }}</div>
                                        <div
                                            class="mt-2 text-white whitespace-pre-line text-sm">{{ $story->text }}
                                        </div>
                                        <img src="{{ asset('storage/' . $story->file_path) }}" alt="Story Image"
                                             class="mt-2 max-w-xs rounded text-white">
                                    </div>
                                    <div class="ml-4 flex flex-col gap-2">
                                        <form action="{{ route('admin.story.approve', $story) }}" method="POST">
                                            @csrf
                                            <button
                                                class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                                                Activeer
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.story.reject', $story) }}" method="POST"
                                              onsubmit="return confirm('Weet je zeker dat je dit verhaal wilt afwijzen en verwijderen?');">
                                            @csrf
                                            <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                                Afwijzen / Verwijderen
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @else
                    <h3 class="text-lg font-semibold text-white mb-2">Alle verhalen</h3>
                    @if($stories->isEmpty())
                        <p class="text-gray-400 mb-4">Geen verhalen gevonden.</p>
                    @else
                        <div class="flex flex-col gap-3 mb-6">
                            @foreach($stories as $story)
                                <div class="bg-gray-900/40 p-4 rounded border border-gray-800 flex justify-between">
                                    <div>
                                        <div class="flex items-center gap-3">
                                            <div class="text-lg font-semibold text-white">{{ $story->name }}</div>
                                            @if($story->published)
                                                <span class="text-xs bg-green-600 text-white px-2 py-0.5 rounded">Published</span>
                                            @else
                                                <span class="text-xs bg-yellow-600 text-white px-2 py-0.5 rounded">Unpublished</span>
                                            @endif
                                        </div>

                                        <div class="text-xs text-white">Door: {{ $story->user_name ?? 'Onbekend' }}
                                            • {{ $story->category->name ?? '-' }}</div>
                                        <div
                                            class="mt-2 text-white whitespace-pre-line text-sm">{{ $story->text }}</div>
                                        <img src="{{ asset('storage/' . $story->file_path) }}" alt="Story Image"
                                             class="mt-2 max-w-xs rounded text-white">
                                    </div>
                                    <div class="ml-4 flex flex-col gap-2">
                                        @if(!$story->published)
                                            <form action="{{ route('admin.story.approve', $story) }}" method="POST">
                                                @csrf
                                                <button
                                                    class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                                                    Activeer
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.story.deactivate', $story) }}" method="POST">
                                                @csrf
                                                <button
                                                    class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                                    Deactiveer
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('admin.story.reject', $story) }}" method="POST"
                                              onsubmit="return confirm('Weet je zeker dat je dit verhaal wilt afwijzen en verwijderen?');">
                                            @csrf
                                            <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                                Afwijzen / Verwijderen
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endif

                <h3 class="text-lg font-semibold text-white mb-2">Verwijderde verhalen</h3>
                @if($trashed->isEmpty())
                    <p class="text-gray-400">Geen verwijderde verhalen.</p>
                @else
                    <div class="flex flex-col gap-3">
                        @foreach($trashed as $story)
                            <div
                                class="bg-gray-900/30 p-4 rounded border border-gray-800 flex justify-between items-start">
                                <div>
                                    <div class="text-lg font-semibold text-white">{{ $story->name }}</div>
                                    <div class="text-xs text-white">Door: {{ $story->user_name ?? 'Onbekend' }}
                                        • {{ $story->category->name ?? '-' }}</div>
                                    <div class="mt-2 text-white whitespace-pre-line text-sm">{{ $story->text }}</div>
                                    <img src="{{ asset('storage/' . $story->file_path) }}" alt="Story Image"
                                         class="mt-2 max-w-xs rounded text-white">
                                    <div class="text-xs text-white mt-2">Verwijderd
                                        op: {{ $story->deleted_at?->format('Y-m-d H:i') }}</div>
                                </div>

                                <div class="ml-4 flex flex-col gap-6">
                                    <form action="{{ route('admin.story.restore', $story->id) }}" method="POST">
                                        @csrf
                                        <button
                                            class="px-3 py-1 bg-green-500 text-white rounded hover:bg-white hover:text-green-500 hover:border-green-500">
                                            Herstellen
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.story.forceDelete', $story->id) }}" method="POST"
                                          onsubmit="return confirm('Permanente verwijdering: weet je het zeker?');">
                                        @csrf
                                        <button
                                            class="px-3 py-1 bg-red-600 text-white rounded hover:bg-white hover:text-red-600 hover:border-red-600">
                                            Permanent verwijderen
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </x-slot>
</x-app-layout>
