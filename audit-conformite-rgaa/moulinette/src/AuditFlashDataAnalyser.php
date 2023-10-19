<?php

namespace Copsae;

use \Copsae\AbstractAuditDataAnalyser;
use \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Symfony\Component\Yaml\Yaml;

/**
 * Analyse des données d'audit pour traitement des commentaires.
 */
class AuditFlashDataAnalyser extends AbstractAuditDataAnalyser {

  /**
   * Collecte et centralisation des commentaires.
   */
  public function processAnomalyList() {
    $this->collectAnomalyList();
    $this->applyStyles();
  }


  /**
   * Mise en forme de la liste anomalies.
   */
  protected function applyStyles() {
    $anomaly_sheet = $this->anomalySheet;

    $page_index = $this->spreadsheet->getIndex($anomaly_sheet);
    $highest_row = $anomaly_sheet->getHighestRow();

    // Récupération de la première page de relevé (P01).
    $p01 = $this->spreadsheet->getSheet($page_index + 1);


    // N° de page.
    $anomaly_sheet->duplicateStyle($p01->getStyle('B4'), 'A4:A' . $highest_row);
    // Thématique, critères, n° de règle.
    $anomaly_sheet->duplicateStyle($p01->getStyle('B4'), 'C4:E' . $highest_row);
    // Statut.
    $anomaly_sheet->duplicateStyle($p01->getStyle('F4'), 'G4:G' . $highest_row);
    $anomaly_sheet->duplicateConditionalStyle($p01->getConditionalStyles('F4'), 'G4:G' . $highest_row);
    // Impact.
    $anomaly_sheet->duplicateStyle($p01->getStyle('B4'), 'H4:H' . $highest_row);

    // Style par défaut pour les règles.
    // On s'assure que les règles ne seront pas en bold par défaut.
    $style_array = $p01->getStyle('C4')->exportArray();
    $style_array['font']['bold'] = FALSE;
    $style_array['alignment']['vertical'] = 'middle';
    // print_r($style_array); die;
    $anomaly_sheet->getStyle('B4:B' . $highest_row)->applyFromArray($style_array, FALSE);
    $anomaly_sheet->getStyle('F4:F' . $highest_row)->applyFromArray($style_array, FALSE);

    // Style par défaut pour les commentaires.
    // On s'assure que les commentaires ne seront pas en bold par défaut.
    $style_array = $p01->getStyle('G4')->exportArray();
    $style_array['font']['bold'] = FALSE;
    $style_array['alignment']['vertical'] = 'middle';
    $anomaly_sheet->getStyle('I4:I' . $highest_row)->applyFromArray($style_array, FALSE);

  }

  /**
   * Parcours des pages auditées et synthèse.
   */
  protected function collectAnomalyList() {
    $anomaly_sheet = $this->anomalySheet;
    $sheet_index = $this->spreadsheet->getIndex($anomaly_sheet);
    $sheet_length = $this->spreadsheet->getSheetCount();

    $current_anomaly_row = $anomaly_sheet->getHighestDataRow();

    // On parcours toutes les pages de relevé (P01, P02...).
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
        if (NULL == $value = $cells->get('G' . $row)->getValue()) {
          continue;
        }

        // Séparation des commentaires le cas échéant.
        $comments = $this->extractComments($value);

        // Récupération des autres données correspondant aux commentaires.
        $criterion = $current_sheet->getCell('D' . $row)->getValue();
        // $level = $current_sheet->getCell('C' . $row)->getValue();
        $rule_number = $current_sheet->getCell('B' . $row)->getValue();
        $rule = $current_sheet->getCell('C' . $row)->getValue();
        $status = $current_sheet->getCell('F' . $row)->getValue();

        // Ajout des commentaires traités à la liste.
        foreach ($comments as $comment) {
          $current_anomaly_row++;
          $anomaly_sheet->getCell('A' . $current_anomaly_row)->setValue($sheet_title);
          $anomaly_sheet->getCell('B' . $current_anomaly_row)->setValue($sheet_heading);
          $anomaly_sheet->getCell('C' . $current_anomaly_row)->setValue($theme);
          $anomaly_sheet->getCell('D' . $current_anomaly_row)->setValue($criterion);
          $anomaly_sheet->getCell('E' . $current_anomaly_row)->setValue($rule_number);
          $anomaly_sheet->getCell('F' . $current_anomaly_row)->setValue($rule);
          $anomaly_sheet->getCell('G' . $current_anomaly_row)->setValue($status);

          // Extraction du niveau de criticité.
          $matches = [];
          if (preg_match('/\[(bloquant|majeur|mineur)\]/i', $comment, $matches)) {
            $anomaly_sheet->getCell('H' . $current_anomaly_row)->setValue($matches[1]);
          }

          $anomaly_sheet->getCell('I' . $current_anomaly_row)->setValue($comment);
        }

      }
    }

  }

}
