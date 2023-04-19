# Grille d’audit de conformité au RGAA — Liste des modifications

Ce fichier liste les modifications dans les différentes versions de la grille d’audit.

## Version 3.0 — 19 avril 2023

Passage au RGAA 4.1.2 ([voir la note de révision officielle (note de révision des versions 4.1.1 et 4.1.2 fusionnée)](https://accessibilite.numerique.gouv.fr/ressources/notes-de-revision-4-1-2/)).

Aucune modification apportée en dehors du changement de numéro de version.

## Version 2.0 — 11 avril 2023

Passage au RGAA 4.1.1 ([voir la note de révision officielle (note de révision des versions 4.1.1 et 4.1.2 fusionnée)](https://accessibilite.numerique.gouv.fr/ressources/notes-de-revision-4-1-2/)). Modifications effectuées dans la grille :

- Test 5.8.1 : suppression de `<colgroup>` ;
- Critère 10.11 : reformulation du critère.

## Version 1.10 — 2 février 2023

- Pour chaque onglet d’audit (Pxx), ajout d’une colonne « Commentaire de l’audit de contrôle » ;
- Ajout de 10 onglets d’audit supplémentaires ;
- Modification du mode d’emploi en conséquence.

## Version 1.9 — 12 décembre 2022

Onglet « BaseDeCalcul » : en cellule C125, renommage de l’intitulé « TAUX PAR PAGE » en « Taux par onglet du tableur » (car il ne s’agit pas non plus d’un taux par page, les éléments transverses n’étant pas propagés).

## Version 1.8 — 8 décembre 2022

Onglet « P02 » : suppression d’un texte blanc dans la case de relevé des problèmes.

## Version 1.7 — 5 décembre 2022

- Onglet « BaseDeCalcul » :
    - Ajout d’un intitulé à la colonne AB « Statut à l’échelle de l’échantillon » ;
    - Ajout d’un filtre pour cette colonne pour voir rapidement et lister les critères NC à l’échelle de l’échantillon ;
    - Ajout du formatage conditionnel pour les statuts de critères ;
    - En cellule C125, renommage de l’intitulé « TAUX MOYEN » en « TAUX PAR PAGE » (car il ne s’agit pas d’un taux moyen).
- Onglet « Synthèse » : ajout d’une section « Synthèse finale à l’échelle de l’échantillon » mettant en valeur le taux de conformité au RGAA final et ajoutant un tableau récapitulatif du nombre de critères conformes, non conformes, non applicables à l’échelle de l’échantillon ;
- Retours arrière sur nos idées :
    - Onglet « Critères (modèle) », la colonne listant les non-conformités est renommée « [Impact] Problèmes relevés et recommandation » car la rédaction d’un document de préconisation à côté n’est pas une idée assez recherchée et opérationnelle pour le moment ;
    - Propagation des éléments transverses : modification de la documentation (onglet « Mode d’emploi » et le [readme.md](README.md)). Finalement, on refait le choix de ne plus propager les transverses car :
        - Ça demande du temps de le faire à la main ;
        - Ne propager que les statuts NC n’avait pas beaucoup plus de sens que de ne pas le faire ;
        - On souhaite utiliser l’onglet « BaseDeCalcul » comme aide pour voir où sont les critères NC (pour rédiger le rapport d’audit et pour les personnes qui vont corriger). Avoir les statuts des éléments transverses propagés rend un critère NC sur la totalité de l’échantillon et brouille donc la lisibilité et la praticité.
- Modification de liens pointant vers l’ancien site du RGAA.

## Version 1.6 — 24 novembre 2022

Dans l’onglet « Échantillon », dans l’en-tête explicitant les conditions de l’audit, ajout de la ligne « Couples lecteur d’écran + navigateur utilisés : ».

## Version 1.5 — 23 novembre 2022

Correction de la formule de calcul du taux de conformité qui faisait référence à une mauvaise colonne de l’onglet BaseDeCalcul.

## Version 1.4 — 28 juillet 2022

- Correction des formules en A2 pour les P10 à P20 qui ne référençaient pas la bonne ligne de l’échantillon ;
- Correction de la formule en A3 pour la P09 qui n’était pas bonne ;
- Dans l’onglet « Synthèse », utilisation de la formule `ARRONDI()` pour arrondir le taux de conformité à 2 chiffres après la virgule ;
- Modification du mode d’emploi sur notre choix quant à la propagation du statut des éléments transverses ;
- Critère 12.10 : ajout de précisions sur la façon de tester le critère.

## Version 1.3 — 30 juin 2022

- Correction des formules de références à d’autres onglets dans les pages (corrige l’incrémentation des références d’onglets lors de la duplication d’une page) ;
- Ajout de la documentation pour l’ajout d’une page à auditer.

## Version 1.2 — 24 février 2022

- Ajout d’une partie « Auditer les éléments transverses » dans le mode d’emploi ;
- Dans l’onglet « Échantillon », décalage des lignes pour faire apparaître « Éléments transverses » en P01 ;
- Dans l’onglet « Synthèse », suppression des cellules B17 et B18 pour le calcul du taux moyen ([voir le README.md pour plus d’infos](README.md)).

## Version 1.1 — 5 janvier 2022

Ajustement de la documentation
