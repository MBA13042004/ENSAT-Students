<!DOCTYPE html>
<html lang="fr" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Inscription - ENSAT Students</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-900">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-900">
        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-gray-800 shadow-lg rounded-lg">
            <div class="text-center mb-6">
                <h2 class="text-3xl font-bold text-white">ENSAT Students</h2>
                <p class="text-gray-400 mt-2">Créer un nouveau compte</p>
            </div>

            <!-- Error Message -->
            <div id="error-message" class="hidden mb-4 p-3 bg-red-500/20 border border-red-500 text-red-400 rounded-lg text-sm">
            </div>

            <!-- Firebase Registration Form -->
            <form id="register-form" onsubmit="event.preventDefault(); handleRegister();" class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                    <input id="email" type="email" required autofocus
                        class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="email@example.com">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300">Mot de passe</label>
                    <input id="password" type="password" required
                        class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="••••••••">
                    <p class="mt-1 text-xs text-gray-400">Au moins 6 caractères</p>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-300">Confirmer le mot de passe</label>
                    <input id="password_confirmation" type="password" required
                        class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="••••••••">
                </div>

                <button id="register-button" type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                    S'inscrire
                </button>
            </form>

            <!-- Divider -->
            <div class="my-6 flex items-center">
                <div class="flex-grow border-t border-gray-600"></div>
                <span class="px-4 text-sm text-gray-400">OU</span>
                <div class="flex-grow border-t border-gray-600"></div>
            </div>

            <!-- Google Sign-In Button -->
            <button id="google-button" onclick="googleSignIn(this)"
                class="w-full flex items-center justify-center py-2 px-4 border border-gray-600 rounded-md shadow-sm text-sm font-medium text-white bg-gray-700 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition">
                <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                Continuer avec Google
            </button>

            <!-- Login Link -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-400">
                    Déjà un compte ?
                    <a href="/login" class="text-indigo-400 hover:text-indigo-300 font-medium">
                        Se connecter
                    </a>
                </p>
            </div>
        </div>
    </div>

    <script>
        function handleRegister() {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;
            const button = document.getElementById('register-button');
            
            if (password !== passwordConfirmation) {
                document.getElementById('error-message').textContent = 'Les mots de passe ne correspondent pas';
                document.getElementById('error-message').classList.remove('hidden');
                return;
            }

            if (password.length < 6) {
                document.getElementById('error-message').textContent = 'Le mot de passe doit contenir au moins 6 caractères';
                document.getElementById('error-message').classList.remove('hidden');
                return;
            }
            
            registerWithEmail(email, password, button);
        }
    </script>
</body>
</html>
