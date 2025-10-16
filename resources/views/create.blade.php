<x-app-layout>
    <form action="{{ route('story.store') }}" method="post">
        @csrf
        <div>
            <label for="title" class="text-white">Titel</label>
            <input type="text" value="{{ old('title') }}" name="title">
            @error('title')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="text" class="text-white">Tekst</label>
            <input type="text" value="{{ old('text') }}" name="text">
            @error('text')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <select name="category_id">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <x-primary-button type="submit" name="submit" value="Create" class="text-white">
            Create
        </x-primary-button>
    </form>
</x-app-layout>
