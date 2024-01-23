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
		<meta name="description" content="Cet outil récupère la liste de toutes les anomalies relevées dans une grille d’audit RGAA dans une seule feuille du tableur avec une ligne par anomalie.">
		<link rel="stylesheet" type="text/css" href="./web/css/font-face.css" />
		<link rel="stylesheet" type="text/css" href="https://www.copsae.fr/wp-content/themes/starter-theme-copsae-child/dist/css/style.css" />
		<link rel="stylesheet" type="text/css" href="./web/css/styles.css" />

		<!-- Favicon -->
		<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
		<link rel="manifest" href="/site.webmanifest">
		<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#02435f">
		<meta name="apple-mobile-web-app-title" content="La Moulinette">
		<meta name="application-name" content="La Moulinette">
		<meta name="msapplication-TileColor" content="#fff3cc">
		<meta name="theme-color" content="#ffffff">
	</head>
	<body>
		<header role="banner" class="site-header">
			<div class="container">
				<div class="site-branding">
					<h1 class="moulinette-title-description">
						<span class="site-logo">
							<img width="163" height="118" src="https://www.copsae.fr/wp-content/uploads/copsae-logo.svg" class="copsae-logo" alt="Copsaé">
							<img src="https://www.copsae.fr/wp-content/uploads/icon-moulinette.svg" alt="" width="120" height="120">
						</span>
						<span class="site-description"><b>La Moulinette</b>, automatiseur de liste d’anomalies pour l’audit de conformité au RGAA</span>
					</h1>
				</div>
			</div>
		</header>
		<main role="main">
			<section class="section-bg-secondary">
				<div class="container">
					<div class="small-container">
						<p>Cet outil permet de récupérer la liste de toutes les anomalies relevées dans une grille d’audit de conformité dans une seule feuille du tableur avec une ligne par anomalie.</p>

						<p>Ainsi, les anomalies peuvent être comptées facilement et sont filtrables par impact. Cela permet de faciliter la priorisation des corrections et, éventuellement, l’export dans un outil de gestion des tickets.</p>
					</div><!-- .small-container -->
				</div><!-- .container -->
			</section>

			<div class="container">
				<div class="small-container">

					<h2>Instructions préalables</h2>
					<ol>
						<li>La Moulinette ne fonctionne qu’avec <a href="https://github.com/copsae/outils-audits-accessibilite/tree/main/audit-conformite-rgaa">la grille d’audit de conformité au RGAA créée par Copsaé, au format XLSX</a> (compatible avec LibreOffice, OnlyOffice et, normalement, Microsoft Excel) ;</li>
						<li>Pour que la liste des anomalies soit correctement réalisée, certaines règles de syntaxe doivent être respectées (sauts de ligne, notation de l’impact, notation du statut corrigé ou non lors de l’audit de contrôle…). Elles sont expliquées dans le mode d’emploi de la grille d’audit (dans l’onglet « Mode d’emploi » du tableur et également <a href="https://github.com/copsae/outils-audits-accessibilite/blob/main/audit-conformite-rgaa/README.md#ajouts-au-mode-demploi">dans le fichier README.md</a>).</li>
					</ol>
					
					<h2>Principes de fonctionnement</h2>
					<ul>
						<li><strong>La Moulinette modifie uniquement l’onglet « Liste anomalies » du tableur</strong> en y agrégeant les données des onglets d’audit des pages « PXX » ;</li>
						<li><strong>Modifier l’onglet « Liste anomalies » après le passage à la Moulinette n’a pas d’incidence sur les autres onglets</strong> ni sur les calculs de la grille ;</li>
						<li>Si la grille a déjà été passée à la Moulinette, un deuxième passage effacera le contenu de l’onglet « Liste anomalies » avant de le regénérer ;</li>
						<li>Les fichiers envoyés dans le champ de formulaire ne sont pas enregistrés sur notre serveur.</li>
					</ul>

					<h2>Passer la grille dans la Moulinette</h2>

					<?php if ($error !== NULL) :?>
						<div class="error" role="alert" id="error_message">
							<p>L'erreur suivante s’est produite :</p>
							<p><?php echo $error->getMessage();?></p>
						</div>
					<?php endif; // ($error !== NULL) :?>

					<form method="POST" enctype="multipart/form-data">
						<div class="form-field-group">
							<label for="spreadsheet" id="form-label-file" class="form-label form-label-file">
								<span class="form-label-text">Choisissez le fichier de grille d’audit à modifier (format .xlsx)</span>
								<span class="form-label-file-btn">Parcourir…</span>
							</label>
							<input type="file" accept=".xlsx" name="spreadsheet" id="spreadsheet" class="form-field-file screen-reader-text" aria-labelledby="form-label-file form-file-information" />

							<!-- role="alert" pour assurer la lecture par les lecteurs d’écran quand un fichier est sélectionné -->
							<p class="form-file-information" id="form-file-information" role="alert">Aucun fichier sélectionné.</p>
						</div><!-- .field-file-wrapper -->

						<input type="hidden" name="action" value="process" />
						<input type="text" id="piege_a_mouche" name="piege_a_mouche" style="display:none;" />

						<p><input type="submit" value="Envoyer et lancer la Moulinette" aria-describedby="info-procedure" class="btn-default" /></p>
						<p id="info-procedure" class="highlight">Le passage dans la Moulinette devrait durer quelques dizaines de secondes. Vous pouvez voir l’état de l’onglet de navigateur en cours de chargement pendant ce temps. Le fichier finalisé se téléchargera automatiquement sur votre ordinateur.</p>
					</form>

				</div><!-- .small-container -->
			</div><!-- .container -->
		</main>

		<footer role="contentinfo" class="site-footer" data-bg="dark">
			<div class="container">
				<div class="small-container">
					<p><a href="https://github.com/copsae/outils-audits-accessibilite/tree/main/audit-conformite-rgaa/moulinette" class="page-link-item">La Moulinette est <i lang="en">open-source</i></a>. <a href="https://github.com/copsae/outils-audits-accessibilite/blob/main/audit-conformite-rgaa/moulinette/changelog.md" class="page-link-item">Version actuelle : 2.3</a></p>
					<p>Un site réalisé par <a href="https://www.copsae.fr">Copsaé</a>.</p>
					<p>Ce site ne récolte aucune statistique et n’utilise pas de <i lang="en">cookies</i>. <a href="https://www.copsae.fr/mentions-legales/">Mentions légales</a></p>
				</div><!-- .small-container -->
			</div><!-- .container -->
		</footer>

		<script src="https://www.copsae.fr/wp-content/themes/starter-theme-copsae/src/js/vanilla-detect-safari.js"></script>
		<script src="./web/js/jquery-3.7.1.min.js"></script>
		<script src="./web/js/jquery-input-file-a11y.js"></script>
	</body>
</html>
