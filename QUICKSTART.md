# ⚡ Démarrage Rapide - ENSAT Students

## 🎯 Prérequis

✅ PHP 8.2+ avec PDO SQLite activé  
✅ Composer  
✅ Node.js & npm

## 📦 Installation Express Ndaaaaa

```powershell
# 1. Installer les dépendances
composer install
npm install

# 2. Vérifier SQLite (si erreur, voir SETUP-DATABASE.md)
php -r "echo extension_loaded('pdo_sqlite') ? 'SQLite OK' : 'ERREUR: Voir SETUP-DATABASE.md';"

# 3. Créer la base de données
php artisan migrate:fresh --seed

# 4. Compiler les assets (terminal 1)
npm run dev

# 5. Lancer le serveur (terminal 2, nouvelle fenêtre)
php artisan serve
```

## 🌐 Accéder à l'Application

Ouvrez votre navigateur : **http://127.0.0.1:8000**

## 🔑 Se Connecter

### Admin
- Email: `admin@ensat.ma`
- Password: `admin123`

### Student
- Inscrivez-vous via Firebase (Email/Password  ou Google)
- L'admin créera votre profil étudiant

## 🔥 Configuration Firebase (Important!)

Le code utilise déjà le projet `ensat-students-ceb18`. Pour activer complètement Firebase:

### 1. Télécharger la clé de service

- Allez sur [Firebase Console](https://console.firebase.google.com)
- Projet: `ensat-students-ceb18`
- **Project Settings** → **Service Accounts** → **Generate New Private Key**

### 2. Placer le fichier

```powershell
# Créer le dossier
New-Item -Path "storage\app\firebase" -ItemType Directory -Force

# Copier votre fichier téléchargé dans:
# storage/app/firebase/serviceAccountKey.json
```

### 3. Activer Google Sign-In hahahahaaaaaaaaaa

- Firebase Console → **Authentication** → **Sign-in method**
- Activez **Email/Password** ✅
- Activez **Google** ✅

### 4. Créer le compte admin Firebase (optionnel)

- Firebase Console → **Authentication** → **Users** → **Add User**
- Email: `admin@ensat.ma`
- Password: `admin123`

## 🐛 Problèmes Courants

### "PDO SQLite NOT enabled"
→ Consultez **SETUP-DATABASE.md** pour activer SQLite ou utiliser MySQL

### "Firebase credentials not found"
→ Vérifiez que `storage/app/firebase/serviceAccountKey.json` existe

### Assets ne se chargent pas
→ Assurez-vous que `npm run dev` tourne dans un terminal

### Erreur 403
→ Vous n'avez pas les droits admin. Connectez-vous avec `admin@ensat.ma`

## 📚 Documentation Complète

Consultez **[README.md](README.md)** pour:
- Configuration détaillée
- Structure du projet
- Guide d'utilisation complet
- Dépannage avancé

## ✅ Liste de Contrôle

- [ ] PHP PDO SQLite activé
- [ ] Base de données migrée (`php artisan migrate:fresh --seed`)
- [ ] Assets compilés (`npm run dev` tourne)
- [ ] Serveur lancé (`php artisan serve`)
- [ ] Firebase service account JSON en place
- [ ] Google Sign-In activé dans Firebase
- [ ] Connexion admin testée (`admin@ensat.ma`)

---

**Besoin d'aide?** Consultez README.md ou SETUP-DATABASE.md
