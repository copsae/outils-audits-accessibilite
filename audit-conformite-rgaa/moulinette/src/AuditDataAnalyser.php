<?php

namespace Copsae;

use \ErrorException;
use \PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use PhpOffice\PhpSpreadsheet\RichText\Run;
use \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * @class
 * Analyse des données d'audit pour traitement des commentaires.
 */
class AuditDataAnalyser {

  // Les messages d'erreur.
  const ERORR_NO_FILE_CODE = 10;
  const ERORR_NO_FILE_MESSAGE = "Aucun fichier n'a été transmis. Vous devez envoyer un fichier au format XLSX pour qu'il puisse être analysé et traité.";

  const ERORR_UNKNOWN_SOURCE = 20;
  const ERORR_UNKNOWN_SOURCE_MESSAGE = "Le fichier transmis ne semble pas être une grille d'audit maintenue par Copsaé.";

  // L'adresse du repo pour validation des fichiers excel.
  const DATA_SOURCE_URL = 'https://github.com/copsae/outils-audits-accessibilite';

  // Le nom du champ de formulaire pour récupérer le fichier envoyé.
  const FORM_FIELD_NAME = 'spreadsheet';

  // Le titre de la feuille utilisée pour recenser les anomalies.
  const ANOMALY_SHEET_NAME = 'Liste anomalies';

  /**
   * La feuille d'audit chargée en mémoire.
   *
   * @var \PhpOffice\PhpSpreadsheet\Spreadsheet
   */
  protected $spreadsheet;

  /**
   * Accesseur de la feuille d'audit.
   *
   * @return \PhpOffice\PhpSpreadsheet\Spreadsheet
   *   La feuille d'audit.
   */
  public function getComputedSpreadsheet() {
    return $this->spreadsheet;
  }

  /**
   * Vérification des prérequis.
   *
   * - Présence d'un fichier ?
   * - Feuille d'audit copsaé ?
   *
   * @return bool
   *   Si aucun fichier n'est à traiter, retourne FALSE.
   *   Si les tests ont été effectués avec succès, retourne TRUE.
   *   Si une erreur est rencontrée durant les tests, émet une exception.
   */
  public function checkRequirements() {
    // Pas de files, pas de question.
    if (empty($_FILES)) {
      return FALSE;
    }

    // Récupération du fichier via le formulaire.
    $input_file = $_FILES[self::FORM_FIELD_NAME] ?? NULL;
    if (!$input_file || empty($input_file['name'])) {
      throw new ErrorException(self::ERORR_NO_FILE_MESSAGE, self::ERORR_NO_FILE_CODE);
    }

    // Chargement de la feuille d'audit en mémoire.
    $spreadsheet = IOFactory::load($input_file['tmp_name']);

    // Récupération de la source de l'outil afin de vérifier
    // qu'il s'agit bien d'une feuille copsaé.
    $source = $spreadsheet->getSheet(0)->getCell('B3')->getCalculatedValue() ?? '';
    if (strripos($source, self::DATA_SOURCE_URL) === FALSE) {
      throw new ErrorException(self::ERORR_UNKNOWN_SOURCE_MESSAGE, self::ERORR_UNKNOWN_SOURCE);
    }

    $this->spreadsheet = $spreadsheet;

    return TRUE;

  }

  /**
   * Collecte et centralisation des commentaires.
   */
  public function processAnomalyList() {
    $anomaly_sheet = $this->prepareanomalySheet();
    if (NULL == $anomaly_sheet) {
      throw new ErrorException(self::ERORR_UNKNOWN_SOURCE_MESSAGE, self::ERORR_UNKNOWN_SOURCE);
    }

    $this->collectAnomalyList($anomaly_sheet);
    $this->applyStyles($anomaly_sheet);
  }

  /**
   * Mise en forme de la liste anomalies.
   *
   * @param Worksheet $anomaly_sheet
   *   La feuille de synthèse des commentaires.
   */
  protected function applyStyles(Worksheet $anomaly_sheet) {

    $page_index = $this->spreadsheet->getIndex($anomaly_sheet);
    $highest_row = $anomaly_sheet->getHighestRow();

    // Récupération de la première page de relevé (P01).
    $p01 = $this->spreadsheet->getSheet($page_index + 1);

    // Style par défaut pour les commentaires.
    // On s'assure que les commentaires ne seront pas en bold par défaut.
    // Pour les recommandations
    $style_array_reco = $p01->getStyle('I4')->exportArray();
    $style_array_reco['font']['bold'] = FALSE;

    // Pour les commentaires de l'audit de contrôle
    $style_array_control = $p01->getStyle('K4')->exportArray();
    $style_array_control['font']['bold'] = FALSE;

    $anomaly_sheet->duplicateStyle($p01->getStyle('D4'), 'A4:C' . $highest_row);
    $anomaly_sheet->duplicateStyle($p01->getStyle('B4'), 'D4:E' . $highest_row);
    $anomaly_sheet->duplicateStyle($p01->getStyle('D4'), 'F4:F' . $highest_row);
    $anomaly_sheet->duplicateStyle($p01->getStyle('G4'), 'G4:G' . $highest_row);
    $anomaly_sheet->duplicateConditionalStyle($p01->getConditionalStyles('G4'), 'G4:G' . $highest_row);
    $anomaly_sheet->duplicateStyle($p01->getStyle('G4'), 'H4:H' . $highest_row);
    $anomaly_sheet->getStyle('I4:I' . $highest_row)->applyFromArray($style_array_reco, FALSE);
    $anomaly_sheet->getStyle('K4:K' . $highest_row)->applyFromArray($style_array_control, FALSE);

  }

