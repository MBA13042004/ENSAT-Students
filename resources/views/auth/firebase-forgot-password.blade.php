<!DOCTYPE html>
<html lang="fr" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mot de passe oublié - ENSAT Students</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-900">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-900">
        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-gray-800 shadow-lg rounded-lg">
            <div class="text-center mb-6">
                <h2 class="text-3xl font-bold text-white">ENSAT Students</h2>
                <p class="text-gray-400 mt-2">Réinitialiser votre mot de passe</p>
            </div>

            <div class="mb-4 text-sm text-gray-400">
                Entrez votre adresse email et nous vous enverrons un lien pour réinitialiser votre mot de passe.
            </div>

            <!-- Error Message -->
            <div id="error-message" class="hidden mb-4 p-3 bg-red-500/20 border border-red-500 text-red-400 rounded-lg text-sm">
            </div>

            <!-- Success Message -->
            <div id="success-message" class="hidden mb-4 p-3 bg-green-500/20 border border-green-500 text-green-400 rounded-lg text-sm">
            </div>

            <!-- Firebase Password Reset Form -->
            <form id="reset-form" onsubmit="event.preventDefault(); handlePasswordReset();" class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                    <input id="email" type="email" required autofocus
                        class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="email@example.com">
                </div>

                <button id="reset-button" type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                    Envoyer le lien de réinitialisation
                </button>
            </form>

            <!-- Back to Login Link -->
            <div class="mt-6 text-center">
                <a href="/login" class="text-sm text-indigo-400 hover:text-indigo-300">
                    ← Retour à la connexion
                </a>
            </div>
        </div>
    </div>

    <script>
        function handlePasswordReset() {
            const email = document.getElementById('email').value;
            const button = document.getElementById('reset-button');
            
            sendPasswordReset(email, button);
        }
    </script>
</body>
</html>
