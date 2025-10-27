<x-app-layout>
    <x-slot name="header">
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold text-white mb-4">Admin - Pending & Deleted verhalen</h2>

                @if(session('success'))
                    <div class="mb-4 text-green-400">{{ session('success') }}</div>
                @endif
                <h3 class="text-lg font-semibold text-white mb-2">In afwachting</h3>
                @if($pending->isEmpty())
                    <p class="text-gray-400 mb-4">Geen verhalen in afwachting.</p>
                @else
                    <div class="flex flex-col gap-3 mb-6">
                        @foreach($pending as $story)
                            <div class="bg-gray-900/40 p-4 rounded border border-gray-800 flex justify-between">
                                <div>
                                    <div class="text-lg font-semibold text-white">{{ $story->name }}</div>
                                    <div class="text-xs text-white">Door: {{ $story->user_name ?? 'Onbekend' }}
                                        • {{ $story->category->name ?? '-' }}</div>
                                    <div class="mt-2 text-gray-200 whitespace-pre-line text-sm">{{ $story->text }}</div>
                                </div>
                                <div class="ml-4 flex flex-col gap-2">
                                    <form action="{{ route('admin.story.approve', $story) }}" method="POST">
                                        @csrf
                                        <button class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                                            Keur goed
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.story.reject', $story) }}" method="POST"
                                          onsubmit="return confirm('Weet je zeker dat je dit verhaal wilt afwijzen en verwijderen?');">
                                        @csrf
                                        <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                            Afwijzen
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
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
                                    <div class="text-xs text-gray-500 mt-2">Verwijderd
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
