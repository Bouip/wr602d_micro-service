# VROUM VROUM — Micro-service

Micro-service d'envoi de mails fait avec Symfony.

## Prérequis

- PHP 8.4, Composer, Symfony CLI, Docker

## Installation

```bash
composer install
cp .env .env.local
```

Modifie `.env.local` :

```env
MAILER_DSN=smtp://localhost:1025
MAILER_NO_REPLY_EMAIL=noreply@vroumvroum.fr
MAILER_FROM_NAME="Vroum Vroum"
MAILER_API_KEY_NAME=X-API-KEY
MAILER_API_KEY_VALUE=supersecretkey
```

Lance MailHog pour les tests :

```bash
docker run -d -p 8025:8025 -p 1025:1025 mailhog/mailhog
symfony server:start --port=8001
```

MailHog dispo sur `http://localhost:8025`

## Point d'API

| Méthode | Route | Auth |
|---------|-------|------|
| POST | `/send-mail` | X-API-KEY |

```bash
curl -X POST http://localhost:8001/send-mail \
  -H "Content-Type: application/json" \
  -H "X-API-KEY: supersecretkey" \
  -d '{"to": "user@example.com", "subject": "Bienvenue !", "message": "Bonjour !"}'
```

## Stack

- Symfony 8, Symfony Mailer, MailHog