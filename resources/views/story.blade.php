<x-app-layout>
    <x-slot name="header">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg text-white">
                    <div class="p-6">
                        <h1 class="font-bold">{{ $story->name }}</h1>
                        <p>{{ $story->text }}</p>
                        <div class="pt-2">
                            <p>Category: {{ $story->category->name  }}</p>
                        </div>

                        <x-nav-link :href="route('story.index')" :active="request()->routeIs('home')">
                            {{ __('Terug') }}
                        </x-nav-link>

                        {{-- DELETE button: only show for owner --}}
                        @if(auth()->check() && auth()->id() === $story->user_id)
                            <form action="{{ route('story.destroy', $story) }}" method="POST" class="inline-block ml-3"
                                  onsubmit="return confirm('Weet je zeker dat je dit verhaal wilt verwijderen?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                    Verwijder
                                </button>
                            </form>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
