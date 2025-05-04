@extends('layout')

@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
            crossorigin="anonymous">
        <style>
            body {
                background-color: #f4f7fc;
                font-family: 'Poppins', sans-serif;
            }

            .register-card {
                margin-top: 50px;
                padding: 20px;
                border-radius: 8px;
                background-color: white;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="register-card">
                        <h2 class="text-center">Create an Account</h2>
                        <form id="registerForm" method="POST" action="{{ route('register.post') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required
                                    minlength="2" maxlength="255" pattern="^[A-Za-z0-9\s]+$">
                                <div class="form-text">Letters, numbers, and spaces only (2-255 chars).</div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required
                                    maxlength="255" pattern="^[A-Za-z0-9._%+\-]+@[A-Za-z0-9.\-]+\.[A-Za-z]{2,8}$">
                                <div class="form-text">Must be a valid email address.</div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required
                                    minlength="8">
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" required minlength="8">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Register</button>
                            <p class="text-center mt-3">Already have an account? <a href="{{ route('login') }}">Login</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.getElementById('registerForm').addEventListener('submit', function(e) {
                const password = document.getElementById('password').value;
                const confirm = document.getElementById('password_confirmation').value;
                if (password !== confirm) {
                    e.preventDefault();
                    alert('Passwords do not match.');
                }
            });
        </script>
    </body>

    </html>
@endsection

@if ($errors->any())
    <div class="alert alert-danger position-fixed bottom-0 start-50 translate-middle-x mb-2" style="z-index: 9999;">
        <ul class="mb-0">
            @foreach ($errors->all() as $msg)
                <li>{{ $msg }}</li>
            @endforeach
        </ul>
    </div>
@endif