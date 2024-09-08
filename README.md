# Projet Coloriage - Site Web de Livres de Coloriage

## Description

Le projet **Coloriage** est un site web permettant de proposer une liste de livres de coloriage accessibles publiquement. Les utilisateurs peuvent visualiser les détails de chaque livre et suivre leur progression à travers les pages de coloriage. Le site propose deux types de comptes : **utilisateur** et **admin**.

- **Utilisateur** : Peut consulter la liste des livres et accéder à une page pour suivre sa progression dans les livres.
- **Admin** : A la possibilité d'ajouter, modifier ou supprimer des livres de coloriage.

## Fonctionnalités

### Public
- **Liste des livres de coloriage** : Tout utilisateur peut consulter la liste des livres disponibles.
- **Page de détails d'un livre** : Visualisation des informations détaillées d'un livre (titre, description, etc.).

### Utilisateur
- **Connexion** : Les utilisateurs peuvent se connecter pour suivre leur progression dans les livres.
- **Page de progression** : Une fois connecté, l'utilisateur a accès à une page spéciale pour suivre la progression de ses coloriages (chaque livre comporte 100 coloriages).
  
### Admin
- **Gestion des livres** : L'administrateur peut ajouter, modifier et supprimer des livres de coloriage.
- **Accès sécurisé** : L'administration nécessite des droits spécifiques.

## Technologies Utilisées

- **Symfony 6.4** : Framework PHP utilisé pour construire l'application.
- **PHP 8.x** : Version de PHP utilisée.
- **Doctrine ORM** : Utilisé pour la gestion de la base de données.
- **Twig** : Moteur de template pour la génération de vues.
- **MySQL** : Base de données utilisée pour stocker les informations des utilisateurs et des livres.
- **Bootstrap** : Utilisé pour styliser l'interface utilisateur.
