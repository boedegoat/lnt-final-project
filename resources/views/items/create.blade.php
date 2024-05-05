@extends('layouts.master')

@section('content')
    <x-page-title backHref="/items">Create new</x-page-title>

    <form action="/items" method="POST" enctype="multipart/form-data">
        @csrf
        <x-image-input mode="create" />
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                value="{{ old('name') }}" required autofocus>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <div class="input-group">
                <span class="input-group-text">Rp</span>
                <input type="number" min="0" class="form-control @error('price') is-invalid @enderror"
                    id="price" name="price" value="{{ old('price') }}" required>
            </div>
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" min="0" class="form-control @error('stock') is-invalid @enderror" id="stock"
                name="stock" value="{{ old('stock') }}" required>
            @error('stock')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select id="category" name="category_id" value="{{ old('category') }}"
                class="form-select @error('category_id') is-invalid @enderror" required>
                <option value="">select category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Add Item</button>
    </form>
@endsection
