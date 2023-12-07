<?php

namespace Copsae;

use \Copsae\AbstractAuditDataAnalyser;

/**
 * @class
 * Analyse des données d'audit pour traitement des commentaires.
 */
class AuditDataAnalyser extends AbstractAuditDataAnalyser {

  /**
   * Collecte et centralisation des commentaires.
   */
  public function processAnomalyList() {
    $this->prepareAnomalySheet();
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

    // Style par défaut pour les commentaires.
    // On s'assure que les commentaires ne seront pas en bold par défaut.
    $style_array = $p01->getStyle('I4')->exportArray();
    $style_array['font']['bold'] = FALSE;

    $anomaly_sheet->duplicateStyle($p01->getStyle('D4'), 'A4:C' . $highest_row);
    $anomaly_sheet->duplicateStyle($p01->getStyle('B4'), 'D4:E' . $highest_row);
    $anomaly_sheet->duplicateStyle($p01->getStyle('D4'), 'F4:F' . $highest_row);
    $anomaly_sheet->duplicateStyle($p01->getStyle('G4'), 'G4:G' . $highest_row);
    $anomaly_sheet->duplicateConditionalStyle($p01->getConditionalStyles('G4'), 'G4:G' . $highest_row);
    $anomaly_sheet->duplicateStyle($p01->getStyle('G4'), 'H4:H' . $highest_row);
    $anomaly_sheet->getStyle('I4:J' . $highest_row)->applyFromArray($style_array, FALSE);

  }

  /**
   * Parcours des pages auditées et synthèse.
   */
  protected function collectAnomalyList() {

    $anomaly_sheet = $this->anomalySheet;
    $sheet_index = $this->spreadsheet->getIndex($anomaly_sheet);
    $sheet_length = $this->spreadsheet->getSheetCount();


    $current_anomaly_row = self::ANOMALY_SHEET_HEADER_ROWS_COUNT;

    $anomalies = [];
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
        $current_cell = $cells->get('I' . $row);
        if (!$current_cell || NULL == $value = $current_cell->getValue()) {
          continue;
        }

        // Séparation des commentaires le cas échéant.
        $comments = $this->extractComments($value);

        // Récupération des commentaires de l'audit de contrôle
        $value = $cells->get('K' . $row)->getValue();
        $control_comments = $this->extractComments($value);

        // Récupération des autres données correspondant aux commentaires.
        $criterion = $current_sheet->getCell('B' . $row)->getValue();
        $level = $current_sheet->getCell('C' . $row)->getValue();
        $recommendation = $current_sheet->getCell('D' . $row)->getValue();
        $status = $current_sheet->getCell('G' . $row)->getValue();

        // Ajout des commentaires traités à la liste.
        foreach ($comments as $k => $comment) {

          $control_value = $control_comments[$k] ?? '';

          if(preg_match('/\[ok\]/i', $control_value)){
            continue;
          }

          $current_anomaly_row++;
          $anomaly_sheet->getCell('A' . $current_anomaly_row)->setValue($sheet_title);
          $anomaly_sheet->getCell('B' . $current_anomaly_row)->setValue($sheet_heading);
          $anomaly_sheet->getCell('C' . $current_anomaly_row)->setValue($theme);
          $anomaly_sheet->getCell('D' . $current_anomaly_row)->setValue($criterion);
          $anomaly_sheet->getCell('E' . $current_anomaly_row)->setValue($level);
          $anomaly_sheet->getCell('F' . $current_anomaly_row)->setValue($recommendation);
          $anomaly_sheet->getCell('G' . $current_anomaly_row)->setValue($status);

          // Extraction du niveau de criticité.
          $matches = [];
          if (preg_match('/\[(bloquant|majeur|mineur)\]/i', $comment, $matches)) {
            $anomaly_sheet->getCell('H' . $current_anomaly_row)->setValue($matches[1]);
          }

          $anomaly_sheet->getCell('I' . $current_anomaly_row)->setValue($comment);

          $anomaly_sheet->getCell('J' . $current_anomaly_row)->setValue($control_value);
        }

      }
    }

    // Écriture des données dans la feuille.
    $anomaly_sheet->fromArray($anomalies, NULL, 'A4');
  }

}
