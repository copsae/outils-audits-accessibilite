<?php

require 'vendor/autoload.php';

use Copsae\AuditDataReader;
use Copsae\AuditDataAnalyser;
use Copsae\AuditDataWriter;
use Copsae\AuditFlashDataAnalyser;

$error = NULL;
$output_file = NULL;
try {
  $reader = new AuditDataReader();
  if ($reader->loadFile()) {
    $audit_type = $reader->getAuditType();
    if ($audit_type == AuditDataReader::AUDIT_TYPE_COMPLIANCE) {
      $analyser = new AuditDataAnalyser($reader->getSpreadsheet());
    }
    elseif ($audit_type == AuditDataReader::AUDIT_TYPE_FLASH) {
      $analyser = new AuditFlashDataAnalyser($reader->getSpreadsheet());
    }
    $analyser->processAnomalyList();
    $output_file = $analyser->getComputedSpreadsheet();
    $output_file_name = $reader->getAuditFileName();
    $output_format = AuditDataWriter::FORMAT_XLSX;
  }
}
catch (Exception $e) {
  $error = $e;
}

// Si un fichier a été traité, on le propose au téléchargement et on s'arrête là.
if ($output_file) {
  $writer = new AuditDataWriter($output_file);
  $writer->directBrowserOutput($output_file_name, $output_format);
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
          <li>Pour que la liste des anomalies soit correctement réalisée, certaines règles de syntaxe doivent être respectées (sauts de ligne, notation de l’impact, notation du statut corrigé ou non lors de l’audit de contrôle…). Elles sont expliquées dans le mode d’emploi de la grille d’audit (dans l’onglet « Mode d’emploi » du tableur et également <a href="https://github.com/copsae/outils-audits-accessibilite/blob/main/audit-conformite-rgaa/README.md#ajouts-au-mode-demploi">dans le fichier README.md</a>).</li>
        </ol>

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
        <p><a href="https://github.com/copsae/outils-audits-accessibilite/blob/main/audit-conformite-rgaa/moulinette/changelog.md" class="page-link-item">Version 2.0</a></p>
      </div>
    </footer>
  </body>
</html>
