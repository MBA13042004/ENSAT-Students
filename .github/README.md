# 🐳 Configuration Docker & CI/CD

Ce dossier contient la configuration GitHub Actions pour l'intégration continue et le déploiement automatique de l'application ENSAT Students.

## 📁 Structure

```
.github/
└── workflows/
    └── deploy.yml    # Pipeline CI/CD principal
```

## 🔄 Workflow: Deploy

### Déclencheurs

- ✅ Push sur `main`
- ✅ Push sur `develop`
- ✅ Pull Request vers `main`

### Jobs

#### 1️⃣ Test & Lint
- Installation PHP 8.4 et dépendances
- Vérification style code (Laravel Pint)
- Exécution tests PHPUnit
- Build assets Vite/Tailwind

#### 2️⃣ Build & Push Docker
- Construction image multi-stage
- Publication sur Docker Hub
- Tags: `latest` et `main-<sha>`
- Support multi-plateforme (amd64, arm64)

#### 3️⃣ Deploy (Template)
- Prêt à configurer pour déploiement SSH
- Exemple fourni dans le workflow

## 🔐 Secrets Requis

Configurez ces secrets dans **Settings → Secrets and variables → Actions**:

| Secret | Description |
|--------|-------------|
| `DOCKER_USERNAME` | Nom d'utilisateur Docker Hub |
| `DOCKER_PASSWORD` | Token/mot de passe Docker Hub |

### Secrets Optionnels (pour déploiement)

| Secret | Description |
|--------|-------------|
| `DEPLOY_HOST` | IP/domaine du serveur |
| `DEPLOY_USER` | Utilisateur SSH |
| `DEPLOY_SSH_KEY` | Clé privée SSH |

## 📊 Statut du Build

Le workflow crée automatiquement des artifacts et publie l'image Docker sur:
```
<DOCKER_USERNAME>/ensat-students:latest
<DOCKER_USERNAME>/ensat-students:main-<commit-sha>
```

## 🚀 Utilisation

### Voir les résultats
1. Onglet **Actions** dans GitHub
2. Sélectionner un workflow run
3. Voir les logs de chaque job

### Pull l'image Docker

```bash
docker pull <votre-username>/ensat-students:latest
```

## 📝 Modification du Workflow

Pour modifier le workflow:

1. Éditer `.github/workflows/deploy.yml`
2. Commit et push sur `main`
3. Le workflow se déclenche automatiquement

## 🛠️ Personnalisation

### Changer les branches surveillées

```yaml
on:
  push:
    branches: [ main, staging, production ]
```

### Ajouter des notifications

```yaml
- name: Notify on success
  uses: 8398a7/action-slack@v3
  with:
    status: ${{ job.status }}
    webhook_url: ${{ secrets.SLACK_WEBHOOK }}
```

### Déploiement automatique SSH

Décommentez la section deploy dans le workflow et configurez les secrets.

## 📚 Documentation

- [Documentation Docker complète](../DOCKER.md)
- [README principal](../README.md)
- [GitHub Actions Docs](https://docs.github.com/en/actions)

---

**Configuration créée par**: Antigravity AI  
**Date**: Janvier 2026
