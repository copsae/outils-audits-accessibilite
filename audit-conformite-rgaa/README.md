# Grille d’audit de conformité au RGAA

La grille d’audit est basée sur [la grille officielle de la DINUM disponible sur le site officiel du RGAA](https://accessibilite.numerique.gouv.fr/ressources/kit-audit/), document « placé sous [licence ouverte 2.0 ou ultérieure](https://www.etalab.gouv.fr/licence-ouverte-open-licence) » (voir les détails dans la grille).

## Points modifiés

Afin de faciliter notre travail d'audit, nous avons modifié les points suivants :

- Ajout d’une partie « Notes complémentaires ajoutées par Copsaé » dans l’onglet « Mode_d'emploi » ;
- Pour les onglets d’audit :
    - Ajout d’une colonne « Tests » (affichage de l’ensemble des tests RGAA pour chaque critère) ;
    - Ajout d’une colonne « Niveau » (A ou AA) ;
    - Ajout d’une colonne « Comment tester (outils) » ;
    - Renommage de la colonne « Modification à apporter » en « [Impact] Problèmes relevés et recommandation » ;
    - Ajout des filtres de colonnes ;
    - En-tête de colonnes : utilisation des en-têtes de colonne de l’onglet « Critères (modèle) » comme référence ;
    - Correction des formules en A2 pour les P10 à P20 qui ne référençaient pas la bonne ligne de l’échantillon.
- Dans l’onglet « Échantillon » :
    - Ajout d’une colonne « Commentaire » ;
    - Dans l’en-tête explicitant les conditions de l’audit, ajout de la ligne « Couples lecteur d’écran + navigateur utilisés : ».
- Renommage de l’onglet « Critères » en « Critères (modèle) » ;
- Passage de tous les textes en police Liberation Sans et en taille 10pt minimum au lieu de 8pt ;
- Rétablissement des bordures de cellules (qui avaient disparues par endroit) ;
- Tri/ménage dans les styles du document ;
- Modification des couleurs de thème mais aussi des statuts (note : le statut NA avait un ratio de contraste insuffisant) ;
- Audit des éléments transverses (voir la section « Ajouts au mode d’emploi » pour plus d’informations) :
    - Dans l’onglet « Échantillon », décalage des lignes pour faire apparaître « Éléments transverses » en P01 ;
    - Dans l’onglet « Synthèse », suppression des cellules B17 et B18 pour le calcul du taux moyen.
- Corrections pour l’ajout d’onglets (pages à auditer) :
    - Correction des formules : ajout du signe `$` devant les noms d’onglets dans les formules afin qu’une duplication d’onglet n’entraîne pas une incrémentation dans les formules ;
    - Ajout de la documentation dans l’onglet « Mode d’emploi » pour savoir exactement comment ajouter une page.
- Dans l’onglet « Synthèse » :
    - Utilisation de la formule `ARRONDI()` pour arrondir le taux de conformité à 2 chiffres après la virgule ;
    - Ajout d’une section « Synthèse finale à l’échelle de l’échantillon » mettant en valeur le taux de conformité au RGAA final et ajoutant un tableau récapitulatif du nombre de critères conformes, non conformes, non applicables à l’échelle de l’échantillon ;
- Dans l’onglet « BaseDeCalcul » :
    - Ajout d’un intitulé à la colonne AB « Statut à l’échelle de l’échantillon » ;
    - Ajout d’un filtre pour cette colonne pour voir rapidement et lister les critères NC à l’échelle de l’échantillon (pour rédiger le rapport d’audit et pour les personnes qui vont corriger) ;
    - Ajout du formatage conditionnel pour les statuts de critères.

## Points restants à modifier

Certains points restent à modifier :

- Ajout d’un moyen de signalement des [exemptions](https://accessibilite.numerique.gouv.fr/obligations/champ-application/#contenus-exemptes) (différentes des [dérogations](https://accessibilite.numerique.gouv.fr/obligations/champ-application/#derogation-pour-charge-disproportionnee)). Idée : ajouter une colonne « Exemption » et une autre « Commentaire exemption » car on déroge ou exempte un contenu donc il faut pouvoir avoir les 2 à la fois (on peut avoir un contenu exempté, un contenu dérogé, un contenu ni exempté ni dérogé pour un même critère)

## Ajouts au mode d’emploi

- **Liste des problèmes relevés :** Pour chaque page et pour chaque règle, il faut indiquer, s’il y en a, la liste des problèmes relevés.
    - Chaque problème peut avoir un impact différent pour les personnes handicapées. Ainsi, il convient d’indiquer, entre crochets et avant d’expliquer chaque problème, l’impact estimé ([voir la documentation dédiée dans le README.md principal de ce dépôt GitHub](/../../#impact)).
    - Indiquer ensuite le problème relevé en faisant une préconisation de correction technique sommaire. Un tableur n’étant pas approprié pour y faire figurer des préconisations longues, pour certaines non-conformités complexes, il peut ne pas être possible de mettre la préconisation détaillée précisément dans la grille. Cela pourra figurer dans le rapport d’audit ou bien nécessiter un accompagnement dédié : le préciser dans la grille quand c’est le cas.

        Si on le peut, mais cela demande plus de temps, il peut être mieux mettre les préconisations dans un document texte séparé ([voir la documentation dédiée dans le README.md principal de ce dépôt GitHub](/../../#doc-preco)).
- **Si la règle est non applicable pour raison d’exemption ou dérogation**, il est préférable d’indiquer les problèmes concernés dans la colonne listant les problèmes relevés en précisant quel problème concerne du contenu exempté ou dérogé (par exemple, en indiquant `[Exempté]` ou `[Dérogé]` en amont).
- **Auditer les éléments transverses :** Nous utilisons l’onglet « P01 » pour auditer les éléments transverses au site (en-tête, pied de page, fil d’Ariane…). Les éléments concernés doivent être listés dans la colonne « Commentaire » de l’onglet « Échantillon ». Cela nous permet d’éviter d’auditer plusieurs fois les mêmes éléments.

    Il y a ensuite plusieurs possibilités dans la méthode de travail : soit les statuts des critères sont ensuite propagés manuellement aux autres pages avant de les auditer (en indiquant « Voir transverses P01 » dans la colonne listant les problèmes relevés), soit **on ne propage pas ces statuts transverses et cela signifie que le taux moyen ne peut être calculé puisque le score par page sera faussé**.
    Pour des raisons de facilité, de temps et parce que le taux moyen nous semble être un score beaucoup trop biaisé (voir cet article à ce sujet : [RGAA : quelle différence entre taux de conformité global sur l’échantillon et taux moyen ?](https://access42.net/rgaa-taux-conformite-global-moyen-echantillon)), nous avons fait le choix de ne pas propager les statuts des éléments transverses aux autres pages et avons décidé de retirer de la grille la formule de calcul du taux moyen (qui serait alors encore plus biaisée).
- **Auditer plus de 20 pages : ajouter une page à auditer** requiert quelques manipulations :

    1. Pour **ajouter une 21e page**, cliquer droit sur l’onglet P20 et faire « Déplacer/copier la feuille ». Sélectionner l’action « Copier ». Dans la liste déroulante « Insérer avant », choisir « - placer en dernière position - » tout en bas de la liste. Choisir le nouveau nom « P21 ». Cliquer « OK ».
    2. Se rendre sur **l’onglet « Échantillon »**. Dupliquer la dernière ligne du tableau pour faire figurer la page 21 avec son titre et son URL.
    3. Se rendre sur **l’onglet « P21 »** nouvellement créé. Modifier la formule de la cellule A2 pour incrémenter les valeurs B28 et C28 qui deviendront B29 et C29.
    4. Se rendre dans **l’onglet « BaseDeCalcul »**. Il y a 2 tableaux de calculs dans lesquels nous allons devoir ajouter la page 21.
    5. **Premier tableau, pour ajouter P21 :** se rendre à la colonne de la page P20 (normalement, colonne W) et ajouter une colonne après pour mettre la P21. Ensuite, sélectionner les cellules 1 à 125 de la colonne W. Appuyer sur la touche MAJ du clavier et tirer les cellules sélectionnées vers la colonne X avec la souris (via le petit carré en bas de la dernière cellule sélectionnée). Sélectionner maintenant les cellules 3 à 125 de la colonne X et faire CTRL + H (Rechercher/Remplacer). Rechercher « P20 » et remplacer par « P21 » en veillant ce que la case « Sélection active seulement » soit cochée.
    6. **Premier tableau, pour corriger les calculs :** dans les colonnes de calculs des statuts (normalement Y, Z, AA, AB), il faut maintenant ajouter la prise en compte de la page 21. Sélectionner les cellules de Y3 à AB120. Et rechercher « W » (la colonne de la P20) pour le remplacer par « X » (la colonne de la P21) dans la sélection active.
    7. **Deuxième tableau :** faire de même que pour le premier tableau pour l’ajout de la colonne « P21 » et la modification du calcul du compte des dérogations (colonne « Total D »), en adaptant bien sûr les numéros de colonnes.
    8. Vérifier en modifiant les statuts de certains critères dans l’onglet « P21 » qu’ils sont bien pris en compte dans l’onglet « Synthèse » qui récupère automatiquement les résultats de la base de calcul.
