@extends('layouts.master')

@yield('Cart')

@section('content')
    <x-page-title backHref="/items">Cart</x-page-title>

    <div class="d-flex align-items-center flex-column gap-5">
        @foreach ($items as $item)
            <div class="card" style="width: 100%">
                <img src="@if ($item->image) {{ asset('storage/' . $item->image) }} @else {{ asset('images/placeholder-image.png') }} @endif"
                    class="card-img-top" style="height: 300px; object-fit: cover" alt="{{ $item->name }}'s image">
                <div class="card-body">
                    <h5 class="card-title">{{ $item->name }}</h5>
                    <div>Stock: {{ number_format($item->stock, 0, '', ',') }}</div>
                    <div>Category: {{ $item->category->name }}</div>
                    <div class="d-flex gap-2 mt-3">
                        <input type="number" min="1" value="1" class="form-control text-center"
                            style="width: 60px" name="amount" onchange="calculateSubtotal(this)"
                            data-price="{{ $item->price }}" data-id="{{ $item->id }}" autocomplete="off">

                        <form action="/cart" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="text" name="item_id" value="{{ $item->id }}" hidden>
                            <button type="submit" class="btn btn-danger"
                                onclick="localStorage.removeItem('amount_{{ $item->id }}')">Remove</button>
                        </form>
                    </div>
                    <div class="mt-3" id="subtotal_{{ $item->id }}" data-subtotal="{{ $item->price }}">Subtotal:
                        Rp.
                        {{ number_format($item->price, 0, '', ',') }}</div>
                </div>
            </div>
        @endforeach
    </div>

    @if ($items->count() > 0)
        <form action="/cart/clear" method="POST" class="mt-5">
            @csrf
            @method('DELETE')
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address"
                    value="{{ old('address') }}" required></textarea>
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="postal_code" class="form-label">Postal Code</label>
                <input type="text" class="form-control @error('postal_code') is-invalid @enderror" id="postal_code"
                    name="postal_code" value="{{ old('postal_code') }}" required />
                @error('postal_code')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button class="btn btn-primary block" style="width: 100%; font-weight: 800" onclick="checkout()">Checkout (<span
                    id="grandTotal">Grand Total: Rp.
                    {{ number_format($items->sum('price'), 0, ',', '.') }}
                </span>)</button>
        </form>
    @else
        <div class="mt-3">No items yet.</div>
    @endif

    <script>
        const grandTotalElement = document.getElementById('grandTotal');

        function calculateGrandtotal() {
            const subtotalElements = document.querySelectorAll('[id^="subtotal"]');
            let grandTotal = 0;
            subtotalElements.forEach(subtotalElement => {
                grandTotal += Number(subtotalElement.dataset.subtotal);
            });
            grandTotalElement.textContent = `Grandtotal: Rp. ${grandTotal.toLocaleString()}`;
        }

        function calculateSubtotal(input) {
            const amount = Number(input.value);
            const {
                price,
                id
            } = input.dataset;

            const subtotal = amount * price;
            const subtotalElement = document.getElementById(`subtotal_${id}`);
            subtotalElement.dataset.subtotal = subtotal;
            subtotalElement.textContent = `Subtotal: Rp. ${subtotal.toLocaleString()}`;
            calculateGrandtotal();

            // Save amount changes to localStorage
            localStorage.setItem(`amount_${id}`, amount);
        }

        async function checkout() {
            const invoiceNumber = Math.floor(Math.random() * 1000000) + 1;

            const address = document.getElementById('address').value;
            const postalCode = document.getElementById('postal_code').value;

            if (!address || !postalCode) {
                alert('please input address and postal code')
                return
            }

            alert(
                `============Faktur============\n${grandTotalElement.textContent}\ninvoice number: ${invoiceNumber}\naddress: ${address}\npostal code: ${postalCode}\n============Faktur============`
            );

            localStorage.clear()
        }

        // Load amount changes from localStorage
        window.addEventListener('DOMContentLoaded', () => {
            const amountInputs = document.querySelectorAll('input[name="amount"]');
            amountInputs.forEach(input => {
                const id = input.dataset.id;
                const savedAmount = localStorage.getItem(`amount_${id}`);
                if (savedAmount) {
                    input.value = savedAmount;
                    calculateSubtotal(input);
                }
            });
        });
    </script>
@endsection
