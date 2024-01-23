# La Moulinette — Liste des modifications

## Version 2.3 — 23 janvier 2024

- **Correction [issue #35](https://github.com/copsae/outils-audits-accessibilite/issues/35) :** Les sauts de ligne dans les recommandations n’étaient pas conservés ;
- Ajout des principes de fonctionnement sur la page web.

## Version 2.2 — 21 décembre 2023

Adaptation de la charte graphique du site de la Moulinette à la nouvelle charte de Copsaé.

## Version 2.1 — 7 décembre 2023

**Correction [issue #33](https://github.com/copsae/outils-audits-accessibilite/issues/33) :** Sur certains relevés d’audits (rencontré sur une feuille créée sur Excel Mac), une case sans commentaire n’était pas toujours considérée comme une case vide mais comme non-existante ; ce qui générait une erreur lors de la génération de la grille avec la liste des anomalies.

Un test a été ajouté pour vérifier que la case existe avant d’en vérifier la valeur.

## Version 2.0 — 19 octobre 2023

- Prise en compte de la colonne « Commentaires de l’audit de contrôle » pour automatiser la liste d’anomalies suite à un audit de contrôle ;
- Ajout du numéro de version de la Moulinette en pied de page.

## Version 1.0 — 29 juin 2023

Ajout de [la Moulinette](https://github.com/copsae/outils-audits-accessibilite/tree/main/audit-conformite-rgaa/moulinette), automatiseur de liste d’anomalies pour l’audit de conformité au RGAA.
