# Cronos - Système de Réservation de Vols

## Aperçu

Cronos est une application web complète de réservation de vols développée avec Laravel et Tailwind CSS. Cette plateforme permet aux utilisateurs de rechercher, comparer et réserver des vols facilement, tout en offrant aux administrateurs et gestionnaires des outils puissants pour gérer les vols, destinations et réservations.

## Fonctionnalités principales

### Pour les utilisateurs
- **Recherche de vols** : Filtrage par ville de départ, destination, date et budget
- **Réservation simplifiée** : Processus de réservation en quelques clics
- **Gestion des réservations** : Visualisation et annulation des réservations
- **Profil utilisateur** : Gestion des informations personnelles et historique des voyages
- **Programme de fidélité** : Accumulation de points pour chaque vol réservé

### Pour les gestionnaires
- **Gestion des vols** : Ajout, modification et suppression de vols
- **Gestion des destinations** : Configuration des destinations disponibles
- **Suivi des réservations** : Vue d'ensemble de toutes les réservations

### Pour les administrateurs
- **Tableau de bord analytique** : Statistiques et rapports sur l'activité
- **Gestion des utilisateurs** : Administration des comptes utilisateurs
- **Supervision globale** : Contrôle de tous les aspects de la plateforme

## Technologies utilisées

- **Backend** : Laravel 10
- **Frontend** : Tailwind CSS, Alpine.js
- **Base de données** : MySQL
- **Authentification** : Laravel UI
- **Interface admin** : Template personnalisé avec Material Design Icons

## Installation

### Prérequis
- PHP 8.0+
- Composer
- Node.js et NPM
- MySQL

### Étapes d'installation

1. Cloner le dépôt
```bash
git clone https://github.com/yagami-gang/CronosProject.git
cd CronosProject
```

2. Installer les dépendances
```bash
composer install
npm install
npm run dev
```

3. Configurer l'environnement
```bash
cp .env.example .env
php artisan key:generate
```

4. Configurer la base de données dans le fichier `.env`
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=Cronos
DB_USERNAME=root
DB_PASSWORD=
```

5. Exécuter les migrations et les seeders
```bash
php artisan migrate --seed
```

6. Démarrer le serveur
```bash
php artisan serve
```

## Structure du projet

```
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   ├── Manager/
│   │   │   └── Site/
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Models/
│   └── Services/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
│   ├── css/
│   ├── js/
│   └── images/
├── resources/
│   ├── views/
│   │   ├── administration/
│   │   ├── auth/
│   │   └── site/
│   ├── js/
│   └── css/
└── routes/
    ├── web.php
    └── api.php
```

## Rôles utilisateurs

1. **Visiteur** : Peut rechercher des vols mais doit s'inscrire pour réserver
2. **Utilisateur** : Peut réserver des vols et gérer ses réservations
3. **Gestionnaire** : Peut gérer les vols, destinations et réservations
4. **Administrateur** : A accès à toutes les fonctionnalités et peut gérer les utilisateurs

## Captures d'écran

### Page d'accueil
![Page d'accueil](public/images/screenshots/home.png)

### Recherche de vols
![Recherche de vols](public/images/screenshots/search.png)

### Tableau de bord utilisateur
![Tableau de bord utilisateur](public/images/screenshots/user-dashboard.png)

### Interface d'administration
![Interface d'administration](public/images/screenshots/admin-dashboard.png)

## Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus d'informations.

---