@extends('layouts.master')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <x-page-title>Items</x-page-title>
        @if (auth()->user()->role == 'admin')
            <a class="btn btn-primary" href="/items/create">Create new Item</a>
        @endif
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex align-items-center flex-column gap-5">
        @foreach ($items as $item)
            <div class="card" style="width: 100%">
                <img src="@if ($item->image) {{ asset('storage/' . $item->image) }} @else {{ asset('images/placeholder-image.png') }} @endif"
                    class="card-img-top" style="height: 300px; object-fit: cover" alt="{{ $item->name }}'s image">
                <div class="card-body">
                    <h5 class="card-title">{{ $item->name }}</h5>
                    <div>Price: Rp. {{ number_format($item->price, 0, '', ',') }}</div>
                    <div>Stock: {{ number_format($item->stock, 0, '', ',') }}</div>
                    <div>Category: {{ $item->category->name }}</div>
                    <div class="d-flex gap-2">
                        <form action="/cart" method="POST">
                            @csrf
                            <input type="text" name="item_id" value="{{ $item->id }}" hidden>
                            <button class="btn btn-primary mt-2" @if (in_array($item->id, auth()->user()->items->pluck('id')->toArray())) disabled @endif>
                                @if (in_array($item->id, auth()->user()->items->pluck('id')->toArray()))
                                    Added to cart
                                @else
                                    Buy
                                @endif
                            </button>
                        </form>
                        @if (auth()->user()->role == 'admin')
                            <a class="btn btn-warning mt-2" href="/items/{{ $item->id }}">Edit</a>
                            <form action="/items/{{ $item->id }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-danger mt-2" type="submit"
                                    onclick="return confirm('Are you sure you want to delete {{ $item->name }}?')">Delete</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
