# Grille d’audit de conformité au RGAA

La grille d’audit est basée sur [la grille officielle de la DINUM disponible sur le site officiel du RGAA](https://www.numerique.gouv.fr/publications/rgaa-accessibilite/kit/), document « placé sous [licence ouverte 2.0 ou ultérieure](https://www.etalab.gouv.fr/licence-ouverte-open-licence) » (voir les détails dans la grille).

## Points modifiés

Afin de faciliter notre travail d'audit, nous avons modifié les points suivants :

* Pour les onglets d’audit :
    * Ajout d’une colonne « Tests » (affichage de l’ensemble des tests RGAA pour chaque critère) ;
    * Ajout d’une colonne « Niveau » (A ou AA) ;
    * Ajout d’une colonne « Comment tester (outils) » ;
    * Renommage de la colonne « Modification à apporter » en « [Impact] Problèmes relevés (préconisations de correction dans un fichier séparé) » ;
    * Ajout des filtres de colonnes ;
    * En-tête de colonnes : utilisation des en-têtes de colonne de l’onglet « Critères (modèle) » comme référence ;
* Onglet « Échantillon » : ajout d’une colonne « Commentaire » ;
* Renommage de l’onglet « Critères » en « Critères (modèle) » ;
* Passage de tous les textes en police Liberation Sans et en taille 10pt minimum au lieu de 8pt ;
* Rétablissement des bordures de cellules (qui avaient disparues par endroit) ;
* Tri/ménage dans les styles du document ;
* Modification des couleurs de thème mais aussi des statuts (note : le statut NA avait un ratio de contraste insuffisant).

## Points restants à modifier

Certains points restent à modifier :

* Ajout d’un moyen de signalement des [exemptions](https://www.numerique.gouv.fr/publications/rgaa-accessibilite/obligations/#contenus-exempt%C3%A9s) (différentes des [dérogations](https://www.numerique.gouv.fr/publications/rgaa-accessibilite/obligations/#d%C3%A9rogation-pour-charge-disproportionn%C3%A9e)). Idée : ajouter une colonne « Exemption » et une autre « Commentaire exemption » car on déroge ou exempte un contenu donc il faut pouvoir avoir les 2 à la fois (on peut avoir un contenu exempté, un contenu dérogé, un contenu ni exempté ni dérogé pour un même critère)

## Ajouts au mode d’emploi

- **Liste des problèmes relevés :** Pour chaque page et pour chaque règle, il faut indiquer, s’il y en a, la liste des problèmes relevés.
    - Chaque problème peut avoir un impact différent sur les utilisateurs et utilisatrices. Ainsi, il convient d’indiquer, entre crochets et avant d’expliquer chaque problème, l’impact estimé ([voir la documentation dédiée dans le README.md principal de ce dépôt GitHub](/../../#impact)).
    - Indiquer ensuite le problème relevé mais sans faire la préconisation de correction. Un tableur n’est pas approprié pour y faire figurer autant d’informations. Il vaut mieux mettre les préconisations dans un document texte séparé ([voir la documentation dédiée dans le README.md principal de ce dépôt GitHub](/../../#doc-preco)).
- **Si la règle est non applicable pour raison d’exemption ou dérogation**, il est préférable d’indiquer les problèmes concernés dans la colonne listant les problèmes relevés en précisant quel problème concerne du contenu exempté ou dérogé (par exemple, en indiquant `[Exempté]` ou `[Dérogé]` en amont).
