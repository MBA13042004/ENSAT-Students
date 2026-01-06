<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth as FirebaseAuth;

class FirebaseAuthController extends Controller
{
    protected $firebaseAuth;

    public function __construct()
    {
        try {
            // Configure cURL SSL certificate path for Windows
            $cacertPath = storage_path('cacert.pem');
            if (file_exists($cacertPath)) {
                ini_set('curl.cainfo', $cacertPath);
                ini_set('openssl.cafile', $cacertPath);
            }
            
            $envPath = env('FIREBASE_CREDENTIALS', 'storage/app/firebase/serviceAccountKey.json');
            
            // Try different path resolutions
            $possiblePaths = [
                base_path($envPath), // Relative to project root
                storage_path('app/' . $envPath), // Relative to storage/app
                $envPath // As is (absolute path)
            ];
            
            $credentialsPath = null;
            foreach ($possiblePaths as $path) {
                if (file_exists($path)) {
                    $credentialsPath = $path;
                    break;
                }
            }
            
            if (!$credentialsPath) {
                Log::warning('Firebase credentials file not found. Checked paths: ' . implode(', ', $possiblePaths));
                $this->firebaseAuth = null;
                return;
            }

            $factory = (new Factory)->withServiceAccount($credentialsPath);
            $this->firebaseAuth = $factory->createAuth();
        } catch (\Exception $e) {
            Log::error('Firebase initialization error: ' . $e->getMessage());
            $this->firebaseAuth = null;
        }
    }

    /**
     * Handle Firebase authentication
     */
    public function authenticate(Request $request)
    {
        try {
            $request->validate([
                'idToken' => 'required|string',
            ]);

            if (!$this->firebaseAuth) {
                return response()->json([
                    'success' => false,
                    'message' => 'Firebase non configuré. Veuillez contacter l\'administrateur.',
                ], 500);
            }

            // Verify the Firebase ID token
            $verifiedIdToken = $this->firebaseAuth->verifyIdToken($request->idToken);
            $uid = $verifiedIdToken->claims()->get('sub');
            $email = $verifiedIdToken->claims()->get('email');
            $name = $verifiedIdToken->claims()->get('name') ?? $email;

            // Determine role based on email
            $role = ($email === env('ADMIN_EMAIL', 'admin@ensat.ma')) ? 'ADMIN' : 'STUDENT';

            // Create or update user in local database
            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'firebase_uid' => $uid,
                    'role' => $role,
                    'password' => bcrypt(str()->random(32)), // Random password since Firebase handles auth
                ]
            );

            // Log the user in
            Auth::login($user, true);

            // Determine redirect URL based on role
            $redirectUrl = $user->isAdmin() ? '/admin/students' : '/dashboard';

            return response()->json([
                'success' => true,
                'message' => 'Connexion réussie',
                'redirect' => $redirectUrl,
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                ],
            ]);

        } catch (\Kreait\Firebase\Exception\Auth\FailedToVerifyToken $e) {
            Log::error('Firebase token verification failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Token invalide ou expiré. Veuillez réessayer.',
            ], 401);
        } catch (\Exception $e) {
            Log::error('Firebase authentication error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur d\'authentification: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Handle user logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Déconnexion réussie');
    }
}
