<x-app-layout>
    <form action="{{ route('story.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="title" class="text-white">Titel</label>
            <input type="text" value="{{ old('title') }}" name="title">
            @error('title')
            <div class="alert alert-danger text-red-600">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="text" class="text-white">Tekst</label>
            <input type="text" value="{{ old('text') }}" name="text">
            @error('text')
            <div class="alert alert-danger text-red-600">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <select name="category_id" id="category_id" required>
                <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ (string) old('category_id') === (string) $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
            <div class="alert alert-danger text-red-600">{{ $message }}</div>
            @enderror
        </div>
        <div class="text-white">
            <label for="image">Afbeelding uploaden:</label>
            <input type="file" name="image" accept="image/*">
        </div>
        <x-primary-button type="submit" name="submit" value="Create" class="text-white">
            Create
        </x-primary-button>
    </form>
</x-app-layout>
