@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Register</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="UserName" class="form-label">Username</label>
                        <input type="text" class="form-control @error('UserName') is-invalid @enderror"
                               id="UserName" name="UserName" value="{{ old('UserName') }}" required autofocus>
                        @error('UserName')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="Password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('Password') is-invalid @enderror"
                               id="Password" name="Password" required>
                        @error('Password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="Password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control"
                               id="Password_confirmation" name="Password_confirmation" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                </form>

                <div class="mt-3 text-center">
                    <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
