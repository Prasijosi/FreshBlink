<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Change Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800">
    <!-- Navbar -->
    <div class="flex flex-wrap items-center justify-between px-4 py-3 border-b border-gray-200 bg-white">
        <a href="#"><img src="images/logo.png" alt="FreshBlink Logo" class="w-32 sm:w-36 md:w-40"></a>
        <div class="flex items-center gap-2">
            <input type="text" placeholder="Search Products..." class="px-3 py-2 border rounded-l bg-green-50 w-32 sm:w-48 md:w-64" />
            <button class="px-3 py-2 bg-green-600 text-white rounded-r hover:bg-green-700 transition-colors">
                <span class="material-icons">search</span>
            </button>
        </div>
        <div class="flex items-center gap-4">
            <a href="#" class="flex items-center text-sm text-gray-700 hover:text-green-600 transition-colors">
                <span class="material-icons mr-1">shopping_cart</span> Cart
            </a>
            <a href="#" class="flex items-center text-sm text-gray-700 hover:text-green-600 transition-colors">
                <span class="material-icons mr-1">favorite_border</span> Saved
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-screen-xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
        <div class="max-w-md mx-auto bg-white p-6 sm:p-8 rounded-lg shadow-sm border border-gray-100">
            <h2 class="text-2xl font-semibold mb-8 text-center text-gray-800">Change Password</h2>

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('user.password.update') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                    <input type="password" name="current_password" id="current_password" required
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-green-500 focus:ring-1 focus:ring-green-200 transition-colors outline-none text-gray-700 text-sm"
                           placeholder="Enter your current password">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                    <input type="password" name="password" id="password" required
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-green-500 focus:ring-1 focus:ring-green-200 transition-colors outline-none text-gray-700 text-sm"
                           placeholder="Enter your new password">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-green-500 focus:ring-1 focus:ring-green-200 transition-colors outline-none text-gray-700 text-sm"
                           placeholder="Confirm your new password">
                </div>

                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-6">
                    <a href="{{ route('user.profile') }}" 
                       class="text-sm text-green-600 hover:text-green-700 font-medium transition-colors">
                        Back to Profile
                    </a>
                    <button type="submit" 
                            class="w-full sm:w-auto bg-green-600 text-white px-6 py-2.5 rounded-lg hover:bg-green-700 transition-colors text-sm font-medium">
                        Change Password
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white mt-8 p-6 border-t border-gray-100">
        <div class="max-w-screen-xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-6 text-sm text-gray-600">
            <div class="col-span-1 flex justify-center">
                <div class="w-32 h-20 bg-gray-50 flex items-center justify-center rounded-lg">Image</div>
            </div>
            <div>
                <h4 class="font-medium mb-3 text-gray-800">Account</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-600 hover:text-green-600 transition-colors">Link</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-green-600 transition-colors">Link</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-green-600 transition-colors">Link</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-green-600 transition-colors">Link</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-medium mb-3 text-gray-800">Useful Links</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-600 hover:text-green-600 transition-colors">Link</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-green-600 transition-colors">Link</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-green-600 transition-colors">Link</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-green-600 transition-colors">Link</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-medium mb-3 text-gray-800">Help Center</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-600 hover:text-green-600 transition-colors">Link</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-green-600 transition-colors">Link</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-green-600 transition-colors">Link</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-green-600 transition-colors">Link</a></li>
                </ul>
            </div>
        </div>
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-gray-500 mt-8 pt-6 border-t border-gray-100">
            <span>© 2025 Company Name</span>
            <div class="flex gap-4 text-lg text-gray-400">
                <a href="https://www.facebook.com" target="_blank" aria-label="Facebook" class="hover:text-blue-600 transition-colors">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://www.linkedin.com" target="_blank" aria-label="LinkedIn" class="hover:text-blue-500 transition-colors">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a href="https://instagram.com" target="_blank" aria-label="Instagram" class="hover:text-pink-500 transition-colors">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://x.com/i/flow/login" target="_blank" aria-label="Twitter" class="hover:text-blue-400 transition-colors">
                    <i class="fab fa-twitter"></i>
                </a>
            </div>
        </div>
    </footer>
</body>
</html> 