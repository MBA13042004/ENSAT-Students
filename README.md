# ENSAT Students - Gestion des Étudiants

Application Laravel 12 de gestion des étudiants avec authentification Firebase (Email/Password + Google Sign-In), rôles (Admin/Student), et interface moderne Tailwind CSS.

## ⚠️ IMPORTANT - Avant de commencer

**PDO SQLite doit être activé dans votre PHP.** Si vous obtenez une erreur de connexion à la base de données, consultez **[SETUP-DATABASE.md](SETUP-DATABASE.md)** pour activer l'extension ou configurer MySQL.

Vérifiez rapidement si SQLite est activé:
```bash
php -r "echo extension_loaded('pdo_sqlite') ? 'OK' : 'PDO SQLite NOT enabled - See SETUP-DATABASE.md';"
```

## 🚀 Fonctionnalités

- **Authentification Firebase**
  - Inscription et connexion par email/password
  - Connexion Google (OAuth2)
  - Réinitialisation de mot de passe
  
- **Rôles & Autorisations**
  - **Admin**: CRUD complet des étudiants (créer, lire, modifier, supprimer, rechercher)
  - **Student**: Consultation de son propre profil uniquement

- **Gestion des Étudiants** (Admin)
  - Liste avec recherche et pagination
  - Création/modification/suppression
  - Affichage détaillé

- **Interface Moderne**
  - Dark mode avec Tailwind CSS
  - Responsive design
  - Formulaires centrés et stylés

## 📋 Prérequis

- **PHP** 8.2 ou supérieur
- **Composer** 2.x
- **Node.js** 18.x ou supérieur et npm
- **SQLite** (inclus avec PHP sur Windows)

## 🔧 Installation

### 1. Installer les dépendances

```bash
# Dépendances PHP
composer install

# Dépendances JavaScript
npm install
```

### 2. Configuration de l'environnement

Le fichier `.env` existe déjà. Vérifiez les configurations suivantes :

```env
DB_CONNECTION=sqlite
# Le fichier database.sqlite est déjà créé
```

### 3. Générer la clé d'application (si pas déjà fait) Ndaaa

```bash
php artisan key:generate
```

### 4. Créer et peupler la base de données

```bash
# Exécuter les migrations et seeders
php artisan migrate --seed
```

Cela va créer :
- Les tables `users` et `students`
- Un compte administrateur par défaut

### 5. Compiler les assets

```bash
# Pour le développement (avec hot reload)
npm run dev

# OU pour la production
npm run build
```

### 6. Lancer le serveur

Dans un terminal séparé :

```bash
php artisan serve
```

L'application sera accessible sur : **http://127.0.0.1:8000**

## 👤 Comptes de Test

### Administrateur
- **Email**: `admin@ensat.ma`
- **Mot de passe**: `admin123`

> **Note**: Pour utiliser Google Sign-In avec le compte admin, vous devez d'abord créer un utilisateur Firebase avec l'email `admin@ensat.ma` dans la Firebase Console.

### Étudiants
Les étudiants doivent d'abord s'inscrire via Firebase (Email/Password ou Google).
Après inscription, l'admin peut créer leur profil étudiant dans le système.

## 🔥 Configuration Firebase

### Étape 1: Obtenir le Service Account JSON