  /**
   * Parcours des pages auditées et synthèse.
   *
   * @param \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $anomaly_sheet
   *   La feuille de synthèse des commentaires.
   */
  protected function collectAnomalyList(Worksheet $anomaly_sheet) {
    $sheet_index = $this->spreadsheet->getIndex($anomaly_sheet);
    $sheet_length = $this->spreadsheet->getSheetCount();

    $current_anomaly_row = $anomaly_sheet->getHighestDataRow();

    $anomalies = [];
    // On parcourt toutes les pages de relevé (P01, P02...).
    while (++$sheet_index < $sheet_length) {
      $current_sheet = $this->spreadsheet->getSheet($sheet_index);
      $sheet_title = $current_sheet->getTitle();
      $sheet_heading = $current_sheet->getCell('A2')->getValue();

      $cells = $current_sheet->getCellCollection();
      $max_row = $current_sheet->getHighestRow();
      // On commence à la ligne 3 pour éviter les entêtes.
      $row = 3;
      $theme = NULL;
      while (++$row < $max_row) {

        // Thématique.
        $value = $cells->get('A' . $row)->getValue();
        if ($value != NULL && $value != $theme) {
          $theme = $value;
        }

        // Récupération des commentaires.
        if (NULL == $value = $cells->get('I' . $row)->getValue()) {
          continue;
        }

        // Séparation des commentaires le cas échéant.
        $comments = $this->extractComments($value);

        // Récupération des autres données correspondant aux commentaires.
        $criterion = $current_sheet->getCell('B' . $row)->getValue();
        $level = $current_sheet->getCell('C' . $row)->getValue();
        $recommendation = $current_sheet->getCell('D' . $row)->getValue();
        $status = $current_sheet->getCell('G' . $row)->getValue();
        $control = $current_sheet->getCell('K' . $row)->getValue();

        // Ajout des commentaires traités à la liste.
        foreach ($comments as $comment) {
          $current_anomaly_row++;
          $anomaly_sheet->getCell('A' . $current_anomaly_row)->setValue($sheet_title);
          $anomaly_sheet->getCell('B' . $current_anomaly_row)->setValue($sheet_heading);
          $anomaly_sheet->getCell('C' . $current_anomaly_row)->setValue($theme);
          $anomaly_sheet->getCell('D' . $current_anomaly_row)->setValue($criterion);
          $anomaly_sheet->getCell('E' . $current_anomaly_row)->setValue($level);
          $anomaly_sheet->getCell('F' . $current_anomaly_row)->setValue($recommendation);
          $anomaly_sheet->getCell('G' . $current_anomaly_row)->setValue($status);
          $anomaly_sheet->getCell('J' . $current_anomaly_row)->setValue($control);

          // Extraction du niveau de criticité.
          $matches = [];
          if (preg_match('/\[(bloquant|majeur|mineur)\]/i', $comment, $matches)) {
            $anomaly_sheet->getCell('H' . $current_anomaly_row)->setValue($matches[1]);
          }

          $anomaly_sheet->getCell('I' . $current_anomaly_row)->setValue($comment);
        }

      }
    }

    // Écriture des données dans la feuille.
    $anomaly_sheet->fromArray($anomalies, NULL, 'A4');
  }

  /**
   * Extraction du ou des commentaires à partir du commentaire d'origine.
   *
   * Exemple de commentaires multiples que l'on peut rencontrer.
   * Chacun de ces commentaires peut être composé de portions de texte riche.
   *
   * 1. [Bloquant] Partage – La popin de partage par mail a deux pièges ...
   *
   * 2. [Bloquant] En-tête – Menu de navigation desktop – Lorsqu’un sous-menu...
   * -----
   * (Voir transverses en P01)
   *
   * 1. [Mineur] Dans la section « Dans l’actualité », le lien « Toutes les ...
   *
   * 2. [Majeur] Les liens qui s’ouvrent dans une nouvelle fenêtre et/ou sont...
   * -----
   * (Voir transverses en P01)
   *
   * [Mineur] Dans les accordéons, les liens violets sur fond violet clair ...
   *
   * @param string|RichText $value
   *   La valeur textuelle de la cellule d'origine.
   *
   * @return array
   *   Un tableau contenant le ou les commentaires normalisés.
   */
  protected function extractComments($value) {

    if ($value instanceof RichText) {

      $org_elements = $this->normalizeRichTextElements($value->getRichTextElements());

      $return = [];
      $elements = [];

      /** @var Run $element */
      foreach ($org_elements as $element) {

        $elements[] = $element;

        // Si l'élément se termine par un double saut de ligne.
        if (str_ends_with($element->getText(), "\n\n")) {
          $return[] = $this->createNewRichTextFromElements($elements);
          $elements = [];
        }
      }

      // Création du dernier commentaire avec les éléments restant.
      if (count($elements)) {
        $return[] = $this->createNewRichTextFromElements($elements);
      }

      return $return;
    }

    // Si nous avons une chaîne de caractère.
    if (FALSE != $comments = preg_split("/\r\n\r\n|\n\n|\r\r/", $value)) {
      $return = [];
      foreach ($comments as $str) {
        $rt = new RichText();
        $rt->createText($str);
        $return[] = $rt;
      }
      return $return;
    }

    // Enfin, on tente la conversion en string.
    return [(string) $value];

  }

