<?php

namespace Copsae;

use \PhpOffice\PhpSpreadsheet\IOFactory;
use \PhpOffice\PhpSpreadsheet\Spreadsheet;

/**
 * Permet de transmettre le fichier d'audit après traitement.
 */
class AuditDataWriter {

  /**
   * Le suffixe apposé au nom de fichier transmis par l'utilisateur.
   */
  const FILENAME_SUFFIX = '-liste-anomalies';

  // Les différents formats de sortie.
  const FORMAT_XLSX = 'Xlsx';
  const FORMAT_CSV = 'Csv';
  const FORMAT_YML = 'Yml';

  /**
   * La feuille d'audit chargée en mémoire.
   *
   * @var string|\PhpOffice\PhpSpreadsheet\Spreadsheet
   */
  protected $content;

  /**
   * Le nom du fichier à enregistrer.
   *
   * @var string
   */
  protected $fileName;

  /**
   * Constructeur.
   *
   * @param string|Spreadsheet $content
   *   La feuille d'audit ou le yaml après traitement par AuditDataAnalyser.
   */
  public function __construct($content) {
    $this->content = $content;
  }

  /**
   * Transmet le fichier sous forme de flux de téléchargement au navigateur.
   *
   * @param string $file_name
   *   Le nom ou le chemin du fichier d'audit d'origine.
   * @param string $$format
   *   Le format du fichier de sortie.
   */
  public function directBrowserOutput(string $file_name = NULL, string $format = self::FORMAT_XLSX) {

    // Nom du fichier à renvoyer à l'utilisateur.
    if ($file_name) {
      if ($format == self::FORMAT_XLSX) {
        $path_parts = pathinfo($file_name);
        $output_filename = $path_parts['filename'] . self::FILENAME_SUFFIX . '.' . $path_parts['extension'];
      }
      else {
        $output_filename = $file_name;
      }
    }
    else {
      if ($format == self::FORMAT_XLSX) {
        $output_filename = 'synthese.xlsx';
      }
      elseif ($format == self::FORMAT_CSV) {
        $output_filename = date('Y-m-d') . '.csv';
      }
      elseif ($format == self::FORMAT_YML) {
        $output_filename = date('Y-m-d') . '.yml';
      }
    }

    // Paramétrage de la sortie.
    header('Content-Disposition: attachment;filename="' . $output_filename . '"');
    header('Cache-Control: max-age=0');

    if ($format == self::FORMAT_XLSX) {
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      $writer = IOFactory::createWriter($this->content, 'Xlsx');
      $writer->save('php://output');
    }
    elseif ($format == self::FORMAT_CSV) {
      header('Content-Type: text/csv');
      $writer = IOFactory::createWriter($this->content, 'Csv');
      $writer->save('php://output');
    }
    elseif ($format == self::FORMAT_YML) {
      header('Content-Type: text/yml');
      echo $this->content;
    }

  }

}
