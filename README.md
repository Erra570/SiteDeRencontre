# Site de Rencontre : Meestic

Ce projet intègre toutes les fonctionnalités demandées au projet Site de Rencontre. (Bonus non-inclus)
Cela comprend l'inscription d'un utilisateur, sa connexion, son abonnement ainsi qu'une messagerie, un outil de recherche, ainsi qu'une partie de gestion administrateur.
Chaque page comprend l'intégralité des fonctionnalités qui lui sont demandées dans la consigne : Signalement d'un message, Suppression d'un message ou d'un profil, Modification d'un profil, etc.
Toutes les données sont conservées dans la base de données mySQL

## Pré-requis
Avoir un serveur apache et php fonctionnel

## Installation
Pour installer le projet, simplement sortir le dossier de l'archive, puis lancer en tant qu'admin la base de données inscrite dans le fichier "bdd.sql".

### Installation de la bdd
lancer mysql dans la console (avec : sudo mysql) puis entrer :
mysql> SOURCE /home/cytech/cheminvers/SiteDeRencontre/sql/BDD.sql

## Démarrage
Ouvrir une page index.php, puis se connecter ou créer un compte

## Informations supplémentaires
Deux utilisateurs sont déjà présents dans la base de données afin de rendre certains tests plus faciles :

Utilisateur Admin :
 - Nom de compte : Admin
 - Mot de Passe : azertyuiop

Utilisateur classique, inscrit, abonné, ayant déjà accepté l'Admin comme contact :
 - Nom de compte : Legolas64
 - Mot de Passe : leffff

## Version
**Version stable :** 1.0
**Lien GitHub du projet :** https://github.com/Erra570/SiteDeRencontre

## Auteurs
 - **Florent Crahay--Boudou** (https://github.com/Sifflet-Blanc)
 - **Rubens Tueux** (https://github.com/RubensGHub)
 - **Finana Tom** (https://github.com/Erra570)
