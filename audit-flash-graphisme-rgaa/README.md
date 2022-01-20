# Grille d’audit flash graphisme (*checklist*) basé sur le RGAA

Autrice de l’outil : [Copsaé](https://www.copsae.fr/)

Cette grille a été réalisée avec LibreOffice Calc. Nous ne garantissons pas son fonctionnement avec Microsoft Excel.

## Qu’est-ce qu’un audit flash graphisme ?

Un audit flash graphisme est un audit rapide des maquettes graphiques. Il s’appuie sur 52 critères du RGAA 4.1 (sur [106 en tout](https://www.numerique.gouv.fr/publications/rgaa-accessibilite/methode-rgaa/criteres/)). Ces critères concernent, selon nous, directement ou indirectement les maquettes graphiques.

Les critères ont été nécessairement reformulés en des règles qui concernent le graphisme.

Certains critères RGAA ont été « exclus » de la liste car il nous semblait qu’ils concernaient plus la conception au sens large (rédaction des spécifications fonctionnelles…) et non uniquement le graphisme. Ainsi, la grille n’est pas exhaustive et il est possible de passer à côté de certains défauts d’accessibilité.

⚠️ Cet audit ne permet pas d’établir une déclaration d’accessibilité prouvant l’engagement dans une démarche d’accessibilité, ni d’établir un taux de conformité au RGAA.

L’objectif est de s’assurer de la bonne prise en compte des règles d’accessibilité dès le début du projet, avant le développement du site web.

## Comment le choix des critères du RGAA a-t-il été établi ?

Au départ, l’audit flash graphisme était un audit à la volée en fonction de ses propres connaissances des règles d’accessibilité. Cela nous a paru finalement trop aléatoire, pas assez cadré, pas assez facilement à la portée de personnes plus juniors dans les audits d’accessibilité.

Nous avons donc analysé les critères du RGAA au regard des implications qu’ils pouvaient avoir sur la conception au sens large (graphique et fonctionnelle) avant de réduire cette liste aux implications liées au graphisme uniquement.

Ensuite, nous avons réécrit les règles de façon à ce qu’elles soient spécifiquement dédiées au graphisme. Certains critères du RGAA ont été regroupés entre eux, d’autres découpés plus finement en plusieurs règles.

## Comment fonctionne cet outil ?

- **10 pages :** La grille a été prévue pour 10 pages mais vous pouvez en ajouter autant que vous voulez ou en supprimer. Pour cela, il faudra modifier les onglets « Échantillon » et « Calculs ». Il faudra également soit supprimer les onglets « PXX » en trop ou en ajouter en dupliquant le dernier. Nous conseillons d’utiliser la page 1 pour analyser les éléments transverses à toutes les pages (en-tête, pied de page, etc.) afin d’éviter de les analyser dans chaque page.
- **Calculs :** L’audit flash graphisme ne concerne que le graphisme et ne peut donc pas se substituer à un audit de conformité. Ainsi, afin de ne pas semer le trouble avec des résultats trompeurs, nous avons fait le choix de ne pas faire de statistiques mais de relever uniquement le nombre de règles qui ont au moins un problème relevé pour chaque page. Cet outil ne doit pas permettre de fournir un taux qui serait alors utilisé à tort dans une déclaration d’accessibilité.
- **Les règles :** 
    - Nous ne parlons pas ici de critères mais de règles pour ne pas les confondre avec les critères officiels du RGAA.
    - Chaque règle a un numéro, un intitulé, l’information de la (ou des) thématique(s) RGAA associées, la liste des critères RGAA ciblés.
- **Le statut pour chaque règle :** S’agissant d’une grille d’audit simplifié, il ne faut pas donner un statut identique au RGAA « Conforme »/« Non conforme ». Nous avons donc choisi de parler de « Problème détecté » ou non. Les valeurs possibles sont donc :
    - « **Problème(s) détecté(s)** » : Au moins un problème est relevé dans la page pour la règle en question ;
    - « **Problème non détecté** » : Aucun problème n’a été détecté dans la page pour la règle en question (ce qui n’est pas un engagement ferme dans la mesure où cela dépendra des développements futurs) ;
    - « **NA** » (« Non applicable ») : Soit aucun élément dans la page ne concerne la règle, soit le seul contenu qui concerne la règle est exempté ([cf. RGAA sur les contenus exemptés pour les sites dans le périmètre de la loi](https://www.numerique.gouv.fr/publications/rgaa-accessibilite/obligations/#contenus-exempt%C3%A9s)), soit le seul contenu qui concerne la règle est soumis à dérogation et il propose une alternative numérique accessible ([cf. RGAA sur la dérogation pour charge disproportionnée pour les sites dans le périmètre de la loi](https://www.numerique.gouv.fr/publications/rgaa-accessibilite/obligations/#d%C3%A9rogation-pour-charge-disproportionn%C3%A9e)).
    - « **NT** » (« Non testé ») : La règle n’a pas encore été testée. Cela sert uniquement à mesurer la progression de l’audit.
- **Liste des problèmes relevés :** Pour chaque page et pour chaque règle, il faut indiquer, s’il y en a, la liste des problèmes relevés.
    - Chaque problème peut avoir un impact différent sur les utilisateurs et utilisatrices. Ainsi, il convient d’indiquer, entre crochets et avant d’expliquer chaque problème, l’impact estimé ([voir la documentation dédiée dans le README.md principal de ce dépôt GitHub](/../../#impact)).
    - Indiquer ensuite le problème relevé mais sans faire la préconisation de correction. Un tableur n’est pas approprié pour y faire figurer autant d’informations. Il vaut mieux mettre les préconisations dans un document texte séparé ([voir la documentation dédiée dans le README.md principal de ce dépôt GitHub](/../../#doc-preco)).
- **Si la règle est non applicable pour raison d’exemption ou dérogation**, il est préférable d’indiquer les problèmes concernés dans la colonne listant les problèmes relevés en précisant quel problème concerne du contenu exempté ou dérogé (par exemple, en indiquant `[Exempté]` ou `[Dérogé]` en amont).
