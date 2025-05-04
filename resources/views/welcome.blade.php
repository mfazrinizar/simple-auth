@extends('layout')

@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Welcome!</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
            crossorigin="anonymous">
        <style>
            body {
                background-color: #eef2f7;
                font-family: 'Poppins', sans-serif;
            }

            .dashboard-header {
                background-color: #4a90e2;
                color: white;
                padding: 20px;
                border-radius: 8px;
            }

            .dashboard-content {
                margin-top: 20px;
            }
        </style>
    </head>

    <body>
        <div class="container py-4">
            @if (auth()->check())
                <div class="dashboard-header text-center">
                    <h1>Welcome, {{ auth()->user()->name }}</h1>
                    <p>Your personalized dashboard</p>
                </div>
                <div class="dashboard-content">
                    <div class="alert alert-info">
                        {{ session('success') ?? 'You are logged in!' }}
                    </div>
                    <p>Explore the features of your dashboard and manage your account.</p>
                </div>
            @else
                <script>
                    window.location = "{{ route('login') }}";
                </script>
            @endif
        </div>
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