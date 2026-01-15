<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .login-page {
            min-height: 100vh;
            background: linear-gradient(135deg,
                    #f4f8ff 0%,
                    #dbeafe 30%,
                    #93c5fd 65%,
                    #1e3a8a 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
        }

        .login-title {
            font-weight: 600;
            color: #1f2937;
        }

        .login-subtitle {
            color: #6b7280;
            font-size: 0.9rem;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.75);
            border-radius: 12px;
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.12);
        }
    </style>
</head>

<body class="login-page">
    <div class="login-card">
        <h4 class="login-title mb-2">Welcome Back</h4>
        <p class="login-subtitle mb-4">Sign in to your account</p>
        <div class="flex justify-center">
            <a href="/" wire:navigate>
                <img src="https://seeplus.co.id/images/seeplus-logo-ok.png" alt="Logo" style="height: 7.25rem">
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>
</body>

</html>