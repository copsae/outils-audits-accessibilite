# Grille d’audit flash (checklist) basé sur le RGAA

Autrice de l’outil : [Copsaé](https://www.copsae.fr/)

Cette grille a été réalisée avec LibreOffice Calc. Nous ne garantissons pas son fonctionnement avec Microsoft Excel.

## Qu’est-ce qu’un audit flash ?

Un audit flash est un audit rapide et non exhaustif : il permet, grâce à un balayage rapide, de débusquer les plus gros problèmes d’accessibilité. L’audit est basé sur 55 critères du RGAA 4.1 (sur [106 en tout](https://www.numerique.gouv.fr/publications/rgaa-accessibilite/methode-rgaa/criteres/)) qui nous semblent incontournables, avec des tests simplifiés. L’audit est donc plus rapide mais bien moins exhaustif. Des défauts d’accessibilité peuvent donc subsister.

⚠️ Cet audit ne permet pas d’établir une déclaration d’accessibilité prouvant l’engagement dans une démarche d’accessibilité, ni d’établir un taux de conformité au RGAA.

L’objectif est de réaliser un premier pas vers la mise en conformité d’un site web, notamment s’il comporte de nombreuses anomalies d’accessibilité.

## Comment le choix des critères du RGAA a-t-il été établi ?

Au départ, l’audit flash était un audit à la volée en fonction de ses propres connaissances des règles d’accessibilité. Cela nous a paru finalement trop aléatoire, pas assez cadré, pas assez facilement à la portée de personnes plus juniors dans les audits d’accessibilité.

Nous avons donc analysé les critères choisis de la [« Méthode de contrôle simplifié de l’accessibilité » du Gouvernement du Grand-Duché de Luxembourg](https://accessibilite.public.lu/fr/monitoring/controle-simplifie.html). Nous avons un peu modifié la liste car nous n’étions pas toujours d’accord avec tous les choix réalisés.

Ensuite, nous avons réécrit les règles de façon à ce qu’elles soient simplifiées dans leur écriture avec pour objectif de contrôler plus rapidement le site web à auditer. Certains critères du RGAA ont été regroupés entre eux.

## Comment fonctionne cet outil ?

- **10 pages :** La grille a été prévue pour 10 pages mais vous pouvez en ajouter autant que vous voulez ou en supprimer. Pour cela, il faudra modifier les onglets « Échantillon » et « Calculs ». Il faudra également soit supprimer les onglets « PXX » en trop ou en ajouter en dupliquant le dernier. Nous conseillons d’utiliser la page 1 pour analyser les éléments transverses à toutes les pages (en-tête, pied de page, etc.) afin d’éviter de les analyser dans chaque page.
- **Calculs :** L’audit flash n’a pas pour objectif de se substituer à un audit de conformité. Il est moins exhaustif. Ainsi, afin de ne pas semer le trouble avec des résultats trompeurs, nous avons fait le choix de ne pas faire de statistiques mais de relever uniquement le nombre de règles qui ont au moins un problème relevé pour chaque page. Cet outil ne doit pas permettre de fournir un taux qui serait alors utilisé à tort dans une déclaration d’accessibilité.
- **Les règles :** 
    - Nous ne parlons pas ici de critères mais de règles pour ne pas les confondre avec les critères officiels du RGAA.
    - Chaque règle a un numéro, un intitulé, l’information de la (ou des) thématique(s) RGAA associées, la liste des critères RGAA ciblés, une information sur la façon de tester la règle.
- **Le statut pour chaque règle :** S’agissant d’une grille d’audit simplifié, il ne faut pas donner un statut identique au RGAA « Conforme »/« Non conforme ». Nous avons donc choisi de parler de « Problème détecté » et non de « Statut ». Les valeurs possibles sont donc :
    - « **Oui** » : Au moins un problème est relevé dans la page pour la règle en question ;
    - « **Non** » : Aucun problème n’a été détecté dans la page pour la règle en question (ce qui ne veut pas dire qu’il n’y en a pas pour les critères RGAA concernés mais que, via l’audit flash, l’auditeur ou l’auditrice n’en a pas détecté) ;
    - « **NA** » (« Non applicable ») : Soit aucun élément dans la page ne concerne la règle, soit le seul contenu qui concerne la règle est exempté ([cf. RGAA sur les contenus exemptés pour les sites dans le périmètre de la loi](https://www.numerique.gouv.fr/publications/rgaa-accessibilite/obligations/#contenus-exempt%C3%A9s)), soit le seul contenu qui concerne la règle est soumis à dérogation et il propose une alternative numérique accessible ([cf. RGAA sur la dérogation pour charge disproportionnée pour les sites dans le périmètre de la loi](https://www.numerique.gouv.fr/publications/rgaa-accessibilite/obligations/#d%C3%A9rogation-pour-charge-disproportionn%C3%A9e)).
    - « **NT** » (« Non testé ») : La règle n’a pas encore été testée. Cela sert uniquement à mesurer la progression de l’audit.
- **Liste des problèmes relevés :** Pour chaque page et pour chaque règle, il faut indiquer, s’il y en a, la liste des problèmes relevés.
    - Chaque problème peut avoir un impact différent sur les utilisateurs et utilisatrices. Ainsi, il convient d’indiquer, entre crochets et avant d’expliquer chaque problème, l’impact supposé :
        - **Bloquant** = impact bloquant : le problème empêche l’accès à une information ou un service pour au moins un « type de handicap » (exemple : un bouton n’est pas utilisable au clavier et il n’y a aucun moyen alternatif pour obtenir l’information cachée derrière ce bouton) ;
        - **Majeur** = impact fort : le problème est gênant pour accéder à une information ou un service pour au moins un « type de handicap » (exemple : visuellement, le contenu est hiérarchisé avec des titres mais ce sont tous des paragraphes dans le code) ;
        - **Mineur** = impact faible : le problème ne gêne pas l’accès à l’information (exemple : l’élement `<title>` ne contient pas le nom du site mais le nom du site est bien présent dans l’en-tête de celui-ci) ou le problème a un impact inexistant tant que le code reste en l’état mais présente un risque (exemple : un identifiant dupliqué lorsque cet identifiant n’est associé à aucun autre élément techniquement (champs de formulaire, ancre, `aria-labelledby`, `aria-describedby`…)).
    - Indiquer ensuite le problème relevé mais sans faire la préconisation de correction. Un tableur n’est pas approprié pour y faire figurer autant d’informations. Il vaut mieux mettre les préconisations dans un document texte séparé.
- **Si la règle est non applicable pour raison d’exemption ou dérogation**, il est préférable d’indiquer les problèmes concernés dans la colonne listant les problèmes relevés.
