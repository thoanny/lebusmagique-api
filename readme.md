![](https://img.shields.io/github/last-commit/thoanny/lebusmagique-api?style=for-the-badge)
![](https://img.shields.io/github/issues/thoanny/lebusmagique-api?style=for-the-badge)

# 🚍 Le Bus Magique (API)

API et back-office des outils du Bus Magique.

## Auteur

- [@thoanny](https://github.com/thoanny)

## Contribuer

Toute aide est bienvenue ! 

Si vous souhaitez partiper au développement de l'API du Bus Magique, contactez Thoanny. 

Si vous rencontrez des bugs, des erreurs ou si vous souhaitez partager des idées d'améliorations, de fonctionnalités, vous avez la possibilité d'[ouvrir un ticket](https://github.com/thoanny/lebusmagique-api/issues) (requiert un compte Github).
## Développement

### Démarrer la machine
```bash
  make up
```

### Premier lancement

#### Accèder à la console sur le serveur
```bash
make bash
```

#### Installer les librairires Composer (Docker)
```bash
composer install
```

#### Exécuter les migrations (Docker)
```bash
php bin/console doctrine:migrations:migrate
```

#### Importer les fixtures (Docker)
```bash
php bin/console doctrine:fixtures:load
```

#### Générer les clés JWT (Docker)
```bash
php bin/console lexik:jwt:generate-keypair
```

#### Installer les librairies NPM (local)
```bash
npm i
```

#### Générer les assets (local)
```bash
npm run dev
```

## Traductions

Pour générer les fichiers de traductions :

``php bin/console translation:extract --force fr --format=json``

## Commandes

### php bin/console lbm:events

Ajouter/mettre à jour les événements.

### php bin/console lbm:events --clean

Supprimer les événements startAt > 7 mois.