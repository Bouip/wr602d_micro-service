# Vroum Vroum — Micro-service Mailer

Micro-service d'envoi de mails développé avec Symfony dans le cadre du module WR602D.

## Prérequis

- PHP 8.4
- Composer
- Symfony CLI
- Docker (pour MailHog en local)

## Installation

### 1. Installer les dépendances

```bash
composer install
```

### 2. Configurer l'environnement

```bash
cp .env .env.local
```

Modifier `.env.local` :

```env
MAILER_DSN=smtp://localhost:1025
MAILER_NO_REPLY_EMAIL=noreply@vroumvroum.fr
MAILER_REPLY_EMAIL=support@vroumvroum.fr
MAILER_FROM_NAME="Vroum Vroum"
MAILER_API_KEY_NAME=X-API-KEY
MAILER_API_KEY_VALUE=supersecretkey
```

### 3. Lancer MailHog (test local)

```bash
docker run -d -p 8025:8025 -p 1025:1025 mailhog/mailhog
```

MailHog est accessible sur `http://localhost:8025`

### 4. Lancer le serveur

```bash
symfony server:start --port=8001
```

## Point d'API

| Méthode | Route | Description | Auth |
|---------|-------|-------------|------|
| POST | `/send-mail` | Envoyer un mail | X-API-KEY header |

### Exemple de requête

```bash
curl -X POST http://localhost:8001/send-mail \
  -H "Content-Type: application/json" \
  -H "X-API-KEY: supersecretkey" \
  -d '{
    "to": "user@example.com",
    "subject": "Bienvenue !",
    "message": "Bonjour !"
  }'
```

## Sécurisation

Le micro-service est sécurisé par un header custom `X-API-KEY`. Seules les requêtes avec la bonne clé sont acceptées.

## Stack technique

- **Symfony 8** — framework PHP
- **Symfony Mailer** — envoi de mails
- **NelmioCorsBundle** — gestion CORS
- **MailHog** — serveur mail de test