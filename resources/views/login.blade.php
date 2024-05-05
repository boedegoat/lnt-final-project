@extends('layouts.master')

@section('title', 'Login')

@section('content')
    <x-page-title>Login</x-page-title>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session()->has('login-failed'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('login-failed') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="/login" method="POST">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                required autofocus value="{{ old('email') }}">
            @error('email')
                <p class="invalid-feedback">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button type="submit" class="btn btn-primary">Login</button>
            <span>Don't have account bro? <a href='/register'>Register</a></span>
        </div>
    </form>
@endsection
