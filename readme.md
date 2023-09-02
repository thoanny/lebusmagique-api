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

``php bin/console translation:extract --force fr --format=json``

## Commandes

### genshin:map-markers-update

Mettre à jour les positions X et Y des marqueurs d'une carte de Genshin Impact.