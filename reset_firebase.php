<?php

use Kreait\Firebase\Factory;

require '/var/www/html/vendor/autoload.php';

// Path logic from FirebaseAuthController
$envPath = env('FIREBASE_CREDENTIALS', 'storage/app/firebase/serviceAccountKey.json');
$possiblePaths = [
    base_path($envPath),
    storage_path('app/' . $envPath),
    $envPath
];

$credentialsPath = null;
foreach ($possiblePaths as $path) {
    if (file_exists($path)) {
        $credentialsPath = $path;
        break;
    }
}

if (!$credentialsPath) {
    die("Error: Service Account file not found.\n");
}

try {
    $factory = (new Factory)->withServiceAccount($credentialsPath);
    $auth = $factory->createAuth();

    $email = 'admin@ensat.ac.ma';
    $password = 'admin123';

    try {
        $user = $auth->getUserByEmail($email);
        $auth->changeUserPassword($user->uid, $password);
        echo "SUCCESS: Password for [$email] reset to [$password].\n";
    } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
        echo "User not found. Creating...\n";
        $userProps = [
            'email' => $email,
            'emailVerified' => true,
            'password' => $password,
            'displayName' => 'Admin Express',
        ];
        $auth->createUser($userProps);
        echo "SUCCESS: Created user [$email] with password [$password].\n";
    }

} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
