
# Backend Challence

## Description

Ce projet est une application backend développée avec Laravel. Il permet de gérer des blogs, des utilisateurs, des commentaires, et des thèmes.

## Prérequis

Avant de commencer, assurez-vous d'avoir les éléments suivants installés sur votre machine :

- PHP >= 7.4
- Composer
- MySQL


## Installation

1. Clonez le dépôt :

    ```bash
    git clone https://github.com/bool-kev/backend-challence.git
    cd backend-challence
    ```

2. Installez les dépendances PHP avec Composer :

    ```bash
    composer install
    ```

3. Copiez le fichier `.env.example` en `.env` et configurez vos variables d'environnement :

    ```bash
    cp .env.example .env
    ```

4. Générez la clé de l'application :

    ```bash
    php artisan key:generate
    ```

5. Configurez votre base de données dans le fichier `.env` :

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nom_de_votre_base_de_donnees
    DB_USERNAME=votre_nom_d_utilisateur
    DB_PASSWORD=votre_mot_de_passe
    ```

6. Exécutez les migrations et les seeders pour créer les tables et les données de base :

    ```bash
    php artisan migrate --seed
    ```

## Lancer le projet

Pour démarrer le serveur de développement, exécutez la commande suivante :

```bash
php artisan serve
```

L'application sera accessible à l'adresse `http://localhost:8000`.

## Dépendances

Voici une liste des principales dépendances utilisées dans ce projet :

- Laravel
- Laravel Sanctum (pour l'authentification API)
- PHPUnit (pour les tests)
- Faker (pour générer des données factices)
