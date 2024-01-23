<?php

namespace Copsae;

use \Copsae\AuditDataReader;
use \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use \PhpOffice\PhpSpreadsheet\RichText\RichText;
use \PhpOffice\PhpSpreadsheet\RichText\Run;
use \PhpOffice\PhpSpreadsheet\Spreadsheet;

/**
 * Super classe pour l'extraction des commentaires des feuilles d'audit.
 */
class AbstractAuditDataAnalyser {

  /**
   * Le nombre de lignes d'entête dans la feuille de synthèse des anomalies.
   */
  const ANOMALY_SHEET_HEADER_ROWS_COUNT = 3;

  /**
   * Le fichier d'audit chargée en mémoire.
   *
   * @var \PhpOffice\PhpSpreadsheet\Spreadsheet
   */
  protected $spreadsheet;

  /**
   * La feuille où seront synthétisées les anomalies.
   *
   * @var \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet
   */
  protected $anomalySheet;

  /**
   * Constructeur.
   *
   * @param \PhpOffice\PhpSpreadsheet\Spreadsheet $spreadsheet
   *   La feuille d'audit.
   */
  public function __construct(Spreadsheet $spreadsheet) {
    $this->spreadsheet = $spreadsheet;
    $this->prepareAnomalySheet();
  }

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
   * Collecte et centralisation des commentaires.
   */
  public function processAnomalyList() {
    // Override me.
  }

  /**
   * Suppression des données existantes.
   *
   * @param \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet
   *   La feuille de synthèse des commentaires.
   */
  protected function emptyAnomalyList(Worksheet $sheet) {
    // On passe les entêtes.
    $start_row = self::ANOMALY_SHEET_HEADER_ROWS_COUNT + 1;
    $last_row = $sheet->getHighestRow();
    $sheet->removeRow($start_row, $last_row - $start_row + 1);
  }

  /**
   * Vérification de la présence de la feuille de synthèse et préparation.
   *
   * @return \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet
   *   La feuille utilisée pour synthétiser les commentaires.
   */
  protected function prepareAnomalySheet() {
    // On recherche par le titre de la feuille.
    if (NULL != $sheet = $this->spreadsheet->getSheetByName(AuditDataReader::ANOMALY_SHEET_NAME)) {

      // Hauteur par défaut des cellules.
      $sheet->getDefaultRowDimension()->setRowHeight(80);

      // Suppression des données présentes dans cette feuille.
      $this->emptyAnomalyList($sheet);

      $this->anomalySheet = $sheet;
    }
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

    if (empty($value)){
      return [];
    }

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
  protected function normalizeRichTextElements(array $elements) {
    $return = [];

    foreach ($elements as $n => $element) {
      $txt = $element->getText();

      // On unifie les sauts de lignes.
      $txt = str_replace("\r", "\n", $txt);

      // Si un texte commence par un ou des sauts de ligne, on les transfère à l'élément précédent.
      while ($n > 0 && substr($txt, 0, 1) == "\n") {
        $txt = substr($txt, 1);
        /** @var Run $prev_run */
        $prev_run = $elements[$n - 1];
        $prev_run->setText($prev_run->getText() . "\n");
      }

      $elements[$n]->setText($txt);
    }

    foreach ($elements as $element) {
      $txt = $element->getText();

      // Si on a un élément vide, c'est que les sauts de lignes on été transférés au précédent.
      if($txt == ''){
        continue;
      }

      // On réduit le nombre de sauts de lignes à deux max (pour éviter les commentaires vides).
      $txt = preg_replace("/\n{2,}/", "\n\n", $txt);
      // Si dans un élément il y a un ou plusieurs double sauts de ligne, on doit créer plusieurs éléments.
      $sub_texts = preg_split("/\n\n/", $txt);
      $l = count($sub_texts);
      foreach ($sub_texts as $n => $sub_text) {
        if ($n < $l - 1){
          $sub_text .= "\n\n";
        }

        // Si on a du texte, on crée autant d'éléments du même type qu'on a de commentaires.
        $run = new Run($sub_text);
        $run->setFont($element->getFont());
        $return[] = $run;
      }

    }

    return $return;
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


}
