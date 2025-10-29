<x-app-layout>
    <form action="{{ route('story.update', $story->id) }}" method="POST" enctype="multipart/form-data"
          class="max-w-3xl mx-auto p-6 bg-gray-800 rounded-lg shadow-md space-y-6">
        @csrf
        @method('PUT')

        <div class="flex flex-col">
            <label for="title" class="text-white font-semibold mb-1">Titel</label>
            <input type="text" id="title" name="title"
                   value="{{ old('title', $story->name) }}"
                   class="px-4 py-2 rounded-md border border-gray-600 bg-gray-700 text-white
                          focus:outline-none focus:ring-2 focus:ring-indigo-500">
            @error('title')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex flex-col">
            <label for="text" class="text-white font-semibold mb-1">Tekst</label>
            <textarea id="text" name="text" rows="5"
                      class="px-4 py-2 rounded-md border border-gray-600 bg-gray-700 text-white
                             focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('text', $story->text) }}</textarea>
            @error('text')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex flex-col">
            <label for="category_id" class="text-white font-semibold mb-1">Categorie</label>
            <select name="category_id" id="category_id"
                    class="px-4 py-2 rounded-md border border-gray-600 bg-gray-700 text-white
                           focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="" disabled>-- Kies categorie --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ (string) old('category_id', $story->category_id) === (string) $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex flex-col text-white">
            <label for="image" class="font-semibold mb-1">Afbeelding uploaden</label>
            <input type="file" name="image" accept="image/*"
                   class="px-2 py-1 bg-gray-700 border border-gray-600 rounded-md
                          focus:outline-none focus:ring-2 focus:ring-indigo-500">
            @if ($story->file_path)
                <p class="text-gray-400 text-sm mt-2">Huidige afbeelding:
                    <a class="underline" target="_blank"
                       href="{{ asset('storage/' . $story->file_path) }}">
                        Bekijken
                    </a>
                </p>
            @endif
        </div>

        <x-primary-button type="submit" class="text-white">
            Update
        </x-primary-button>

    </form>
</x-app-layout>
