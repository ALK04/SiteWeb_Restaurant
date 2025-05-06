Bien sûr ! Voici un exemple de fichier `README.md` pour ton projet **SiteWeb\_Restaurant** en PHP orienté objet, connecté à une base de données MySQL :

---

# 🍽️ SiteWeb\_Restaurant

## Description

**SiteWeb\_Restaurant** est une application web développée en PHP orienté objet **sans framework**, dans le cadre d’un **projet scolaire**. Elle est conçue pour gérer les réservations et les commandes dans un restaurant. Le site permet de consulter les tables, gérer les réservations, passer des commandes (plats et boissons), et suivre en temps réel l'état des tables.

/!\ le code n'est pas complet car j'utilise un api de google que je ne peux pas mettre en depot sur github.
---

## Fonctionnalités principales

* 🔎 **Affichage des tables** avec leur statut (Disponible, Réservée, Occupée, etc.)
* 📅 **Gestion des réservations** (ajout, modification, suppression) via une interface modale
* 🥗 **Gestion des commandes** : ajout de plats et de boissons à un ticket
* 🧾 **Affichage des commandes** associées à une table ou à un ticket en cours
* 🔄 **Mise à jour dynamique du statut des tables**
* 🔄 **Coter Admin**
* 🧩 Architecture **orientée objet** (PHP) avec une séparation claire des responsabilités

---

## Structure du projet

```
/SiteWeb_Restaurant
│
├── /api               # Fichiers PHP servant d'API (get_tables.php, get_reservations.php, etc.)
├── /classes           # Classes PHP : Database, Plats, Tables, Reservation, etc.
├── /modals            # Fichiers HTML/PHP pour les modales (réservation, commande)
├── /assets            # Images, CSS, JS
├── index.php          # Page d'accueil avec affichage des tables
├── config.php         # Configuration de la base de données
└── README.md          # Ce fichier
```

---

## Base de données

* Base MySQL avec plusieurs tables :

  * `tables` : informations sur les tables (id, nom, statut…)
  * `reservations` : détails des réservations (nom client, date, heure…)
  * `plats`, `boissons`, `type_plats` : gestion du menu
  * `commandes`, `ticket` : gestion des commandes et facturation

---

## Technologies utilisées

* 🐘 PHP (orienté objet)
* 🐬 MySQL
* 🧠 AJAX (requêtes API sans rechargement)
* 💅 HTML/CSS/JavaScript pour l’interface utilisateur

---

## Instructions d'installation

1. Clone le dépôt :

   ```bash
   git clone https://github.com/ton-utilisateur/SiteWeb_Restaurant.git
   ```

2. Configure la base de données dans `config.php`

3. Importe le fichier `.sql` de ta base dans phpMyAdmin ou MySQL

4. Lance le serveur local :

   ```bash
   php -S localhost:8000
   ```

