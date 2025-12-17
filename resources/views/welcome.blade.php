<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>ManageX - Modern Content Management System API</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            .bg-dots-darker {
                background-image: radial-gradient(rgb(87 83 95 / 0.15) 1px, transparent 1px);
                background-size: 15px 15px;
            }
            .bg-dots-lighter {
                background-image: radial-gradient(rgb(255 255 255 / 0.2) 1px, transparent 1px);
                background-size: 15px 15px;
            }
        </style>
    </head>
    <body class="antialiased font-sans">
        <div class="relative min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 dark:from-gray-900 dark:to-gray-800">
            <!-- Navigation -->
            @if (Route::has('login'))
                <div class="absolute top-0 right-0 p-6 text-right z-10">
                    @auth
                        <a href="{{ url('/home') }}" class="font-semibold text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 focus:outline focus:outline-2 focus:rounded-sm focus:outline-blue-500 transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 focus:outline focus:outline-2 focus:rounded-sm focus:outline-blue-500 transition-colors">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 focus:outline focus:outline-2 focus:rounded-sm focus:outline-blue-500 transition-colors">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="max-w-7xl mx-auto p-6 lg:p-8">
                <!-- Hero Section -->
                <div class="text-center mb-16 pt-16">
                    <div class="flex justify-center mb-8">
                        <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-6 rounded-2xl shadow-xl">
                            <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                            </svg>
                        </div>
                    </div>
                    <h1 class="text-6xl font-bold text-gray-900 dark:text-white mb-6">
                        <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">ManageX</span>
                    </h1>
                    <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 max-w-4xl mx-auto leading-relaxed">
                        A powerful, feature-rich RESTful API for content management systems built with Laravel. 
                        Manage posts, comments, users, and media with advanced authentication and role-based access control.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
                        <a href="https://managex-swagger-ui.vercel.app/" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg font-semibold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            📚 View API Documentation
                        </a>
                        <a href="https://managex-swagger-ui.vercel.app/" target="_blank" class="bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-900 dark:text-white px-8 py-4 rounded-lg font-semibold transition-all duration-200 border border-gray-300 dark:border-gray-600 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            🚀 Try Live Demo
                        </a>
                        <a href="https://www.postman.com/lunar-module-physicist-24945643/workspace/managex/collection/39561853-542b1145-7737-48e2-a0b1-37519ffa5c82?action=share&creator=39561853" target="_blank" class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-4 rounded-lg font-semibold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            📮 Postman Collection
                        </a>
                    </div>

                    <!-- Tech Stack Badges -->
                    <div class="flex flex-wrap justify-center gap-3 mb-16">
                        <span class="px-4 py-2 bg-red-100 text-red-800 rounded-full text-sm font-semibold">Laravel 10</span>
                        <span class="px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">PHP 8.1+</span>
                        <span class="px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-semibold">RESTful API</span>
                        <span class="px-4 py-2 bg-purple-100 text-purple-800 rounded-full text-sm font-semibold">Sanctum Auth</span>
                        <span class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold">Redis Cache</span>
                    </div>
                </div>

                <!-- Features Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                    <!-- Authentication Feature -->
                    <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="h-16 w-16 bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center rounded-2xl mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-8 h-8 stroke-blue-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Secure Authentication</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            Complete authentication system with email verification, password recovery, 2FA, and OAuth integration for GitHub, Google, and Facebook.
                        </p>
                    </div>

                    <!-- Content Management Feature -->
                    <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="h-16 w-16 bg-green-100 dark:bg-green-900/30 flex items-center justify-center rounded-2xl mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-8 h-8 stroke-green-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Content Management</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            Create, publish, and manage posts with media attachments, categories, comments, and favorites. Support for trending content and personalized feeds.
                        </p>
                    </div>

                    <!-- Role-Based Access Feature -->
                    <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="h-16 w-16 bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center rounded-2xl mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-8 h-8 stroke-purple-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Role-Based Access</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            Comprehensive permission system with user and admin roles. Control access to content, features, and administrative functions.
                        </p>
                    </div>

                    <!-- API Features -->
                    <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="h-16 w-16 bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center rounded-2xl mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-8 h-8 stroke-orange-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Advanced API</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            Powerful filtering, sorting, and pagination with resource inclusion. Full-text search, rate limiting, and comprehensive error handling.
                        </p>
                    </div>

                    <!-- Media Management -->
                    <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="h-16 w-16 bg-pink-100 dark:bg-pink-900/30 flex items-center justify-center rounded-2xl mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-8 h-8 stroke-pink-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Media Management</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            Upload and manage images, videos, and documents with S3/Minio integration. Secure media access with signed URLs and efficient streaming.
                        </p>
                    </div>

                    <!-- Performance -->
                    <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="h-16 w-16 bg-cyan-100 dark:bg-cyan-900/30 flex items-center justify-center rounded-2xl mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-8 h-8 stroke-cyan-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l-1-3m1 3l-1-3m-16.5-3h16.5" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">High Performance</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            Redis caching for popular content, queued email notifications, and optimized database queries for maximum performance and scalability.
                        </p>
                    </div>
                </div>

                <!-- Quick Start Section -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8 mb-16">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Quick Start</h2>
                        <p class="text-gray-600 dark:text-gray-400">Get up and running with ManageX in just a few steps</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="text-center">
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                                <span class="text-blue-600 font-bold text-xl">1</span>
                            </div>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Clone & Install</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                <code class="bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">git clone</code> the repository and run <code class="bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">composer install</code>
                            </p>
                        </div>
                        <div class="text-center">
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                                <span class="text-blue-600 font-bold text-xl">2</span>
                            </div>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Configure</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Set up your <code class="bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">.env</code> file and run migrations with <code class="bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">php artisan migrate</code>
                            </p>
                        </div>
                        <div class="text-center">
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                                <span class="text-blue-600 font-bold text-xl">3</span>
                            </div>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Start Building</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Run <code class="bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">php artisan serve</code> and start making API calls
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="flex justify-center items-center pt-16 pb-8">
                    <div class="text-center">
                        <p class="text-gray-500 dark:text-gray-400 text-sm mb-4">
                            Built with ❤️ using Laravel {{ Illuminate\Foundation\Application::VERSION }} (PHP {{ PHP_VERSION }})
                        </p>
                        <div class="flex justify-center space-x-6 text-sm">
                            <a href="https://github.com/aungmoe32/managex" class="text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 transition-colors">
                                GitHub
                            </a>
                            <a href="https://managex-swagger-ui.vercel.app/" target="_blank" class="text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 transition-colors">
                                Documentation
                            </a>
                            <a href="https://managex-swagger-ui.vercel.app/" class="text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 transition-colors">
                                Live Demo
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>