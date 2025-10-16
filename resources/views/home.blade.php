<x-app-layout>
    <x-slot name="header">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <x-nav-link :href="route('story.create')" :active="request()->routeIs('story.create')">
                    {{ __('Create') }}
                </x-nav-link>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg text-white">
                    @foreach($stories as $story)
                        <div class="p-6">
                            <h1>{{ $story->name }}</h1>
                            <p>{{ $story->text }}</p>
                            <x-nav-link :href="route('story.show', $story->id)" :active="request()->routeIs('story')">
                                {{ __('Meer') }}
                            </x-nav-link>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