  /**
   * Normalisation des commentaires.
   *
   * Une même cellule peut comporter plusieurs commentaires. Ces commentaires
   * sont séparés par des doubles sauts de ligne. On fait en sorte que les
   * doubles sauts de ligne se trouvent en fin de portion de texte.
   * En effet, il est possible d'inclure un saut de ligne dans un changement
   * de style. Le saut de ligne sera alors le premier caractère de la portion
   * de texte, empêchant la détection d'un double saut de ligne dans la
   * précédente portion de texte.
   *
   * @param array $org_elements
   *   Les portions de texte composant les commentaires d'origine.
   *
   * @return array
   *   Les portions de texte normalisées.
   */
  protected function normalizeRichTextElements(array $org_elements) {
    $line_breaks = ["\n", "\r"];
    $elements = [];

    foreach ($org_elements as $element) {

      $txt = $element->getText();

      // Si un texte commence par un ou des sauts de ligne, on les transfère à l'élément précédent.
      while (in_array(substr($txt, 0, 1), $line_breaks)) {
        $txt = substr($txt, 1);
        if (0 < $l = count($elements)) {
          /** @var Run $prev_run */
          $prev_run = $elements[$l - 1];
          $prev_run->setText($prev_run->getText() . "\n");
        }
      }

      // Si dans un élément il y a un ou plusieurs double sauts de ligne, on doit créer plusieurs éléments.
      if (FALSE != $sub_texts = preg_split("/\r\n\r\n|\n\n|\r\r/", $txt)) {
        foreach ($sub_texts as $sub_text) {
          // Lorsque l'on a plusieurs commentaires dans un même bloc de texte.
          if (count($sub_texts) > 1) {
            // Si on arrive sur un élément vide, c'est qu'on est sur une fin de commentaire.
            // On ajoute alors un double saut de ligne au commentaire précédent.
            if (trim($sub_text) == '' && 0 < $l = count($elements)) {
              /** @var Run $prev_run */
              $prev_run = $elements[$l - 1];
              $prev_run->setText($prev_run->getText() . "\n\n");
              continue;
            }
          }
          // Si on a du texte, on crée autant d'éléments du même type qu'on a de commentaires.
          $run = new Run($sub_text);
          $run->setFont($element->getFont());
          $elements[] = $run;
        }
      }

    }

    // Suppression des sauts de ligne en trop.
    foreach ($elements as &$run) {
      if (str_ends_with($run->getText(), "\n\n")) {
        $run->setText(trim($run->getText()) . "\n\n");
      }
    }

    return $elements;
  }

  /**
   * Création d'un commentaire en texte riche à partir des différents éléments.
   *
   * @param array $elements
   *   Les éléments de texte riche qui compose le commentaire.
   *
   * @return RichText
   *   Le commentaire.
   */
  protected function createNewRichTextFromElements(array $elements) {
    $rt = new RichText();
    $rt->setRichTextElements($elements);
    return $rt;
  }

  /**
   * Suppression des données existantes.
   *
   * @param \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet
   *   La feuille de synthèse des commentaires.
   */
  protected function emptyAnomalyList(Worksheet $sheet) {
    // On passe les entêtes.
    $start_row = 4;
    $last_row = $sheet->getHighestRow();
    $sheet->removeRow($start_row, $last_row - $start_row + 1);
  }

  /**
   * Vérification de la présence de la feuille de synthèse et préparation.
   *
   * @return \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet
   *   La feuille utilisée pour synthétiser les commentaires.
   */
  protected function prepareanomalySheet() {
    // On recherche par le titre de la feuille.
    if (NULL != $sheet = $this->spreadsheet->getSheetByName(self::ANOMALY_SHEET_NAME)) {

      // Hauteur par défaut des cellules.
      $sheet->getDefaultRowDimension()->setRowHeight(80);

      // Suppression des données présentes dans cette feuille.
      $this->emptyAnomalyList($sheet);

      return $sheet;
    }
  }

}
