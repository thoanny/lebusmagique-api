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

```bash
  symfony server:start
```

## Traductions

Pour générer les fichiers de traductions :

`php bin/console translation:extract --force fr --format=json`

## Commandes

### genshin:map-markers-update

Mettre à jour les positions X et Y des marqueurs d'une carte de Genshin Impact.

# Docker

## Déployer avec docker en environement de développement

Afin de pouvoir déployer la stack il faudra dans un premier temps renseigner votre configuration dans les fichiers suivants:

- .env
- .env.test
- docker-compose.yml

Il faudra ensuite se placer en ligne de commande dans le dossier contenant le fichier **docker-compose.yml**.

On pourra par la suite build les images docker.

```bash
$ docker-compose --env-file .env build
```

Et enfin démarrer la stack. (La première fois la stack peut mettre un peu de temps à démarrer le temps de que la commande **npm install** installe les dépendances)

```bash
$ docker-compose --env-file .env up -d
```

### Afficher les conteneurs démarrés

```bash
$ docker ps
```

### Se connecter dans un conteneur en mode interractif

```bash
$ docker exec -it <nom-du-conteneur> /bin/bash
```

### Consulter les logs d'un conteneur

Il est possible de consulter les logs d'un conteneur en fonctionnement.

```bash
$ docker logs <nom-du-conteneur>
```

### Eteindre la stack

```bash
$ docker-compose down
```

## Premier démarrage

Au premier démarrage du conteneur il est nécessaire d'installer les dépendances Composer et NPM. Pour cela il faut se connecter au conteneur **lbm-app** et executer la commande suivante:

Soit en mode interractif:

```bash
$ docker exec -it lbm-app /bin/bash
$ make install
```

ou non interractif:

```bash
$ docker exec lbm-app make install
```

Une fois la stack démarrée et les dépendances Symfony résolus, l'application est disponible à l'adresse http://localhost:8080.

## Node dev server

Le container **lbm-node** permet de rebuild et recopier les assets dès qu'une modification est détectée. Pour cela il est nécessaire de démarrer le serveur de dev:

Soit en mode interractif:

```bash
$ docker exec -it lbm-node /bin/bash
$ make node_watch
```
ou non interractif:

```bash
$ docker exec lbm-node make node_watch
```