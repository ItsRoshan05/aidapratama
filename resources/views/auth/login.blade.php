<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-md">
        <!-- Logo -->

        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">AIDA PRATAMA</h2>

        @if(session('error'))
            <div class="bg-red-100 text-red-600 text-sm px-4 py-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="#" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-sm text-gray-700 mb-1">Email</label>
                <input type="email" id="email" name="email" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="admin@example.com">
            </div>

            <div>
                <label for="password" class="block text-sm text-gray-700 mb-1">Password</label>
                <input type="password" id="password" name="password" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="••••••••">
            </div>

            <div>
                <button type="submit"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 rounded-lg transition duration-200">
                    Login
                </button>
            </div>
        </form>
    </div>

</body>
</html>
