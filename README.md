# Outils pour les audits d’accessibilité

Ce dépôt contient les outils que nous utilisons chez Copsaé et que nous avons modifiés pour nos besoins dans la réalisation d’audits d’accessibilité.

Vous pouvez vous les approprier à votre tour selon [la licence établie](LICENSE.txt).

Vous trouverez plus de détails dans le « README.md » de chaque dossier :

* [Grille d’audit de conformité au RGAA](/audit-conformite-rgaa/) ;
* [Grille d’audit flash (*checklist*) basé sur le RGAA](/audit-flash-rgaa/).

## Liste d’outils d’aide pour les audits

Nom de l’outil | Type d’outil | Information 
 --- | --- | --- 
Assistant RGAA | Extension de navigateur | [Extension Firefox](https://addons.mozilla.org/fr/firefox/addon/assistant-rgaa/)
Axe | Extension de navigateur | [Extension Firefox](https://addons.mozilla.org/fr/firefox/addon/axe-devtools/)
Clavier | Périphérique | -
Color Contrast Analyser | Logiciel | [Télécharger chez l’éditeur](https://www.tpgi.com/color-contrast-checker/)
Feuille de style pour tester l’espacement des caractères | Code | [Extrait de code sur Gist](https://gist.github.com/juliemoynat/c6e0baf08b6e56845f9bac29e31104ab)
Firefox | Logiciel | [Télécharger chez l’éditeur](https://www.mozilla.org/fr/firefox/new/)
HeadingsMap | Extension de navigateur | [Extension Firefox](https://addons.mozilla.org/fr/firefox/addon/headingsmap/)
Inspecteur navigateur | Outil navigateur natif | <kbd>F12</kbd> dans le navigateur
Lecteurs d’écran | Logiciel | NVDA, JAWS, VoiceOver, Talkback
PDF Accessibility Checker | Logiciel | [Télécharger chez l’éditeur](https://pdfua.foundation/en/pdf-accessibility-checker-pac)
Souris | Périphérique | -
Stylus | Extension de navigateur | [Extension Firefox](https://addons.mozilla.org/fr/firefox/addon/styl-us/)
The Contrast Triangle | Application web | [Voir l’application web](https://contrast-triangle.com/)
Vue adaptative du navigateur | Outil navigateur natif | <kbd>CTRL</kbd> + <kbd>Maj</kbd> + <kbd>M</kbd> sur Firefox
WCAG Contrast checker | Extension de navigateur | [Extension Firefox](https://addons.mozilla.org/fr/firefox/addon/wcag-contrast-checker/)
Web Developer toolbar | Extension de navigateur | [Extension Firefox](https://addons.mozilla.org/fr/firefox/addon/web-developer/)
Zoom navigateur | Outil navigateur natif | <kbd>CTRL</kbd> + <kbd>+</kbd> (6 fois pour 200%)

## Fournir un document de préconisations, en plus de la grille d’audit

Nous déconseillons de mettre les préconisations de correction pour les anomalies d’accessibilité dans la grille d’audit (quelque soit l’audit). En effet, la nature et la longueur des textes rédigés ne sont pas appropriées pour des cases de tableur : ce ne sera pas lisible, la mise en forme est difficilement possible, etc.

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

Dans le cadre d’un audit de conformité, la DINUM propose un [modèle de rapport d’audit](https://www.numerique.gouv.fr/publications/rgaa-accessibilite/kit/) qui peut servir comme structure de base du document. Libre à nous, ensuite, de rédiger les préconisations de la façon qui nous semble la plus appropriée.
