<x-app-layout>
    <div class="max-w-4xl mx-auto py-16 px-6">
        <h1 class="text-4xl md:text-5xl font-bold mb-6 text-white text-center">
            Mijn Verhalen
        </h1>
        @foreach($stories as $story)
            <article class="bg-gray-900/40 p-4 rounded border border-gray-800 mb-6">
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
                            <span class="ml-2 text-xs text-white">
                                                        {{ $story->created_at ? $story->created_at->format('d-m-Y') : '' }}
                                                    </span>
                        </div>
                    </div>
                </header>

                <div class="mt-3 text-gray-200 text-sm leading-relaxed whitespace-pre-line">
                    {{ $story->text }}
                </div>
                <img src="{{ asset('storage/' . $story->file_path) }}" alt="Story Image"
                     class="mt-2 max-w-xs rounded text-white">
                <small class="text-white">Gemaakt door: {{ $story->user->name ?? 'Onbekend' }}</small>
            </article>
    @endforeach
</x-app-layout>
