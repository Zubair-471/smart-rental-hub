<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Auth - Smart Rental Hub')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #007bff; /* Standard Bootstrap primary blue */
        }
        body {
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center; /* Center horizontally as well */
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            padding: 20px 0; /* Add some padding for smaller screens */
        }
        .auth-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            width: 100%;
            max-width: 450px;
        }
        .auth-header {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); /* Adjusted colors to match primary */
            color: white;
            padding: 2rem;
            text-align: center;
        }
        .auth-body {
            padding: 2rem;
            background: white;
        }
        .auth-title {
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .auth-subtitle {
            opacity: 0.8;
            font-size: 0.9rem;
        }
        .input-group-lg .form-control,
        .input-group-lg .input-group-text {
            height: 50px; /* Consistent height */
        }
        .input-group .form-control {
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
            padding-left: 45px; /* Space for icon */
            border: 1px solid #e0e0e0;
        }
        .input-group .input-group-text {
            background-color: transparent;
            border-right: none;
            border-color: #e0e0e0;
            position: absolute; /* Position icon */
            left: 0;
            top: 0;
            z-index: 5; /* Ensure it's above input */
            height: 100%;
            display: flex;
            align-items: center;
            padding-left: 15px;
            color: #6c757d;
            border-radius: 8px 0 0 8px; /* Match input border radius */
        }
        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            z-index: 10; /* Ensure clickable */
        }
        .btn-auth {
            height: 50px;
            border-radius: 8px;
            font-weight: 600;
            letter-spacing: 0.5px;
            font-size: 1rem;
        }
        .auth-footer {
            text-align: center;
            padding-top: 1.5rem;
            border-top: 1px solid #f0f0f0;
            margin-top: 1.5rem;
        }
        .remember-me {
            font-size: 0.9rem;
        }
        .password-strength {
            height: 4px;
            background: #e9ecef;
            margin-top: 5px;
            border-radius: 2px;
            overflow: hidden;
        }
        .password-strength-bar {
            height: 100%;
            width: 0;
            transition: width 0.3s ease-in-out;
        }
    </style>

    @stack('styles') {{-- For page-specific styles --}}
</head>
<body>
    <main>
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts') {{-- For page-specific scripts --}}
</body>
</html>