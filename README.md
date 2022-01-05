# Outils pour les audits d’accessibilité

Ce dépôt contient les outils que nous utilisons chez Copsaé et que nous avons modifiés pour nos besoins dans la réalisation d’audits d’accessibilité.

Vous pouvez vous les approprier à votre tour selon [la licence établie](LICENSE.txt).

Vous trouverez plus de détails dans le « README.md » de chaque dossier :

* [Grille d’audit de conformité au RGAA](/audit-conformite-rgaa/) ;
* [Grille d’audit flash (*checklist*) basé sur le RGAA](/audit-flash-rgaa/).

## Sommaire de ce document

- [Liste d’outils d’aide pour les audits](#outils)
- [Fournir un document de préconisations, en plus de la grille d’audit](#doc-preco)
- [Estimer l’impact d’une anomalie d’accessibilité pour les utilisateurs et utilisatrices handicapées](#impact)

<a id="outils"></a>

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

<a id="doc-preco"></a>

## Fournir un document de préconisations, en plus de la grille d’audit

Nous déconseillons de mettre les préconisations de correction pour les anomalies d’accessibilité dans la grille d’audit (quelque soit l’audit). En effet, la nature et la longueur des textes rédigés ne sont pas appropriées pour des cases de tableur : ce ne sera pas lisible, la mise en forme est difficilement possible, etc.

Nous conseillons donc de **mettre les préconisations dans un (ou plusieurs) document séparé** (ou bien dans l’outil de gestion des tickets du projet).

Voici quelques points qui nous semblent importants :

- Qu’on fasse un seul ou plusieurs documents, ils sont toujours **organisés avec des titres**.
- La hiérarchie du contenu doit forcément **permettre de copier/coller ensuite le contenu pour en faire des tickets**. On doit retrouver :
    - Titre du ticket (= titre de l’anomalie)
    - Description de l’anomalie/du problème
        - Éventuellement : capture(s) d’écran ou code concerné (non corrigé)
    - Impact utilisateur/utilisatrice estimé (bloquant, majeur, mineur)
    - Page ou liste des pages concernées
    - Critère(s) RGAA invalidé(s)
    - Préconisation de correction
        - Éventuellement : exemple de code corrigé
- **Certaines anomalies peuvent porter sur plusieurs critères RGAA invalidés à la fois** si cela se justifie en termes de taille du ticket (attention : éviter si le ticket devient trop gros), de métiers concernés (design, développement, contribution…)…
    - Exemple 1 : un bouton qui a un défaut de contraste (design) + un défaut de nom (développement) = 2 tickets séparés
    - Exemple 2 : un bouton qui n’a pas la bonne sémantique (développement) + un défaut de nom (développement) = un seul ticket
- **Éviter les trop gros tickets** : voir si ça ne peut pas être découpé en plusieurs plus petits. Un ticket trop gros sera généralement partiellement corrigé car il sera difficile à suivre.

Dans le cadre d’un audit de conformité, la DINUM propose un [modèle de rapport d’audit](https://www.numerique.gouv.fr/publications/rgaa-accessibilite/kit/) qui peut servir comme structure de base du document. Libre à nous, ensuite, de rédiger les préconisations de la façon qui nous semble la plus appropriée.

<a id="impact"></a>

## Estimer l’impact d’une anomalie d’accessibilité pour les utilisateurs et utilisatrices handicapées

Estimer l’impact d’une anomalie d’accessibilité pour les utilisateurs et utilisatrices handicapées n’est pas forcément facile. Nous avons essayé de définir 3 niveaux d’impact comme suit :

- **Bloquant** = impact bloquant : le problème empêche l’accès à une information ou un service pour au moins un « type de handicap » (exemple : un bouton n’est pas utilisable au clavier et il n’y a aucun moyen alternatif pour obtenir l’information cachée derrière ce bouton) ;
- **Majeur** = impact fort : le problème est gênant pour accéder à une information ou un service pour au moins un « type de handicap » (exemple : visuellement, le contenu est hiérarchisé avec des titres mais ce sont tous des paragraphes dans le code) ;
- **Mineur** = impact faible : le problème ne gêne pas l’accès à l’information (exemple : l’élement `<title>` ne contient pas le nom du site mais le nom du site est bien présent dans l’en-tête de celui-ci) ou le problème a un impact inexistant tant que le code reste en l’état mais présente un risque (exemple : un identifiant dupliqué lorsque cet identifiant n’est associé à aucun autre élément techniquement (champs de formulaire, ancre, `aria-labelledby`, `aria-describedby`…)).

Ces définitions peuvent être amenées à changer avec le temps (selon leur pertinence évaluée à l’usage, selon des discussions avec d’autres personnes expertes, etc.). Ainsi, elles sont précisées dans le mode d’emploi de chaque grille d’audit pour ne pas fausser la lecture d’un audit réalisé avec une éventuelle version antérieure de ces règles.
