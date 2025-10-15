<x-app-layout>
    <x-slot name="header">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg text-white">
                    <div class="p-6">
                        <h1 class="font-bold">{{ $story->name }}</h1>
                        <p>{{ $story->text }}</p>
                        <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                            {{ __('Terug') }}
                        </x-nav-link>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
