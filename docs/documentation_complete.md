# Documentation Complète du Projet de Réservation de Vols

## Table des Matières
1. [Vue d'ensemble](#1-vue-densemble)
2. [Architecture Technique](#2-architecture-technique)
   - [2.1 Stack Technologique](#21-stack-technologique)
   - [2.2 Structure des Répertoires](#22-structure-des-répertoires)
3. [Fonctionnalités Principales](#3-fonctionnalités-principales)
   - [3.1 Gestion des Vols](#31-gestion-des-vols)
   - [3.2 Réservation et Paiement](#32-réservation-et-paiement)
   - [3.3 Assistant Virtuel IA](#33-assistant-virtuel-ia)
   - [3.4 Gestion des Utilisateurs](#34-gestion-des-utilisateurs)
4. [Modèles de Données](#4-modèles-de-données)
   - [4.1 Principales Tables](#41-principales-tables)
   - [4.2 Relations](#42-relations)
5. [API Endpoints](#5-api-endpoints)
   - [5.1 Chat API](#51-chat-api)
   - [5.2 Vols](#52-vols)
   - [5.3 Réservations](#53-réservations)
6. [Installation et Configuration](#6-installation-et-configuration)
   - [6.1 Prérequis](#61-prérequis)
   - [6.2 Installation](#62-installation)
7. [Déploiement](#7-déploiement)
   - [7.1 Configuration du serveur](#71-configuration-du-serveur)
   - [7.2 Variables d'environnement clés](#72-variables-denvironnement-clés)
8. [Maintenance et Support](#8-maintenance-et-support)
   - [8.1 Tâches Planifiées](#81-tâches-planifiées)
   - [8.2 Surveillance](#82-surveillance)
9. [Sécurité](#9-sécurité)
   - [9.1 Bonnes Pratiques](#91-bonnes-pratiques)
   - [9.2 Mises à jour de Sécurité](#92-mises-à-jour-de-sécurité)
10. [Évolutions Futures](#10-évolutions-futures)
    - [10.1 Améliorations Planifiées](#101-améliorations-planifiées)
    - [10.2 Optimisations](#102-optimisations)
11. [Dépannage](#11-dépannage)
    - [11.1 Problèmes Courants](#111-problèmes-courants)
    - [11.2 Logs](#112-logs)
12. [Support](#12-support)

## 1. Vue d'ensemble

Application web de réservation de vols offrant une interface utilisateur moderne, un système de paiement intégré et un assistant virtuel IA.

## 2. Architecture Technique

### 2.1 Stack Technologique
- **Backend** : Laravel 10.x
- **Frontend** : 
  - HTML5, CSS3, JavaScript
  - Tailwind CSS 3.1
  - Alpine.js pour les interactions
  - Vite comme bundler
- **Base de données** : MySQL
- **Services externes** :
  - Monetbil pour les paiements
  - OpenRouter pour l'IA conversationnelle

### 2.2 Structure des Répertoires
```
app/
├── Http/Controllers/      # Contrôleurs
│   ├── Api/              # Contrôleurs d'API
│   └── ...               # Autres contrôleurs
├── Models/               # Modèles Eloquent
├── Services/             # Services métier
└── Providers/            # Fournisseurs de services
resources/
├── views/                # Vues Blade
│   ├── site/             # Partie publique
│   └── components/       # Composants réutilisables
database/
├── migrations/           # Migrations de base de données
└── seeders/              # Données de test
```

## 3. Fonctionnalités Principales

### 3.1 Gestion des Vols
- Recherche de vols avec filtres avancés
- Affichage des détails des vols
- Gestion des places disponibles
- Système de notation des vols

### 3.2 Réservation et Paiement
- Processus de réservation en plusieurs étapes
- Intégration avec Monetbil pour les paiements
- Gestion des statuts de réservation
- Historique des réservations utilisateur

### 3.3 Assistant Virtuel IA
- Chatbot intégré utilisant OpenRouter
- Compréhension des requêtes naturelles
- Recherche intelligente de vols
- Gestion des demandes utilisateur

### 3.4 Gestion des Utilisateurs
- Authentification et autorisation
- Rôles utilisateurs (admin, gestionnaire, utilisateur)
- Profils utilisateurs
- Historique des réservations

## 4. Modèles de Données

### 4.1 Principales Tables
- **users** : Utilisateurs du système
- **flights** : Vols disponibles
- **destinations** : Villes et aéroports
- **reservations** : Réservations des utilisateurs
- **payments** : Transactions de paiement
- **roles** : Rôles et permissions

### 4.2 Relations
- Un utilisateur a plusieurs réservations
- Un vol a plusieurs réservations
- Une réservation appartient à un utilisateur et un vol
- Un vol a une ville de départ et une destination

## 5. API Endpoints

### 5.1 Chat API
- `POST /api/v1/openrouter/chat` : Envoi de message au chatbot

### 5.2 Vols
- `GET /flights` : Liste des vols
- `GET /flights/search` : Recherche de vols
- `GET /flights/{id}` : Détails d'un vol

### 5.3 Réservations
- `GET /reservations` : Liste des réservations
- `POST /reservations` : Créer une réservation
- `GET /reservations/{id}` : Détails d'une réservation

## 6. Installation et Configuration

### 6.1 Prérequis
- PHP 8.1+
- Composer
- Node.js 16+
- MySQL 5.7+
- Clé API OpenRouter

### 6.2 Installation
```bash
# Cloner le dépôt
git clone [url-du-projet]
cd reservation-de-vole

# Installer les dépendances PHP
composer install

# Installer les dépendances Node.js
npm install

# Copier le fichier d'environnement
cp .env.example .env

# Générer la clé d'application
php artisan key:generate

# Configurer la base de données dans .env
# ...

# Exécuter les migrations
php artisan migrate --seed

# Compiler les assets
npm run build
```

## 7. Déploiement

### 7.1 Configuration du serveur
- Serveur web (Nginx/Apache)
- PHP 8.1+ avec extensions requises
- Base de données MySQL
- File d'attente pour les tâches asynchrones

### 7.2 Variables d'environnement clés
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://votre-domaine.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nom_de_la_base
DB_USERNAME=utilisateur
DB_PASSWORD=motdepasse

OPENROUTER_API_KEY=votre_cle_api
MONETBIL_SERVICE_KEY=votre_cle_service
```

## 8. Maintenance et Support

### 8.1 Tâches Planifiées
```bash
# Planifier la tâche de nettoyage
* * * * * cd /chemin/vers/projet && php artisan schedule:run >> /dev/null 2>&1
```

### 8.2 Surveillance
- Surveiller les logs Laravel
- Configurer des alertes pour les erreurs
- Sauvegardes régulières de la base de données

## 9. Sécurité

### 9.1 Bonnes Pratiques
- Validation des entrées utilisateur
- Protection CSRF
- Hash des mots de passe
- Protection contre les injections SQL
- Limitation des tentatives de connexion

### 9.2 Mises à jour de Sécurité
- Mettre à jour régulièrement les dépendances
- Surveiller les vulnérabilités connues
- Appliquer les correctifs de sécurité

## 10. Évolutions Futures

### 10.1 Améliorations Planifiées
- Intégration avec d'autres fournisseurs de paiement
- Système de fidélité
- Notifications en temps réel
- Application mobile native

### 10.2 Optimisations
- Mise en cache des requêtes fréquentes
- Optimisation des performances frontend
- Amélioration de l'expérience mobile

## 11. Dépannage

### 11.1 Problèmes Courants
- **Problème de connexion à la base de données** : Vérifier les informations de connexion dans .env
- **Erreurs d'API** : Vérifier les clés API et la connectivité
- **Problèmes de paiement** : Vérifier les logs et l'état du service Monetbil

### 11.2 Logs
Les logs de l'application sont disponibles dans `storage/logs/`. Les erreurs critiques sont également enregistrées dans les logs du serveur.

## 12. Support

Pour tout problème ou question, veuillez contacter l'équipe de support à support@exemple.com.
