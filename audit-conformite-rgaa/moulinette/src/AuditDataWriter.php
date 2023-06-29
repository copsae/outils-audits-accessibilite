<?php

namespace Copsae;

use \PhpOffice\PhpSpreadsheet\IOFactory;
use \PhpOffice\PhpSpreadsheet\Spreadsheet;
use \Copsae\AuditDataAnalyser;

/**
 * @class
 * Permet de transmettre le fichier d'audit après traitement.
 */
class AuditDataWriter {

  /**
   * Le suffixe apposé au nom de fichier transmis par l'utilisateur.
   */
  const FILENAME_SUFFIX = '-liste-anomalies';

  /**
   * La feuille d'audit chargée en mémoire.
   *
   * @var \PhpOffice\PhpSpreadsheet\Spreadsheet
   */
  protected $spreadsheet;

  /**
   * @inheritDoc
   *
   * @param Spreadsheet $spreadsheet
   *   La feuille d'audit après traitement par AuditDataAnalyser.
   */
  public function __construct(Spreadsheet $spreadsheet) {
    $this->spreadsheet = $spreadsheet;
  }

  /**
   * Transmet le fichier sous forme de flux de téléchargement au navigateur.
   */
  public function directBrowserOutput() {

    $output_filename = 'synthese.xlsx';
    $input_file = $_FILES[AuditDataAnalyser::FORM_FIELD_NAME] ?? NULL;
    if ($input_file) {
      $path_parts = pathinfo($input_file['name']);
      $output_filename = $path_parts['filename'] . self::FILENAME_SUFFIX . '.' . $path_parts['extension'];
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $output_filename . '"');
    header('Cache-Control: max-age=0');

    $writer = IOFactory::createWriter($this->spreadsheet, 'Xlsx');
    $writer->save('php://output');

  }

}
