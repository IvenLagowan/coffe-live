<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Life Caffe</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-gray-900 text-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <h1 class="text-2xl font-bold text-coffee-500">☕ Life Caffe</h1>
                    <span class="text-gray-400">|</span>
                    <span class="text-sm text-gray-300">{{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})</span>
                </div>
                <div class="flex items-center space-x-6">
                    <a href="{{ route('dashboard') }}" class="hover:text-coffee-500 transition">Dashboard</a>
                    <a href="{{ route('orders.index') }}" class="hover:text-coffee-500 transition">Orders</a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('products.index') }}" class="hover:text-coffee-500 transition">Products</a>
                        <a href="{{ route('categories.index') }}" class="hover:text-coffee-500 transition">Categories</a>
                        <a href="{{ route('ingredients.index') }}" class="hover:text-coffee-500 transition">Ingredients</a>
                        <a href="{{ route('reports.index') }}" class="hover:text-coffee-500 transition">Reports</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="hover:text-red-500 transition">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>