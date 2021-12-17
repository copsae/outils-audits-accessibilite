# Document de préconisations pour un audit flash basé sur le RGAA

Il est déconseillé de mettre les préconisations de correction pour les anomalies d’accessibilité dans la grille d’audit. En effet, cela ferait des volumes de texte trop importants dans des cases de tableur et ce n’est pas approprié : ce ne sera pas lisible, la mise en forme est difficilement possible, etc.

Nous conseillons donc de mettre les préconisations dans un (ou plusieurs) document séparé (ou bien dans l’outil de gestion des tickets du projet).

Voici quelques points qui nous semblent importants :

- Qu’on fasse un seul ou plusieurs documents, ils sont toujours organisés avec des titres.
- La hiérarchie du contenu doit forcément permettre de copier/coller ensuite le contenu pour en faire des tickets. On doit retrouver :
    - Titre du ticket (= titre de l’anomalie)
    - Description de l’anomalie/du problème
        - Éventuellement : capture(s) d’écran ou code concerné (non corrigé)
    - Impact utilisateur/utilisatrice estimé (bloquant, majeur, mineur)
    - Page ou liste des pages concernées
    - Critère(s) RGAA invalidé(s)
    - Préconisation de correction
        - Éventuellement : exemple de code corrigé
- Certaines anomalies peuvent porter sur plusieurs critères RGAA invalidés à la fois si cela se justifie en termes de taille du ticket (éviter si le ticket devient trop gros), de métiers concernés (design, développement, contribution…)…
    - Exemple 1 : un bouton qui a un défaut de contraste (design) + un défaut de nom (développement) = 2 tickets séparés
    - Exemple 2 : un bouton qui n’a pas la bonne sémantique (développement) + un défaut de nom (développement) = un seul ticket
- Éviter les trop gros tickets : voir si ça ne peut pas être découpé en plusieurs plus petits. Un ticket trop gros sera généralement partiellement corrigé car il sera difficile à suivre.
