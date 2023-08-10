<?php

require './vendor/autoload.php';

use Copsae\AuditDataAnalyser;
use Copsae\AuditDataWriter;

$error = NULL;
$output_file = NULL;
try {
  $analyser = new AuditDataAnalyser();
  if ($analyser->checkRequirements()) {
    $analyser->processAnomalyList();
    $output_file = $analyser->getComputedSpreadsheet();
  }
}
catch (Exception $e) {
  $error = $e;
}

// Si un fichier a été traité, on le propose au téléchargement et on s'arrête là.
if ($output_file) {
  $writer = new AuditDataWriter($output_file);
  $writer->directBrowserOutput();
  exit;
}

?>

<!DOCTYPE html>
<html lang="fr-FR">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Moulinette, automatiseur de liste d’anomalies pour l’audit de conformité au RGAA | Copsaé</title>
    <link rel="stylesheet" type="text/css" href="https://www.copsae.fr/dist/css/styles.css" />
    <link rel="stylesheet" type="text/css" href="./web/css/styles.css" />
  </head>
  <body>
    <header role="banner" class="site-header">
      <div class="container">
        <div class="site-title">
          <p class="site-title-content">
            <a href="https://www.copsae.fr/" class="site-title-content-link">
              <img src="https://www.copsae.fr/assets/images/copsae-logo.svg" alt="Copsaé - Accueil" width="163" height="118" class="site-title-content-logo" />
            </a>
          </p>
        </div>
      </div>
    </header>
    <main role="main">
      <div class="container">
        <h1>La Moulinette, automatiseur de liste d’anomalies pour l’audit de conformité au RGAA</h1>

        <p>Cet outil permet de récupérer la liste de toutes les anomalies relevées dans une grille d’audit de conformité dans une seule feuille du tableur avec une ligne par anomalie.</p>

        <p>Ainsi, les anomalies peuvent être comptées facilement et sont filtrables par impact. Cela permet de faciliter la priorisation des corrections et, éventuellement, l’export dans un outil de gestion des tickets.</p>

        <h2>Instructions préalables</h2>
        <ol>
          <li>La Moulinette ne fonctionne qu’avec <a href="https://github.com/copsae/outils-audits-accessibilite/tree/main/audit-conformite-rgaa">la grille d’audit de conformité au RGAA créée par Copsaé, au format XLSX</a> (compatible avec LibreOffice, OnlyOffice et, normalement, Microsoft Excel).</li>
          <li>Pour que chaque anomalie soit bien séparée chacune sur une ligne distincte dans l’onglet « Liste anomalies » du tableur, <strong>chaque anomalie pour un même critère doit être séparée par une ligne vide dans la cellule</strong>.</li>
          <li>Afin que la colonne « Impact » soit correctement renseignée pour chaque anomalie, <strong>chacune doit avoir son impact renseigné au préalable</strong>. L’impact doit être rédigé comme suit :
            <ul>
              <li><code>[Mineur] </code></li>
              <li><code>[Majeur] </code></li>
              <li><code>[Bloquant] </code></li>
            </ul>
          </li>
        </ol>

        <h3>Exemple de contenu dans une cellule pour le critère 3.3</h3>
        <blockquote>
          <p><strong>1. [Majeur] Bouton de partage</strong> - Le bouton de partage est une icône en vert clair sur fond gris clair avec un ratio de 1.6:1 au lieu de 3:1. Utiliser un vert plus foncé.
          <br /><br />
          <strong>2. [Mineur] Popin de partage par mail</strong> - La croix de fermeture est transparente et, apparaissant sur le fond blanc de la popin, elle a alors un ratio de 2,7:1 au lieu de 3:1. Retirer la transparence pour l’icône.
          <br /><br />
          <strong>3. [Majeur] Retour haut de page</strong> - L’icône du lien de retour en haut de page est une flèche blanche sur un carré vert clair dont le ratio de contraste est de 1,9:1 au lieu de 3:1. Foncer le carré ou la flèche.</p>
        </blockquote>
        <p>Ces 3 anomalies seront découpées par la Moulinette pour former 3 lignes dans l’onglet « Liste anomalies » du tableur.</p>


        <h2>Passer la grille dans la Moulinette</h2>
<?php if ($error !== NULL) :?>
        <div class="error" role="alert" id="error_message">
          <p>L'erreur suivante s'est produite :</p>
          <p><?php echo $error->getMessage();?></p>
        </div>
<?php endif; // ($error !== NULL) :?>

        <form method="POST" enctype="multipart/form-data">
          <div class="field">
            <label for="spreadsheet">
              <span class="title">Choisissez le fichier de grille d'audit à analyser (format .xlsx)</span>
              Il s'agit du fichier .xlsx que vous avez rempli, qui va être analysé et modifié automatiquement.
            </label>
            <input type="file" accept=".xlsx" name="spreadsheet" id="spreadsheet" />
          </div>
          <input type="hidden" name="action" value="process" />
          <input type="text" id="piege_a_mouche" name="piege_a_mouche" style="display:none;" />
          <input type="submit" value="Envoyer et lancer la Moulinette" aria-describedby="info-procedure" />
          <p id="info-procedure">Le passage dans la Moulinette devrait durer quelques dizaines de secondes. Vous pouvez voir l’état de l’onglet de navigateur en cours de chargement pendant ce temps. Le fichier finalisé se téléchargera automatiquement sur votre ordinateur.</p>
        </form>
      </div>

    </main>

    <footer role="contentinfo" class="site-footer" data-bg="dark">
      <div class="container">
        <p>À titre d’information, les fichiers que vous mettez dans le champ de formulaire ne sont pas enregistrés sur notre serveur et le site ne récolte aucune statistique ou autre.</p>
        <p><a href="https://github.com/copsae/outils-audits-accessibilite/tree/main/audit-conformite-rgaa/moulinette" class="page-link-item">La Moulinette est open-source.</a></p>
      </div>
    </footer>
  </body>
</html>
