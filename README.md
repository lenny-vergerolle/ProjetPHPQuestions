## Groupe 23A :
Lenny VERGEROLLE 
Valentin HUN
# Projet PHP Questions

Ce script initialise une application de quiz en démarrant une session, en chargeant les dépendances requises et en configurant le rapport d'erreurs.

## Fonctionnalités

Il effectue les tâches suivantes :
- Démarre une session pour gérer les données utilisateur sur plusieurs pages.
- Inclut le fichier de données des questions.
- Inclut le fichier d'autoload pour le chargement automatique des classes.
- Configure PHP pour afficher les erreurs à des fins de débogage.
- Enregistre une fonction d'autoload pour charger automatiquement les classes.
- Connexion/ Déconnexion
- Nombre de réponses correct

## Utilisation

Le script utilise les classes et espaces de noms suivants :
- `Classes\QuestionRadio` : Représente une question à choix unique.
- `Classes\QuestionCheckBox` : Représente une question à choix multiples.
- `Classes\QuestionText` : Représente une question à réponse textuelle.
- `BD\MajBD` : Gère les opérations de base de données.

## Lancer l'application

```sh
sh start.sh
```
