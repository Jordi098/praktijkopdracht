<x-app-layout>
    <form action="{{ route('story.store') }}" method="post" enctype="multipart/form-data"
          class="max-w-3xl mx-auto p-6 bg-gray-800 rounded-lg shadow-md space-y-6">
        @csrf

        <div class="flex flex-col">
            <label for="title" class="text-white font-semibold mb-1">Titel</label>
            <input type="text" value="{{ old('title') }}" name="title"
                   class="px-4 py-2 rounded-md border border-gray-600 bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
            @error('title')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex flex-col">
            <label for="text" class="text-white font-semibold mb-1">Tekst</label>
            <input type="text" value="{{ old('text') }}" name="text" size="50"
                   class="px-4 py-2 rounded-md border border-gray-600 bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
            @error('text')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex flex-col">
            <label for="category_id" class="text-white font-semibold mb-1">Categorie</label>
            <select name="category_id" id="category_id" required
                    class="px-4 py-2 rounded-md border border-gray-600 bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>Select Category</option>
                @foreach($categories as $category)
                    <option
                        value="{{ $category->id }}" {{ (string) old('category_id') === (string) $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex flex-col">
            <label for="image" class="text-white font-semibold mb-1">Afbeelding uploaden</label>
            <input type="file" name="image" accept="image/*"
                   class="text-white px-2 py-1 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <x-primary-button type="submit" name="submit" value="Create" class="text-white">
            Create
        </x-primary-button>
    </form>
</x-app-layout>
