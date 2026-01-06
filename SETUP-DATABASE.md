# ⚠️ IMPORTANT: Activer l'extension PDO SQLite

## Problème

L'extension `pdo_sqlite` n'est pas activée dans votre installation PHP.

## Solution (Windows)

### 1. Trouver votre fichier php.ini

```powershell
php --ini
```

Cherchez la ligne "Loaded Configuration File" pour trouver le chemin.

### 2. Modifier php.ini

Ouvrez le fichier `php.ini` avec un éditeur de texte (en tant qu'administrateur).

### 3. Activer les extensions SQLite

Recherchez et décommentez (enlevez le `;` au début) ces lignes:

```ini
;extension=pdo_sqlite
;extension=sqlite3
```

Elles doivent devenir:

```ini
extension=pdo_sqlite
extension=sqlite3
```

### 4. Redémarrer le serveur

Si vous utilisez XAMPP/WAMP, redémarrez Apache.
Si vous utilisez `php artisan serve`, arrêtez (Ctrl+C) et relancez.

### 5. Vérifier l'activation

```bash
php -r "echo extension_loaded('pdo_sqlite') ? 'PDO SQLite enabled' : 'PDO SQLite NOT enabled';"
```

Vous devriez voir: `PDO SQLite enabled`

## 🔄 Alternative: Utiliser MySQL

Si vous ne pouvez pas activer SQLite, vous pouvez utiliser MySQL :

### 1. Installer MySQL

Téléchargez et installez [MySQL Community Server](https://dev.mysql.com/downloads/mysql/) ou utilisez XAMPP qui inclut MySQL.

### 2. Créer une base de données

```sql
CREATE DATABASE ensat_students CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 3. Modifier `.env`

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ensat_students
DB_USERNAME=root
DB_PASSWORD=votre_mot_de_passe
```

### 4. Exécuter les migrations

```bash
php artisan config:clear
php artisan migrate:fresh --seed
```

## ✅ Continuer l'installation

Une fois SQLite activé (ou MySQL configuré), exécutez:

```bash
php artisan migrate:fresh --seed
```

Puis suivez le README.md principal pour lancer l'application.
