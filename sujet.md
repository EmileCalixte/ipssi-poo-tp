# PHP Orienté Objet - IPSSI Juin 2019 - TP Noté

Le code doit être versionné sous Git et pushé sur Github, Bitbucket ou Gitlab, avec les droits de
lecture pour kevinjhappy.

## Scenario

Vous devez developper un système de gestion de communauté organisant des meetings.

- Un meeting commence à une date donnée (fixe et inchangeable)
- Un meeting fini à une date donnée (fixe et inchangeable)
- Un meeting a un titre et une description

- Un utilisateur peut s'inscrire à un ou plusieurs meetings
- Un utilisateur peut être organisateur d'un meeting (en quel cas il doit être dans la liste des organisateurs et ne peut être dans la liste des participants)
- Un utilisateur peut créer un meeting et ajouter des participants et des organisateurs
- Un organisateur d'un meeting peut supprimer le meeting

## Installation

Pour simplifier le démarrage du projet, vous pouvez utiliser l'archive disponible sur Slack, vous avez un fichier docker-compose que vous pouez utiliser pour instancier votre projet et intéragir avec la base de données.
Des exemple d'import SQL sont disponible dans fixture, mais ne correspondent pas au projet.

## Notation

Les notes dépendront du nombre de fonctionnalités réalisés, pondérées par difficultés (la réalisation de
toutes les fonctions avec un style de code minimal rapportera moins de points que la réalisation de moins
de fonctionnalités mais avec un meilleur aspect d'un point de vue du génie logiciel).

Sera regardé :
- le typage fort
- les namespaces et l'autoload (avec composer, en PSR-4)
- la longueur des classes et des méthodes
- le découpage en classes à responsabilité limité, et la composition d'objets (injection de dépendance) en utilisant des interfaces lorsque c'est nécéssaire

Mots clés importants : 
dependency injection , factory , psr-2 , php-cs-fixer , final ,
declare(strict_types=1) , scalar type hint , return type , composition ,
inheritance , __construct , __invoke , Entity , Repository , PDO .

## Requis 

Le minimum requis est d'avoir un système permettant l'affichage des valeurs depuis la base de donnée. 

La base de donnée est rempli directement soit en ligne de commande soit en utilisant une interface comme Adminer ou tout autre logiciel jugé adapté.

Les classes utilisées doivent être fonctionnelles et le site doit s'afficher correctement.

Les namespaces sont implémenté avec logique.

Les validations dans les entités ainsi que les types des attributs sont correct, si un choix technique est fait
et ne semble pas évident, une note peut être ajouté dans le README.md pour expliquer le choix lors de
la correction.

Les liens entre les objets sont précautionneusement choisis (composition, héritage, etc.).

L'utilisation de classes appropriées ( Repository , Exception , Entity , Factory ) est requis pour montrer la comprehension de la responsabilité de chacun.

Utilisation d'exceptions pour les cas non standard.

Il n'est pas demandé de faire une interface graphique complexe lorsque l'on accède à la page d'acceuil du site, cependant lorsque vous executerez des actions les une après les autres comme lors du cours avec index.php, il est necessaire de décrire l'action faite et d'afficher le résultat proprement. Cependant contrairement au cours, il est demandé d'isoler les actions faites dans des controllers pour permettre de bien tester les liens entre Controller, Modeles et Vues 

## Bonus

Utiliser des design pattern comme la Factory dans les cas jugé necessaire

Extra points pour du code défensif et pour le formattage PSR-2 complet.

Points pour l'utilisation de UUID v4 à la place des id auto incrémentaux (voir ramsey/uuid pour pplus ).

Utiliser un polymorphisme pour afficher une liste comportant tous les participants et tous les organiseurs
d'un groupe en une seule fois.

## Traductions des mots clé pour le projet

Communauté : Community
Titre : Title
Date de début : Start date
Date de fin : End date
Meeting : Meeting
Inchangeable : Immutable
Utilisateur : User
Participant : Attendee
Organisateur : Organiser (UK) / Organizer (US)
Supprimer : Delete