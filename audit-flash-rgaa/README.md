# Grille d’audit flash (*checklist*) basé sur le RGAA

Autrice de l’outil : [Copsaé](https://www.copsae.fr/)

Cette grille a été réalisée avec LibreOffice Calc. Nous ne garantissons pas son fonctionnement avec Microsoft Excel.

## Qu’est-ce qu’un audit flash ?

Un audit flash est un audit rapide et non exhaustif : il permet, grâce à un balayage rapide, de débusquer les plus gros problèmes d’accessibilité. L’audit est basé sur 55 critères du RGAA 4.1 (sur [106 en tout](https://accessibilite.numerique.gouv.fr/methode/criteres-et-tests/)) qui nous semblent incontournables, avec des tests simplifiés. L’audit est donc plus rapide mais bien moins exhaustif. Des défauts d’accessibilité peuvent donc subsister.

⚠️ Cet audit ne permet pas d’établir une déclaration d’accessibilité prouvant l’engagement dans une démarche d’accessibilité, ni d’établir un taux de conformité au RGAA.

L’objectif est de réaliser un premier pas vers la mise en conformité d’un site web, notamment s’il comporte de nombreuses anomalies d’accessibilité.

## Comment le choix des critères du RGAA a-t-il été établi ?

Au départ, l’audit flash était un audit à la volée en fonction de ses propres connaissances des règles d’accessibilité. Cela nous a paru finalement trop aléatoire, pas assez cadré, pas assez facilement à la portée de personnes plus juniors dans les audits d’accessibilité.

Nous avons donc analysé les critères choisis de la [« Méthode de contrôle simplifié de l’accessibilité » du Gouvernement du Grand-Duché de Luxembourg](https://accessibilite.public.lu/fr/monitoring/controle-simplifie.html). Nous avons un peu modifié la liste car nous n’étions pas toujours d’accord avec tous les choix réalisés.

Ensuite, nous avons réécrit les règles de façon à ce qu’elles soient simplifiées dans leur écriture avec pour objectif de contrôler plus rapidement le site web à auditer. Certains critères du RGAA ont été regroupés entre eux.

## Comment fonctionne cet outil ?

- **10 pages :** La grille a été prévue pour 10 pages mais vous pouvez en ajouter autant que vous voulez ou en supprimer. Pour cela, voir la partie « Comment augmenter le nombre de pages dans la grille ? ». Nous conseillons d’utiliser la page 1 pour analyser les éléments transverses à toutes les pages (en-tête, pied de page, etc.) afin d’éviter de les analyser dans chaque page.
- **Calculs :** L’audit flash n’a pas pour objectif de se substituer à un audit de conformité. Il est moins exhaustif. Ainsi, afin de ne pas semer le trouble avec des résultats trompeurs, nous avons fait le choix de ne pas faire de statistiques mais de relever uniquement le nombre de règles qui ont au moins un problème relevé pour chaque page. Cet outil ne doit pas permettre de fournir un taux qui serait alors utilisé à tort dans une déclaration d’accessibilité.
- **Les règles :**
    - Nous ne parlons pas ici de critères mais de règles pour ne pas les confondre avec les critères officiels du RGAA.
    - Chaque règle a un numéro, un intitulé, l’information de la (ou des) thématique(s) RGAA associées, la liste des critères RGAA ciblés, une information sur la façon de tester la règle.
- **Le statut pour chaque règle :** S’agissant d’une grille d’audit simplifié, il ne faut pas donner un statut identique au RGAA « Conforme »/« Non conforme ». Nous avons donc choisi les statuts « Validé » ou « Invalidé ». Les valeurs possibles sont donc :
    - « **Invalidé** » : Au moins un problème est relevé dans la page pour la règle en question ;
    - « **Validé** » : Aucun problème n’a été détecté dans la page pour la règle en question (ce qui ne veut pas dire qu’il n’y en a pas pour les critères RGAA concernés mais que, via l’audit flash, l’auditeur ou l’auditrice n’en a pas détecté) ;
    - « **NA** » (« Non applicable ») : Soit aucun élément dans la page ne concerne la règle, soit le seul contenu qui concerne la règle est exempté ([cf. RGAA sur les contenus exemptés pour les sites dans le périmètre de la loi](https://accessibilite.numerique.gouv.fr/obligations/champ-application/#contenus-exemptes)), soit le seul contenu qui concerne la règle est soumis à dérogation et il propose une alternative numérique accessible ([cf. RGAA sur la dérogation pour charge disproportionnée pour les sites dans le périmètre de la loi](https://accessibilite.numerique.gouv.fr/obligations/champ-application/#derogation-pour-charge-disproportionnee)).
    - « **NT** » (« Non testé ») : La règle n’a pas encore été testée. Cela sert uniquement à mesurer la progression de l’audit.
- **Liste des problèmes relevés :** Pour chaque page et pour chaque règle, il faut indiquer, s’il y en a, la liste des problèmes relevés.
    - Chaque problème peut avoir un impact différent sur les utilisateurs et utilisatrices. Ainsi, il convient d’indiquer, entre crochets et avant d’expliquer chaque problème, l’impact estimé ([voir la documentation dédiée dans le README.md principal de ce dépôt GitHub](/../../#impact)).
    - Indiquer ensuite le problème relevé mais sans faire la préconisation de correction. Un tableur n’est pas approprié pour y faire figurer autant d’informations. Il vaut mieux mettre les préconisations dans un document texte séparé ([voir la documentation dédiée dans le README.md principal de ce dépôt GitHub](/../../#doc-preco)).
- **Si la règle est non applicable pour raison d’exemption ou dérogation**, il est préférable d’indiquer les problèmes concernés dans la colonne listant les problèmes relevés en précisant quel problème concerne du contenu exempté ou dérogé (par exemple, en indiquant `[Exempté]` ou `[Dérogé]` en amont).
- La grille d’audit flash fournit un cadre pour auditer rapidement la conformité d’un site web au RGAA. Cependant, rien n’empêche de relever, en plus d’autres problèmes qui seraient détectés en dehors de ce cadre. **10 lignes complémentaires, regroupées sous le libellé « Autres critères invalidés »**, se trouvent en fin de chaque page afin d’y ajouter d’autres non-conformités relevées. Dans ce cas, le critère invalidé devra être ajouté dans la colonne concernée. L’idée est de pouvoir ajouter des critères hors liste des critères de base seulement suite à une décision préalable à l’audit avec le ou la cliente (par exemple, les critères sur les scripts) ou si un problème bloquant est identifié et pas long à préconiser.

    Si besoin, vous pouvez ajouter d’autres lignes tout en veillant à modifier les formules de la colonne B « Nombre de règles avec au moins un problème détecté (Invalidé) » dans l’onglet « Calculs ».

## Comment augmenter le nombre de pages dans la grille ?

1. **Insérer une nouvelle ligne dans le tableau de l’onglet « Échantillon »** et renseigner, dans chaque case correspondante, le numéro de page, le titre de la page, l’URL et un commentaire si nécessaire ;
1. **Dupliquer le dernier onglet :** cliquer droit sur l’onglet correspondant à la dernière page. Aller dans le menu « Déplacer/copier la feuille ». Dans la fenêtre qui s’ouvre, sélectionner « Copier » comme action. Dans la partie « Insérer avant », sélectionner « - placer en dernière position - ». Indiquer « P11 » comme « Nouveau nom » (ou autre numéro correspondant).
1. En principe, l’onglet s’affiche à peu près correctement. Cependant, il faut **corriger la formule en A2:G2**. Normalement, vous avez `=CONCATENER($Échantillon.A18;" - ";$Échantillon.B18;" : ";$Échantillon.C18)` qui pointe vers la ligne pour la page 10 dans l'onglet appelé « Échantillon ». Remplacer A18, B18 et C18 par A19, B19 et C19 (à adapter selon la page, bien sûr).
1. **Dans l’onglet « Calculs », insérer une nouvelle ligne juste avant la ligne « Totaux pour toutes les pages ».** Sélectionner les cellules du tableau de la ligne au-dessus de la ligne nouvellement ajoutée. Appuyer sur la touche « Maj » du clavier et, en maintenant la touche appuyée, cliquer à la souris sur le coin en bas à droite de la cellule pour l’étendre sur les cellules situées en dessous. Cette technique permet de récupérer les formules des cellules précédentes en incrémentant de 1.
1. **Formules cassées pour les cellules des colonnes « Nombre de règles avec au moins un problème détecté (Invalidé) » et « Nombre de règles restant à évaluer (NT) » :** pour ces cellules l’incrémentation ne s’effectue pas de manière correcte. Il faut modifier la formule avec le nom de page correspondant (P11 au lieu de P10) et la plage d’échantillon à évaluer (en colonne B : F4 et F47 au lieu de F5 et F48 puis, en colonne C : F4 et F37 au lieu de F5 et F38).
