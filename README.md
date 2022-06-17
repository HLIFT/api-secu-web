# 🔓 API Sécurité Web

## 📄 Description

Cette api pour faire des todos est vulnérable, elle contient :

* Aucune vérification de qui accède aux todos. Tout utilisateur peut voir / modifier / supprimer les todos des autres utilisateurs
* Les mots de passes ne sont pas cryptés
* Des injections SQL
  * Sur le login si on rentre, par exemple, `xxxx OR 1=1` dans le champs `password` l'api nous retourne toutes les informations du premier utilisateur de la base de données
* Le CORS est défini sur `*`, tout le monde peut effectuer des requêtes sur l'api depuis n'importe quel domaine
  * Voir dans `config/cors.php` => `'allowed_origins' => ['*']`
* Il n'y a aucune supervision ou journalisation
* La protection CSRF est désactivée
  * Voir dans `app/Http/Middleware/VerifyCsrfToken.php` => `protected $except = [
    '*'
    ];`
  * La vérification est désactivée pour toutes les url

## ⚠️ Requirements

* `PHP >= 8.0`
* `Composer`
* `MYSQL >= 8.0`

## ⚙️ Installation

Il faut créer une base de données en local.

Il faut créer son environnement.

`cp .env.example .env`

Remplacer les informations de connexion à la bdd dans le fichier `.env` :
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=api_secu_web
DB_USERNAME=root
DB_PASSWORD=
```

Installer les dépendances :

`composer install`

Configuration de l'app :

Générer une clé de l'application : `php artisan key:generate`

Relier le dossier storage au dossier public : `php artisan storage:link`

Effectuer les migrations de la base de données : `php artisan migrate`

Lancer les seeders avec un jeu de données (deux utilisateurs et deux todos, les données sont visibles dans le fichier `database/seeders/DatabaseSeeder.php`) : `php artisan db:seed`

Lancer le projet : `php artisan serve`

Le projet est prêt vous pouvez maintenant utiliser l'api via Postman ou Insomnia ! 🎉
