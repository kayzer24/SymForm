## Tutoriel génération d'une version static d'un Site Symfony
Ce tutoriel est basé sur le backend crée a partir de NO-CODE notion. 
https://www.notion.so/

Documentation Officiel: https://developers.notion.com/
#### Dependence Composer:
```bash
 composer require symplify/symfony-static-dumper
```

### Documentation
voila la documentation pour la configuration du bundle
https://github.com/symplify/symfony-static-dumper

### Command de génération du site static
```bash
symfony console dump-static-site  
```

#### Remarque
il est imperatif de modifier les chemins vers les assets (mettre chemins entier au lieu de liens relatifs)

ps: affin de publier le site sur github pages, il faut crée les variables d'environnemements necessaires dans les ``` settings > secret ```