// Firebase Authentication Module
import { initializeApp } from 'firebase/app';
import { getAnalytics } from 'firebase/analytics';
import {
    getAuth,
    signInWithEmailAndPassword,
    createUserWithEmailAndPassword,
    signInWithPopup,
    GoogleAuthProvider,
    sendPasswordResetEmail,
    signOut
} from 'firebase/auth';

// Firebase configuration
const firebaseConfig = {
    apiKey: "AIzaSyA-i0w8f7q9DlOZTtqs3jEHIlDIewConJw",
    authDomain: "ensat-students-ceb18.firebaseapp.com",
    projectId: "ensat-students-ceb18",
    storageBucket: "ensat-students-ceb18.firebasestorage.app",
    messagingSenderId: "299156156328",
    appId: "1:299156156328:web:8cd1d5011c0f8a9e34779d",
    measurementId: "G-9CSM03TKKB"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);
const auth = getAuth(app);
const googleProvider = new GoogleAuthProvider();

// Get CSRF token from meta tag
function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
}

// Show loading state
function showLoading(button) {
    button.disabled = true;
    button.dataset.originalText = button.innerHTML;
    button.innerHTML = '<span class="animate-spin inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full mr-2"></span>Chargement...';
}

// Hide loading state
function hideLoading(button) {
    button.disabled = false;
    if (button.dataset.originalText) {
        button.innerHTML = button.dataset.originalText;
    }
}

// Show error message
function showError(message, elementId = 'error-message') {
    const errorDiv = document.getElementById(elementId);
    if (errorDiv) {
        errorDiv.textContent = message;
        errorDiv.classList.remove('hidden');
        setTimeout(() => {
            errorDiv.classList.add('hidden');
        }, 5000);
    }
}

// Show success message
function showSuccess(message, elementId = 'success-message') {
    const successDiv = document.getElementById(elementId);
    if (successDiv) {
        successDiv.textContent = message;
        successDiv.classList.remove('hidden');
        setTimeout(() => {
            successDiv.classList.add('hidden');
        }, 3000);
    }
}

// Send Firebase ID token to Laravel backend
async function authenticateWithBackend(user) {
    try {
        const idToken = await user.getIdToken();

        const response = await fetch('/auth/firebase', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
                'Accept': 'application/json',
            },
            body: JSON.stringify({ idToken })
        });

        const data = await response.json();

        if (data.success) {
            window.location.href = data.redirect;
        } else {
            showError(data.message || 'Erreur d\'authentification');
        }
    } catch (error) {
        console.error('Backend authentication error:', error);
        showError('Erreur de connexion au serveur');
    }
}

// Email/Password Login
window.loginWithEmail = async function (email, password, button) {
    showLoading(button);

    try {
        const userCredential = await signInWithEmailAndPassword(auth, email, password);
        await authenticateWithBackend(userCredential.user);
    } catch (error) {
        hideLoading(button);
        console.error('Login error:', error);

        switch (error.code) {
            case 'auth/user-not-found':
                showError('Aucun compte trouvé avec cet email');
                break;
            case 'auth/wrong-password':
                showError('Mot de passe incorrect');
                break;
            case 'auth/invalid-email':
                showError('Email invalide');
                break;
            case 'auth/user-disabled':
                showError('Ce compte a été désactivé');
                break;
            case 'auth/invalid-credential':
                showError('Email ou mot de passe incorrect');
                break;
            default:
                showError('Erreur de connexion: ' + error.message);
        }
    }
};

// Email/Password Registration
window.registerWithEmail = async function (email, password, button) {
    showLoading(button);

    try {
        const userCredential = await createUserWithEmailAndPassword(auth, email, password);
        await authenticateWithBackend(userCredential.user);
    } catch (error) {
        hideLoading(button);
        console.error('Registration error:', error);

        switch (error.code) {
            case 'auth/email-already-in-use':
                showError('Un compte existe déjà avec cet email');
                break;
            case 'auth/invalid-email':
                showError('Email invalide');
                break;
            case 'auth/weak-password':
                showError('Le mot de passe doit contenir au moins 6 caractères');
                break;
            default:
                showError('Erreur d\'inscription: ' + error.message);
        }
    }
};

// Sign-in with Google
window.googleSignIn = async function (button) {
    showLoading(button);

    try {
        const result = await signInWithPopup(auth, googleProvider);
        await authenticateWithBackend(result.user);
    } catch (error) {
        hideLoading(button);
        console.error('Google sign-in error:', error);

        if (error.code === 'auth/popup-closed-by-user') {
            showError('Connexion annulée');
        } else if (error.code === 'auth/cancelled-popup-request') {
            // Silent error, another popup is already open
        } else {
            showError('Erreur de connexion avec Google: ' + error.message);
        }
    }
};

// Forgot Password
window.sendPasswordReset = async function (email, button) {
    showLoading(button);

    try {
        await sendPasswordResetEmail(auth, email);
        hideLoading(button);
        showSuccess('Email de réinitialisation envoyé ! Vérifiez votre boîte de réception.');

        // Clear the email field
        document.getElementById('email').value = '';
    } catch (error) {
        hideLoading(button);
        console.error('Password reset error:', error);

        switch (error.code) {
            case 'auth/user-not-found':
                showError('Aucun compte trouvé avec cet email');
                break;
            case 'auth/invalid-email':
                showError('Email invalide');
                break;
            default:
                showError('Erreur: ' + error.message);
        }
    }
};

console.log('Firebase Authentication initialized');
