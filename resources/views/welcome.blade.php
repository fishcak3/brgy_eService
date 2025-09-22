<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Barangay Bakitiw - E-Services Portal</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">

    <div class="min-h-screen bg-gradient-to-br from-green-50 to-yellow-50">

        {{-- Header --}}
        <header class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center text-white font-bold">
                            B
                        </div>
                        <div>
                            <h1 class="font-semibold text-gray-900">Barangay Bakitiw</h1>
                            <p class="text-sm text-gray-600">E-Services Portal</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="px-4 py-2 border rounded-md">Login</a>
                        <a href="{{ url('/about') }}" class="px-4 py-2 bg-green-600 text-white rounded-md">Learn More</a>
                    </div>
                </div>
            </div>
        </header>

        {{-- Hero Section --}}
        <section class="relative py-20 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <span class="inline-block mb-4 bg-green-100 text-green-700 px-3 py-1 rounded">Now Available Online</span>
                    <h1 class="text-4xl lg:text-6xl mb-6 text-gray-900">Integrated E-Services Management System</h1>
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                        "Pagkakaisa sa Paglilingkod, Progreso sa Pamayanan" - Your gateway to efficient and transparent barangay services, available 24/7.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('login') }}" class="px-6 py-3 bg-green-600 text-white rounded-lg text-center">
                            Access Services
                        </a>
                        <a href="#" class="px-6 py-3 border rounded-lg text-center">Watch Demo</a>
                    </div>
                </div>
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1737907208040-d13a8ba97baf?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=1080"
                         alt="Barangay Bakitiw Hall"
                         class="w-full h-96 object-cover rounded-lg shadow-xl" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent rounded-lg"></div>
                </div>
            </div>
        </section>

        {{-- Services Section --}}
        <section class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
            <div class="max-w-7xl mx-auto text-center mb-12">
                <h2 class="text-3xl text-gray-900 mb-4">Available Services</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Access essential barangay services online with our secure and user-friendly platform
                </p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="p-6 border rounded-lg hover:shadow-lg">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        📄
                    </div>
                    <h3 class="mb-2 text-gray-900">Certificate Requests</h3>
                    <p class="text-gray-600 text-sm">Apply for barangay certificates, permits, and clearances online</p>
                </div>
                <div class="p-6 border rounded-lg hover:shadow-lg">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        🧾
                    </div>
                    <h3 class="mb-2 text-gray-900">Document Verification</h3>
                    <p class="text-gray-600 text-sm">Verify the authenticity of barangay-issued documents</p>
                </div>
                <div class="p-6 border rounded-lg hover:shadow-lg">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        📢
                    </div>
                    <h3 class="mb-2 text-gray-900">Announcements</h3>
                    <p class="text-gray-600 text-sm">Stay updated with the latest news and advisories</p>
                </div>
                <div class="p-6 border rounded-lg hover:shadow-lg">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        📊
                    </div>
                    <h3 class="mb-2 text-gray-900">Community Reports</h3>
                    <p class="text-gray-600 text-sm">Submit and track community concerns and feedback</p>
                </div>
            </div>
        </section>

        {{-- Footer --}}
        <footer class="bg-gray-900 text-white py-8 px-4 sm:px-6 lg:px-8 text-center">
            <div class="flex items-center justify-center space-x-3 mb-4">
                <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center">B</div>
                <span class="text-lg">Barangay Bakitiw</span>
            </div>
            <p class="text-gray-400 text-sm">© {{ date('Y') }} Barangay Bakitiw. All rights reserved.</p>
        </footer>
    </div>

</body>
</html>
