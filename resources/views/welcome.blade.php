@php
    $facebookUrl = 'https://www.facebook.com/share/1EKQqgM39k/';
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Crafty Charms') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">

        <!-- Top bar -->
        <header class="cc-nav">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 py-3 flex flex-wrap items-center justify-between gap-3">
                <a href="/" class="flex items-center gap-3">
                    <img src="{{ asset('images/crafty-charms-logo.jpg') }}" alt="Crafty Charms" class="cc-logo-nav">
                    <span class="cc-script text-2xl font-bold hidden sm:inline">Crafty Charms</span>
                </a>

                <nav class="flex flex-wrap items-center gap-2">
                    <a href="#handcrafts" class="cc-btn cc-btn-sm cc-btn-soft">Handcrafts</a>
                    <a href="#imported" class="cc-btn cc-btn-sm cc-btn-soft">Imported</a>

                    @auth
                        <a href="{{ route('dashboard') }}" class="cc-btn cc-btn-sm cc-btn-soft">My Account</a>
                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="cc-btn cc-btn-sm cc-btn-lav">Admin</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="cc-btn cc-btn-sm cc-btn-soft">Log in</a>
                        <a href="{{ route('register') }}" class="cc-btn cc-btn-sm cc-btn-solid">Register</a>
                    @endauth
                </nav>
            </div>
        </header>

        <!-- Hero -->
        <section class="cc-hero">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 py-14 sm:py-20 text-center">
                <img src="{{ asset('images/crafty-charms-logo.jpg') }}" alt="Crafty Charms" class="cc-logo-hero mx-auto">
                <h1 class="cc-script text-5xl sm:text-6xl font-bold mt-6">Crafty Charms</h1>
                <p class="mt-3 text-lg tracking-wide opacity-80">Handmade with love, made for you ♡</p>

                <div class="mt-8 flex flex-wrap justify-center gap-3">
                    <a href="#handcrafts" class="cc-btn cc-btn-solid">Shop Handcrafts</a>
                    <a href="#imported" class="cc-btn cc-btn-soft">Shop Imported Items</a>
                    <a href="{{ $facebookUrl }}" target="_blank" rel="noopener" class="cc-btn cc-btn-lav">
                        ✿ Customize your order
                    </a>
                </div>
                <p class="mt-3 text-xs opacity-70">Customizing opens our Facebook page, where you can message us.</p>
            </div>
        </section>

        <main class="max-w-6xl mx-auto px-4 sm:px-6 py-12 space-y-14">

            <!-- Best sellers (filled in automatically later) -->
            <section>
                <h2 class="cc-script text-4xl font-bold text-center">Most loved</h2>
                <div class="cc-card mt-6 p-8 text-center opacity-80">
                    Our most popular items will appear here soon.
                </div>
            </section>

            <!-- Handcrafts -->
            <section id="handcrafts" class="scroll-mt-24">
                <h2 class="cc-script text-4xl font-bold text-center">Handcrafts</h2>
                <p class="text-center mt-1 opacity-80">Resin art, pipe cleaner bouquets and more, made by hand.</p>
                <div class="cc-card mt-6 p-8 text-center opacity-80">Items coming soon.</div>
            </section>

            <!-- Imported -->
            <section id="imported" class="scroll-mt-24">
                <h2 class="cc-script text-4xl font-bold text-center">Imported Items</h2>
                <p class="text-center mt-1 opacity-80">Carefully chosen products brought in for you.</p>
                <div class="cc-card mt-6 p-8 text-center opacity-80">Items coming soon.</div>
            </section>
        </main>

        <footer class="cc-header text-center text-sm py-6">
            © {{ date('Y') }} Crafty Charms · Handmade with love, made for you
        </footer>
    </body>
</html>