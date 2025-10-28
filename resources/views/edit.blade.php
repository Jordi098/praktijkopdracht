<x-app-layout>
    <form action="{{ route('story.update', $story->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label for="title" class="text-white">Titel</label>
            <input type="text" id="title" name="title" value="{{ old('title', $story->name) }}">
            @error('title')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="text" class="text-white">Tekst</label>
            <textarea id="text" name="text">{{ old('text', $story->text) }}</textarea>
            @error('text')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="category_id" class="text-white">Categorie</label>
            <select name="category_id" id="category_id">
                <option value="">-- Kies categorie --</option>
                @foreach($categories as $category)
                    <option
                        value="{{ $category->id }}" {{ (string) old('category_id', $story->category_id) === (string) $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="text-white">
            <label for="image">Afbeelding uploaden:</label>
            <input type="file" name="image" accept="image/*">
        </div>

        <x-primary-button type="submit" class="text-white">
            Update
        </x-primary-button>
    </form>
</x-app-layout>
