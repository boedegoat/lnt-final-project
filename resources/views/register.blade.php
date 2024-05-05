@extends('layouts.master')

@section('title', 'Register')

@section('content')
    <x-page-title>Register</x-page-title>

    <form action="/register" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                value="{{ old('name') }}" required autofocus>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                value="{{ old('email') }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="phone_number" class="form-label">Phone Number</label>
            <input type="tel" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number"
                value="{{ old('phone_number') }}" name="phone_number" pattern="^08[0-9]+" required>
            <div class="form-text">must starts with 08</div>
            @error('phone_number')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                name="password" required minlength="6">
            <div class="form-text">min 6 characters</div>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="d-flex align-items-center gap-2">
            <button type="submit" class="btn btn-primary">Register</button>
            <span>Already have account bro? <a href='/login'>Login</a></span>
        </div>
    </form>
@endsection
