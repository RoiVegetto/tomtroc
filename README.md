# TomTroc

Application PHP MVC pour l'echange de livres entre utilisateurs.

## Prerequis

- XAMPP (Apache + MySQL/MariaDB)
- PHP 8.1+

## Installation (XAMPP)

1. Placer le projet dans `C:\xampp\htdocs\tomtroc`.
2. Demarrer Apache et MySQL depuis le panneau XAMPP.
3. Ouvrir phpMyAdmin: `http://localhost/phpmyadmin/`.
4. Creer la base de donnees `tomtroc`.
5. Importer le schema SQL si un fichier est fourni, ou creer les tables necessaires.
   - Tables attendues: `users`, `books`, `conversations`, `messages`.
6. Configurer la connexion BDD dans [app/core/Database.php](app/core/Database.php).
   - Par defaut: host `127.0.0.1`, port `3307`, base `tomtroc`, user `root`, mot de passe vide.
7. Verifier que l'URL pointe vers le dossier `public`.
   - Exemple: `http://localhost/tomtroc/public/`
8. Verifier la configuration Apache pour la reecriture d'URL.
   - `mod_rewrite` active et `AllowOverride All` sur le dossier `public`.

## Lancer le projet

- Ouvrir `http://localhost/tomtroc/public/`.

## Notes

- Les fichiers uploades sont stockes dans [public/uploads](public/uploads).
- Si les images ne s'affichent pas, verifier les droits d'ecriture sur `public/uploads` et ses sous-dossiers.
