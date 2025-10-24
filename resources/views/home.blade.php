<x-app-layout>
    <x-slot name="header">
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <!-- Search form (styled) -->
                <form action="{{ route('home') }}" method="GET" class="mb-4 flex">
                    <input
                        type="text"
                        name="q"
                        value="{{ $search ?? '' }}"
                        placeholder="Zoek verhalen..."
                        class="border border-gray-700 bg-gray-800 text-gray-100 rounded-l px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                    <!-- preserve selected category when searching -->
                    <input type="hidden" name="category" value="{{ $activeCategory ?? '' }}">
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-r hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
                        Zoeken
                    </button>
                </form>

                <!-- Category tags (button-like links) -->
                <div class="mb-4 flex flex-wrap gap-2">
                    @php
                        $baseTag = 'px-4 py-1 rounded-full text-sm font-medium shadow-sm transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-offset-1';
                    @endphp

                        <!-- "All" button (clears category) -->
                    <a href="{{ route('home', ['q' => request('q')]) }}"
                       class="{{ $baseTag }} {{ empty($activeCategory) ? 'bg-blue-600 text-white hover:bg-blue-700' : 'bg-gray-700 text-gray-200 hover:bg-gray-600' }}"
                       aria-pressed="{{ empty($activeCategory) ? 'true' : 'false' }}">
                        Alle
                    </a>

                    @foreach($categories as $cat)
                        <a href="{{ route('home', ['q' => request('q'), 'category' => $cat->id]) }}"
                           class="{{ $baseTag }} {{ (string)($activeCategory ?? '') === (string)$cat->id ? 'bg-blue-600 text-white hover:bg-blue-700' : 'bg-gray-700 text-gray-200 hover:bg-gray-600' }}"
                           aria-pressed="{{ (string)($activeCategory ?? '') === (string)$cat->id ? 'true' : 'false' }}">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>

                <!-- Stories list -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg text-white">
                    <div class="p-6">
                        @if($stories->isEmpty())
                            <p>Geen verhalen gevonden.</p>
                        @else
                            <!-- Changed: nicer card layout showing full story -->
                            <div class="flex gap-4 p-3 flex-col">
                                @foreach($stories as $story)
                                    <article class="bg-gray-900/40 p-4 rounded border border-gray-800">
                                        <header class="flex items-start justify-between">
                                            <div>
                                                <a href="{{ route('story.show', $story) }}"
                                                   class="text-xl font-semibold text-white hover:underline">
                                                    {{ $story->name }}
                                                </a>
                                                <div class="text-sm text-gray-300 mt-1">
                                                    @if($story->category)
                                                        <span
                                                            class="inline-block bg-gray-700 px-2 py-0.5 rounded text-xs">
                                                            {{ $story->category->name }}
                                                        </span>
                                                    @endif
                                                    <span class="ml-2 text-xs text-gray-400">
                                                        {{ $story->created_at ? $story->created_at->format('d-m-Y') : '' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </header>

                                        <div class="mt-3 text-gray-200 text-sm leading-relaxed whitespace-pre-line">
                                            {{ $story->text }}
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </x-slot>
</x-app-layout>
