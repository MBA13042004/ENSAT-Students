# 🐳 Guide Docker - ENSAT Students

Ce guide explique comment utiliser Docker pour développer et déployer l'application ENSAT Students.

## 📋 Table des Matières

- [Architecture](#architecture)
- [Prérequis](#prérequis)
- [Démarrage Rapide](#démarrage-rapide)
- [Configuration](#configuration)
- [Commandes Utiles](#commandes-utiles)
- [Production](#production)
- [Dépannage](#dépannage)

---

## Architecture

L'application utilise une architecture multi-conteneurs:

```
┌─────────────────┐
│   Navigateur    │
└────────┬────────┘
         │ :8080
         ▼
┌─────────────────┐
│  Nginx (Alpine) │ ← Serveur web, fichiers statiques
└────────┬────────┘
         │ :9000 (FastCGI)
         ▼
┌─────────────────┐
│  PHP-FPM 8.4    │ ← Application Laravel
└────────┬────────┘
         │ :3306
         ▼
┌─────────────────┐
│   MySQL 8.0     │ ← Base de données
└─────────────────┘
```

### Services

| Service | Image | Port | Description |
|---------|-------|------|-------------|
| `app` | Custom (Dockerfile) | 9000 | PHP-FPM avec Laravel |
| `webserver` | nginx:alpine | 8080 | Serveur web Nginx |
| `db` | mysql:8.0 | 3307 | Base de données MySQL (interne: 3306) |

---

## Prérequis

- **Docker** 20.10+ ([Télécharger](https://www.docker.com/products/docker-desktop))
- **Docker Compose** 2.0+ (inclus avec Docker Desktop)
- Au minimum 4 GB de RAM disponible pour Docker

Vérifier l'installation:
```bash
docker --version
docker-compose --version
```

---

## Démarrage Rapide

### 1. Cloner le projet (si ce n'est pas déjà fait)

```bash
git clone <repository-url>
cd My_Project_Php
```

### 2. Configurer Firebase (Important!)

Créez le dossier Firebase et ajoutez votre clé de service:

```bash
mkdir -p storage/app/firebase
```

Téléchargez `serviceAccountKey.json` depuis Firebase Console et placez-le dans:
```
storage/app/firebase/serviceAccountKey.json
```

> **Note**: Ce fichier est ignoré par Git pour des raisons de sécurité.

### 3. Lancer l'application

```bash
docker-compose up -d
```

Cette commande va:
- 🏗️ Construire l'image Docker (première fois seulement, ~5-10 min)
- 🚀 Démarrer tous les services
- 📊 Exécuter les migrations automatiquement
- 🌱 Créer le compte admin par défaut

### 4. Vérifier le statut

```bash
docker-compose ps
```

Tous les services doivent être `Up` et healthy.

### 5. Accéder à l'application

Ouvrez votre navigateur: **http://localhost:8080**

**Compte administrateur:**
- Email: `admin@ensat.ma`
- Mot de passe: `admin123`

---

## Configuration

### Variables d'Environnement

Les variables sont définies dans `docker-compose.yml`. Principales configurations:

#### Base de Données
```yaml
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306  # Port interne du conteneur (3307 sur l'hôte)
DB_DATABASE=ensat_students
DB_USERNAME=ensat_user
DB_PASSWORD=ensat_secure_password_2026  # ⚠️ Changez en production!
```

#### Firebase
```yaml
FIREBASE_PROJECT_ID=ensat-students-ceb18
FIREBASE_CREDENTIALS=/var/www/html/storage/app/firebase/serviceAccountKey.json
ADMIN_EMAIL=admin@ensat.ma
```

#### Application
```yaml
APP_ENV=production
APP_DEBUG=false  # true pour développement
APP_URL=http://localhost:8080
```

### Modifier la Configuration

Éditez `docker-compose.yml` puis redémarrez:

```bash
docker-compose down
docker-compose up -d
```

---

## Commandes Utiles

### Gestion des Conteneurs

```bash
# Démarrer tous les services
docker-compose up -d

# Arrêter tous les services
docker-compose down

# Redémarrer un service spécifique
docker-compose restart app

# Voir les logs en temps réel
docker-compose logs -f

# Logs d'un service spécifique
docker-compose logs -f app
docker-compose logs -f webserver
docker-compose logs -f db

# Voir le statut des conteneurs
docker-compose ps
```

### Commandes Laravel

Exécuter des commandes Artisan dans le conteneur:

```bash
# Syntaxe générale
docker-compose exec app php artisan <command>

# Exemples
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:list
docker-compose exec app php artisan tinker
```

### Base de Données

```bash
# Accéder au shell MySQL
docker-compose exec db mysql -u ensat_user -p
# Mot de passe: ensat_secure_password_2026

# Backup de la base de données
docker-compose exec db mysqldump -u ensat_user -p ensat_students > backup.sql

# Restaurer une base de données
docker-compose exec -T db mysql -u ensat_user -p ensat_students < backup.sql

# Réinitialiser complètement la base de données
docker-compose exec app php artisan migrate:fresh --seed
```

### Shell dans le Conteneur

```bash
# Ouvrir un shell dans le conteneur app
docker-compose exec app sh

# Ouvrir un shell en tant que root
docker-compose exec -u root app sh
```

### Rebuild Complet

Si vous modifiez le `Dockerfile` ou les dépendances:

```bash
# Rebuild sans cache
docker-compose build --no-cache

# Rebuild et redémarrer
docker-compose up -d --build --force-recreate
```

### Nettoyage

```bash
# Arrêter et supprimer tous les conteneurs
docker-compose down

# Supprimer aussi les volumes (⚠️ supprime la base de données!)
docker-compose down -v

# Nettoyer Docker complètement
docker system prune -a --volumes
```

---

## Production

### Préparation

1. **Modifier les mots de passe:**

Éditez `docker-compose.yml`:
```yaml
DB_PASSWORD=votre_mot_de_passe_fort_2026
MYSQL_PASSWORD=votre_mot_de_passe_fort_2026
MYSQL_ROOT_PASSWORD=votre_root_password_fort_2026
```

2. **Désactiver le debug:**
```yaml
APP_DEBUG=false
APP_ENV=production
```

3. **Configurer l'URL:**
```yaml
APP_URL=https://votre-domaine.com
```

### Déploiement avec Docker Hub

L'image est automatiquement construite et publiée via GitHub Actions.

#### Pull de l'image depuis Docker Hub

```bash
docker pull <votre-username>/ensat-students:latest
```

#### Utiliser l'image pré-construite

Modifiez `docker-compose.yml`:
```yaml
services:
  app:
    image: <votre-username>/ensat-students:latest
    # Commentez la section build:
    # build:
    #   context: .
    #   dockerfile: Dockerfile
```

Puis:
```bash
docker-compose pull
docker-compose up -d
```

### HTTPS avec Nginx Proxy

Pour ajouter HTTPS en production, utilisez un reverse proxy comme:
- **Traefik**
- **Nginx Proxy Manager**
- **Caddy**

Exemple avec Let's Encrypt automatique via Traefik disponible sur demande.

### Healthcheck

Le service MySQL a un healthcheck intégré. Pour ajouter un healthcheck à l'app:

```yaml
services:
  app:
    healthcheck:
      test: ["CMD", "php", "artisan", "tinker", "--execute=echo 'ok';"]
      interval: 30s
      timeout: 10s
      retries: 3
```

---

## Dépannage

### Le conteneur `app` redémarre en boucle

**Vérifier les logs:**
```bash
docker-compose logs app
```

**Causes communes:**
- Base de données pas prête → Le script attend déjà 30s
- Erreur de migration → Vérifier les fichiers de migration
- Permission denied → Exécuter en tant que root: `docker-compose exec -u root app sh`

### Erreur "Connection refused" à la base de données

**Solution:**
```bash
# Vérifier que le service db est healthy
docker-compose ps

# Redémarrer les services dans l'ordre
docker-compose down
docker-compose up -d db
# Attendre 10s
docker-compose up -d app webserver
```

### Assets Vite ne se chargent pas (404)

**Cause:** Les assets ne sont pas buildés dans l'image.

**Solution:**
```bash
# Rebuild l'image
docker-compose build --no-cache app
docker-compose up -d --force-recreate app
```

### "Firebase credentials not found"

**Solution:**
```bash
# Vérifier que le fichier existe
docker-compose exec app ls -la storage/app/firebase/

# Si absent, créer et redémarrer
mkdir -p storage/app/firebase
# Copier votre serviceAccountKey.json
docker-compose restart app
```

### Port 8080 déjà utilisé

**Modifier le port dans docker-compose.yml:**
```yaml
services:
  webserver:
    ports:
      - "9090:80"  # Utilisez 9090 au lieu de 8080
```

### Performances lentes sur Windows

**Amélioration:**
- Utilisez WSL 2 au lieu d'Hyper-V
- Placez le projet dans le système de fichiers Linux WSL (`\\wsl$\Ubuntu\home\user\project`)
- Augmentez la RAM Docker dans Docker Desktop → Settings → Resources

### Voir l'utilisation des ressources

```bash
docker stats
```

---

## 🔐 Sécurité en Production

**Checklist:**
- [ ] Changer TOUS les mots de passe par défaut
- [ ] Désactiver `APP_DEBUG=false`
- [ ] Utiliser HTTPS (certificat SSL)
- [ ] Ne PAS exposer le port MySQL (3306) publiquement
- [ ] Utiliser des secrets Docker pour les credentials sensibles
- [ ] Mettre à jour régulièrement les images de base
- [ ] Limiter les ressources des conteneurs (CPU/RAM)
- [ ] Configurer un pare-feu
- [ ] Activer les logs centralisés
- [ ] Sauvegardes automatiques de la base de données

---

## 📚 Ressources

- [Documentation Docker](https://docs.docker.com/)
- [Docker Compose Reference](https://docs.docker.com/compose/compose-file/)
- [Laravel Deployment](https://laravel.com/docs/deployment)
- [PHP-FPM Configuration](https://www.php.net/manual/en/install.fpm.configuration.php)
- [Nginx Configuration](https://nginx.org/en/docs/)

---

## 🆘 Support

En cas de problème:

1. ✅ Consultez la section [Dépannage](#dépannage)
2. 📋 Vérifiez les logs: `docker-compose logs -f`
3. 🔍 Recherchez l'erreur sur Google/Stack Overflow
4. 💬 Ouvrez une issue sur GitHub

---

**Version:** 1.0.0  
**Dernière mise à jour:** Janvier 2026
