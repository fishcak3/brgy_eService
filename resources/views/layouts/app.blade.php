<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Dashboard</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="bg-green-50 font-sans">

    <div class="flex h-screen">

        <!-- Sidebar -->
        <aside class="w-64 bg-green-900 text-white flex flex-col">
            <div class="p-4 text-center bg-yellow-400 text-green-900 font-bold text-lg">
                Bakitiw Online Services
            </div>
            <nav class="flex-1 p-4 space-y-2">
                <a href="{{ route('dashboard') }}" class="block py-2 px-3 rounded hover:bg-green-700">Dashboard</a>
                <a href="#" class="block py-2 px-3 rounded hover:bg-green-700">Requests</a>
                <a href="#" class="block py-2 px-3 rounded hover:bg-green-700">Complaints</a>
                <a href="#" class="block py-2 px-3 rounded hover:bg-green-700">Profile</a>
            </nav>
            <div class="p-4">
                <form method="POST" action="{{ route('logout') }}">
                @csrf
                    <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white py-2 px-3 rounded">
                        Logout
                    </button>
                </form>

            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 overflow-y-auto">
            @yield('content')
        </main>

    </div>

</body>
</html>
