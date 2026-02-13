<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CDI Matrículas') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .login-bg {
                background: linear-gradient(135deg, #1e1b4b 0%, #312e81 30%, #4338ca 60%, #6366f1 100%);
                position: relative;
                overflow: hidden;
            }
            .login-bg::before {
                content: '';
                position: absolute;
                top: -50%;
                left: -50%;
                width: 200%;
                height: 200%;
                background: radial-gradient(ellipse at 20% 50%, rgba(99, 102, 241, 0.15) 0%, transparent 50%),
                            radial-gradient(ellipse at 80% 20%, rgba(139, 92, 246, 0.1) 0%, transparent 50%),
                            radial-gradient(ellipse at 50% 80%, rgba(79, 70, 229, 0.1) 0%, transparent 50%);
                animation: float 20s ease-in-out infinite;
            }
            @keyframes float {
                0%, 100% { transform: translate(0, 0) rotate(0deg); }
                33% { transform: translate(2%, -2%) rotate(1deg); }
                66% { transform: translate(-1%, 1%) rotate(-1deg); }
            }
            .login-card {
                backdrop-filter: blur(20px);
                background: rgba(255, 255, 255, 0.97);
                border: 1px solid rgba(255, 255, 255, 0.3);
                box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(255,255,255,0.1);
                max-width: 420px;
                margin: 0 auto;
            }
            .login-input {
                transition: all 0.3s ease;
                border: 2px solid #e5e7eb;
                border-radius: 12px;
                padding: 14px 16px 14px 46px;
                font-size: 0.95rem;
                width: 100%;
                outline: none;
                background: #f9fafb;
            }
            .login-input:focus {
                border-color: #6366f1;
                background: #fff;
                box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.12);
            }
            .login-btn {
                background: linear-gradient(135deg, #4f46e5, #7c3aed);
                border: none;
                border-radius: 12px;
                padding: 14px 24px;
                color: #fff;
                font-weight: 700;
                font-size: 1rem;
                width: 100%;
                cursor: pointer;
                transition: all 0.3s ease;
                letter-spacing: 0.5px;
                box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
            }
            .login-btn:hover {
                background: linear-gradient(135deg, #4338ca, #6d28d9);
                box-shadow: 0 8px 30px rgba(99, 102, 241, 0.45);
                transform: translateY(-2px);
            }
            .login-btn:active {
                transform: translateY(0);
                box-shadow: 0 2px 10px rgba(99, 102, 241, 0.3);
            }
            .input-icon {
                position: absolute;
                left: 16px;
                top: 50%;
                transform: translateY(-50%);
                color: #9ca3af;
                font-size: 0.9rem;
                transition: color 0.3s;
            }
            .input-group:focus-within .input-icon {
                color: #6366f1;
            }
            .bubble {
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.03);
                animation: rise 15s ease-in-out infinite;
            }
            @keyframes rise {
                0%, 100% { transform: translateY(0) scale(1); opacity: 0.5; }
                50% { transform: translateY(-30px) scale(1.1); opacity: 0.8; }
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="login-bg min-h-screen flex items-center justify-center p-4">
            <!-- Decorative bubbles -->
            <div class="bubble" style="width:300px;height:300px;top:10%;left:-5%;animation-delay:0s;"></div>
            <div class="bubble" style="width:200px;height:200px;bottom:10%;right:-3%;animation-delay:5s;"></div>
            <div class="bubble" style="width:150px;height:150px;top:60%;left:50%;animation-delay:10s;"></div>

            <div class="relative z-10 w-full max-w-md">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
