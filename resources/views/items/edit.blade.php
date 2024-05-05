@extends('layouts.master')

@section('content')
    <x-page-title backHref="/items">Edit</x-page-title>
    <form action="/items/{{ $item->id }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <x-image-input mode="edit" :item="$item" />
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                value="{{ old('name', $item->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <div class="input-group">
                <span class="input-group-text">Rp</span>
                <input type="number" min="0" class="form-control @error('price') is-invalid @enderror"
                    id="price" name="price" value="{{ old('price', $item->price) }}" required>
            </div>
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" min="0" class="form-control @error('stock') is-invalid @enderror" id="stock"
                name="stock" value="{{ old('stock', $item->stock) }}" required>
            @error('stock')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select id="category" name="category_id" class="form-select @error('category_id') is-invalid @enderror"
                required>
                <option selected>select category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @if ($category->id == old('category_id', $item->category->id)) selected @endif>
                        {{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Edit Item</button>
    </form>
@endsection
