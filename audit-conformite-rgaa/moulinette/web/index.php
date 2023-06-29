<?php

require '../vendor/autoload.php';

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
    <title>Copsaé - automatisation de la synthèse des commentaires d'un audit d'accessibilité</title>
    <link rel="stylesheet" type="text/css" href="https://www.copsae.fr/dist/css/styles.css" />
    <link rel="stylesheet" type="text/css" href="css/styles.css" />
  </head>
  <body>
    <header role="banner" class="site-header">
      <div class="container">
        <div class="site-title">
          <p class="site-title-content">
            <a href="https://www.copsae.fr/" class="site-title-content-link">
              <img src="https://www.copsae.fr/assets/images/copsae-logo.svg" alt="Copsaé - Accueil" width="163" height="118" class="site-title-content-logo" />
            </a>

            <span class="site-title-content-description">Coopération pour des projets web avec du sens, de l’accessibilité et de l’éthique</span>
          </p>
        </div>
      </div>
    </header>
    <main role="main">
      <div class="container">
        <h1>Automatisation de la synthèse des commentaires d'un audit d'accessibilité</h1>
        <p>
          Cet outil permet d'automatiser des tâches liées aux <a href="https://github.com/copsae/outils-audits-accessibilite/tree/main/audit-conformite-rgaa">grilles d'audit de conformité RGAA</a>.
        </p>
<?php if ($error !== NULL) :?>
        <div class="error" aria-live="polite" id="error_message">
          <p>L'erreur suivante s'est produite :</p>
          <p><?php echo $error->getMessage();?></p>
        </div>
<?php endif; // ($error !== NULL) :?>
        <form method="POST" enctype="multipart/form-data">
          <div class="field">
            <label for="spreadsheet">
              <span class="title">Choisissez le fichier de grille d'audit à analyser (format .xlsx)</span>
              Ce champ est obligatoire. Il s'agit du fichier .xlsx que vous avez rempli, qui va être analysé et modifié automatiquement.
            </label>
            <input type="file" accept=".xlsx" name="spreadsheet" id="spreadsheet" />
          </div>
          <input type="hidden" name="action" value="process" />
          <input type="text" id="piege_a_mouche" name="piege_a_mouche" style="display:none;" />
          <input type="submit" value="Envoyer et lancer la procédure" />
        </form>
      </div>

    </main>
  </body>
</html>