1. Allez sur [Firebase Console](https://console.firebase.google.com)
2. Sélectionnez votre projet `ensat-students-ceb18`
3. **Project Settings** (icône engrenage) → **Service Accounts**
4. Cliquez sur **Generate New Private Key**
5. Téléchargez le fichier JSON

### Étape 2: Placer le fichier de credentials

```bash
# Créer le dossier
New-Item -Path "storage\app\firebase" -ItemType Directory -Force

# Copier votre fichier téléchargé dans:
# storage/app/firebase/serviceAccountKey.json
```

### Étape 3: Activer Google Sign-In dans Firebase

1. Dans Firebase Console → **Authentication** → **Sign-in method**
2. Activez **Email/Password**
3. Activez **Google** et configurez le support email

### Étape 4: Vérifier la configuration

Le fichier `.env` contient déjà la configuration Firebase :

```env
FIREBASE_PROJECT_ID=ensat-students-ceb18
FIREBASE_CREDENTIALS=storage/app/firebase/serviceAccountKey.json
ADMIN_EMAIL=admin@ensat.ma

# Configuration frontend (déjà dans .env)
VITE_FIREBASE_API_KEY=AIzaSyA-i0w8f7q9DlOZTtqs3jEHIlDIewConJw
VITE_FIREBASE_AUTH_DOMAIN=ensat-students-ceb18.firebaseapp.com
VITE_FIREBASE_PROJECT_ID=ensat-students-ceb18
# ... etc
```

## 📧 Configuration Email (Optionnelle)

Pour la réinitialisation de mot de passe, Firebase envoie les emails automatiquement.

Si vous souhaitez configurer l'envoi d'emails Laravel :

### Option 1: Mailtrap (Recommandé pour dev)

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
```

### Option 2: Mode Log (par défaut)

Les emails sont écrits dans `storage/logs/laravel.log`

```env
MAIL_MAILER=log
```

## 📁 Structure du Projet

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/StudentController.php    # CRUD étudiants
│   │   ├── Auth/FirebaseAuthController.php # Auth Firebase
│   │   └── StudentProfileController.php    # Profil étudiant
│   └── Middleware/
│       └── EnsureUserIsAdmin.php           # Middleware admin
├── Models/
│   ├── User.php                            # Modèle utilisateur
│   └── Student.php                         # Modèle étudiant
database/
├── migrations/                             # Migrations DB
└── seeders/
    └── AdminSeeder.php                     # Seed admin
resources/
├── views/
│   ├── auth/                               # Pages auth Firebase
│   ├── admin/students/                     # Pages CRUD admin
│   └── student/profile.blade.php           # Profil étudiant
└── js/
    └── firebase-auth.js                    # Module Firebase JS
routes/
├── web.php                                 # Routes principales
└── auth.php                                # Routes authentification
```

## 🎯 Utilisation

### Pour les Administrateurs

1. Connectez-vous avec `admin@ensat.ma` / `admin123`
2. Vous serez redirigé vers `/admin/students`
3. Gérez les étudiants (créer, modifier, supprimer, rechercher)

### Pour les Étudiants

1. Inscrivez-vous via Email/Password ou Google Sign-In
2. Vous serez redirigé vers `/student/profile`
3. Si votre profil n'existe pas encore, contactez l'admin
4. L'admin crée votre enregistrement d'étudiant avec votre email
5. Vous pouvez maintenant voir vos informations

## 🔒 Sécurité

- ✅ Mots de passe hashés avec bcrypt
- ✅ Protection CSRF sur tous les formulaires
- ✅ Vérification des tokens Firebase côté serveur
- ✅ Middleware de rôles pour les routes admin
- ✅ Validation des données côté serveur
- ✅ Unicité des CIN, Code Apogée, et Emails

## 🐛 Dépannage

### Erreur "Firebase credentials not found"

Vérifiez que `storage/app/firebase/serviceAccountKey.json` existe et contient votre clé de service Firebase.

### Erreur "Token invalide ou expiré"

Le token Firebase peut expirer. Reconnectez-vous. Vérifiez également que la clé de service est correcte.

### Erreur 403 "Accès non autorisé"

Vous essayez d'accéder à une page admin sans être admin. Connectez-vous avec le compte admin.

### Les assets ne se chargent pas

Assurez-vous que `npm run dev` ou `npm run build` est exécuté et que Vite fonctionne correctement.

### Base de données verrouillée (SQLite)

Fermez toutes les connexions à la base de données et redémarrez le serveur.

## 🔄 Workflow Complet

### Créer un nouvel utilisateur Firebase Admin

1. Allez sur Firebase Console → Authentication
2. Cliquez **Add User**
3. Email: `admin@ensat.ma`
4. Mot de passe: `admin123` (ou votre choix)
5. L'utilisateur sera automatiquement assigné role ADMIN lors de la première connexion

### Ajouter un étudiant (Admin)

1. Connectez-vous en tant qu'admin
2. Allez sur `/admin/students`
3. Cliquez **+ Ajouter un étudiant**
4. Remplissez le formulaire (Code Apogée, CIN, nom, prénom, email, etc.)
5. L'étudiant peut maintenant se connecter avec cet email via Firebase

### Étudiant consulte son profil

1. L'étudiant s'inscrit/se connecte via Firebase (Email ou Google)
2. Il est redirigé vers `/student/profile`
3. Le système trouve son enregistrement par email
4. Il voit ses informations (CIN, Apogée, filière, etc.)

## 📝 Technologies Utilisées

- **Backend**: Laravel 12, PHP 8.4
- **Frontend**: Blade Templates, Tailwind CSS 3, Alpine.js
- **Database**: SQLite (dev), compatible MySQL (prod)
- **Authentication**: Firebase Authentication (JS SDK + Admin SDK PHP)
- **Package Manager**: Composer, npm
- **Build Tool**: Vite

## 📦 Dépendances Principales

- `laravel/framework: ^12.0`
- `laravel/breeze: ^2.3`
- `kreait/firebase-php: ^5.26`
- `firebase: ^10` (npm)

## 🤝 Support

Pour toute question ou problème :
1. Vérifiez la section **Dépannage** ci-dessus
2. Consultez les logs Laravel dans `storage/logs/laravel.log`
3. Vérifiez la console du navigateur pour les erreurs JavaScript

## 📄 License

Application développée pour ENSAT (École Nationale des Sciences Appliquées de Tanger).

---

**Auteur**: Antigravity AI
**Date**: Décembre 2025
**Version**: 1.0.0
#   E N S A T - S t u d e n t s 
 
 