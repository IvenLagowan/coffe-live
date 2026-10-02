<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Life Caffe</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full">
            <div class="text-center mb-8">
                <h1 class="text-5xl font-bold text-coffee-500 mb-2">☕ Life Caffe</h1>
                <p class="text-gray-400">Internal Management System</p>
            </div>

            <div class="bg-white rounded-lg shadow-xl p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Login</h2>

                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="/">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="label">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus class="input-field">
                    </div>

                    <div class="mb-6">
                        <label class="label">Password</label>
                        <input type="password" name="password" required class="input-field">
                    </div>

                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="mr-2">
                            <span class="text-gray-700">Remember me</span>
                        </label>
                    </div>

                    <button type="submit" class="btn-primary w-full">Login</button>
                </form>

                <div class="mt-6 pt-6 border-t border-gray-200">
                    <p class="text-sm text-gray-600">Test Credentials:</p>
                    <p class="text-xs text-gray-500 mt-1">Admin: admin@lifecaffe.com / password</p>
                    <p class="text-xs text-gray-500">Staff: staff@lifecaffe.com / password</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>