<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Investment Community - Grow Your Wealth Together</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans">
        <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
            <img id="background" class="absolute -left-20 top-0 max-w-[877px]" src="https://laravel.com/assets/img/welcome/background.svg" />
            <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                    <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                        <div class="flex lg:justify-center lg:col-start-2">
                            <!-- Investment Community Logo - Replace with your logo -->
                            @if(file_exists(public_path('images/logo.png')) || file_exists(public_path('images/logo.svg')))
                                <x-application-logo class="h-12 w-auto lg:h-16" />
                            @else
                                <!-- Default Investment Icon -->
                                <svg class="h-12 w-auto text-green-600 lg:h-16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <circle cx="19" cy="5" r="2" fill="currentColor"/>
                                </svg>
                            @endif
                        </div>
                        @if (Route::has('login'))
                            <livewire:welcome.navigation />
                        @endif
                    </header>

                    <main class="mt-6">
                        <!-- Hero Section -->
                        <div class="text-center mb-16">
                            <h1 class="text-5xl font-bold text-gray-900 dark:text-white mb-4">
                                Investment Community Platform
                            </h1>
                            <p class="text-xl text-gray-600 dark:text-gray-300 mb-8">
                                Connect with investors, share strategies, and grow your wealth together
                            </p>
                            @if (Route::has('register'))
                                <div class="flex gap-4 justify-center">
                                    <a href="{{ route('register') }}" class="px-8 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition shadow-lg">
                                        Start Investing
                                    </a>
                                    <a href="{{ route('login') }}" class="px-8 py-3 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white rounded-lg border border-gray-300 dark:border-zinc-700 hover:bg-gray-50 dark:hover:bg-zinc-700 transition">
                                        Sign In
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Features Grid -->
                        <div class="grid gap-6 lg:grid-cols-3 lg:gap-8 mb-16">
                            <div class="flex flex-col items-start gap-4 rounded-lg bg-white dark:bg-zinc-900 p-8 shadow-lg ring-1 ring-gray-200 dark:ring-zinc-800">
                                <div class="flex size-16 shrink-0 items-center justify-center rounded-full bg-green-100 dark:bg-green-900">
                                    <svg class="size-8 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-semibold text-black dark:text-white mb-2">Investment Insights</h2>
                                    <p class="text-gray-600 dark:text-gray-400">
                                        Access exclusive market analysis, investment opportunities, and expert strategies from experienced investors in our community.
                                    </p>
                                </div>
                            </div>

                            <div class="flex flex-col items-start gap-4 rounded-lg bg-white dark:bg-zinc-900 p-8 shadow-lg ring-1 ring-gray-200 dark:ring-zinc-800">
                                <div class="flex size-16 shrink-0 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900">
                                    <svg class="size-8 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-semibold text-black dark:text-white mb-2">Network with Investors</h2>
                                    <p class="text-gray-600 dark:text-gray-400">
                                        Connect with like-minded investors through real-time chat and discussion forums. Share ideas, ask questions, and learn together.
                                    </p>
                                </div>
                            </div>

                            <div class="flex flex-col items-start gap-4 rounded-lg bg-white dark:bg-zinc-900 p-8 shadow-lg ring-1 ring-gray-200 dark:ring-zinc-800">
                                <div class="flex size-16 shrink-0 items-center justify-center rounded-full bg-purple-100 dark:bg-purple-900">
                                    <svg class="size-8 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-semibold text-black dark:text-white mb-2">Track Your Portfolio</h2>
                                    <p class="text-gray-600 dark:text-gray-400">
                                        Monitor your investments, share your portfolio performance, and get feedback from the community on your investment strategy.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Call to Action -->
                        <div class="rounded-lg bg-gradient-to-r from-green-600 to-emerald-600 p-12 text-center text-white">
                            <h2 class="text-3xl font-bold mb-4">Ready to Start Your Investment Journey?</h2>
                            <p class="text-lg mb-8 opacity-90">Join our community of investors and start building your wealth today</p>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-block px-8 py-3 bg-white text-green-600 rounded-lg font-semibold hover:bg-gray-100 transition shadow-lg">
                                    Join the Community
                                </a>
                            @endif
                        </div>
                    </main>

                    <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                        Built with love by Khan Innovations
                    </footer>
                </div>
            </div>
        </div>
    </body>
</html>
