<?php

namespace Copsae;

use \ErrorException;
use \PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * @class
 * Charge un fichier d'audit et le convertit en Spreadsheet.
 */
class AuditDataReader {


  // Les messages d'erreur.
  const ERROR_NO_FILE_CODE = 10;
  const ERROR_NO_FILE_MESSAGE = "Aucun fichier n'a été transmis. Vous devez envoyer un fichier au format xlsx pour qu'il puisse être analysé et traité.";

  const ERROR_UNKNOWN_SOURCE = 20;
  const ERROR_UNKNOWN_SOURCE_MESSAGE = "Le fichier transmis ne semble pas être une grille d'audit maintenue par Copsaé.";

  const ERROR_OLD_VERSION = 30;
  const ERROR_OLD_VERSION_MESSAGE = "La version de votre fichier d'audit semble trop ancienne (pas d'onglet Liste anomalies).";

  // L'adresse du repo pour validation des fichiers excel.
  const DATA_SOURCE_URL = 'https://github.com/copsae/outils-audits-accessibilite';

  // Le titre de la feuille utilisée pour recenser les anomalies.
  const ANOMALY_SHEET_NAME = 'Liste anomalies';

  // Les méthode de récupération du fichier d'audit.
  // Récupération du fichier suite à envoi par formulaire.
  const METHOD_FORM_FIELD = 'form_field';

  // Récupération du fichier stocké sur le serveur.
  const METHOD_FILE = 'file';

  // Les types d'audit.
  const AUDIT_TYPE_COMPLIANCE = 'audit de conformité RGAA';
  const AUDIT_TYPE_FLASH = 'audit flash';


  /**
   * La feuille d'audit chargée en mémoire.
   *
   * @var \PhpOffice\PhpSpreadsheet\Spreadsheet
   */
  protected $spreadsheet;

  /**
   * La méthode à utiliser pour récupérer le fichier d'audit.
   *
   * @var string
   */
  protected $loadMethod;

  /**
   * Le nom du champ de formulaire ou le chemin du fichier à charger.
   *
   * @var string
   */
  protected $fileName;

  /**
   * Le type de grille d'audit chargé.
   *
   * @var string
   */
  protected $auditType;

  /**
   * Constructeur.
   *
   * @param string $method
   *   La méthode utilisée pour le chargement du fichier xlsx.
   * @param string $file_name
   *   Le nom du champs de formulaire ou le chemin vers le fichier à charger.
   */
  public function __construct($method = self::METHOD_FORM_FIELD, $file_name = 'spreadsheet') {
    $this->loadMethod = $method;
    $this->fileName = $file_name;
  }

  /**
   * Accesseur du type d'audit.
   *
   * @return string
   *   Le type d'audit.
   */
  public function getAuditType() {
    return $this->auditType;
  }

  /**
   * Accesseur de la feuille d'audit.
   *
   * @return \PhpOffice\PhpSpreadsheet\Spreadsheet
   *   La feuille d'audit.
   */
  public function getSpreadsheet() {
    return $this->spreadsheet;
  }

  /**
   * Retourne le nom du fichier initial chargé par le formulaire.
   *
   * @return string
   *   Le nom du fichier.
   */
  public function getAuditFileName() {
    $input_file = $_FILES[$this->fileName];
    return $input_file['name'];
  }

  /**
   * Chargement du fichier et vérification des prérequis.
   *
   * - Présence d'un fichier ?
   * - Feuille d'audit copsaé ?
   * - Présence de la feuille de liste des anomalies ?
   *
   * @todo Implémenter le chargement d'un fichier sur serveur.
   *
   * @return bool
   *   Si aucun fichier n'est à traiter, retourne FALSE.
   *   Si les tests ont été effectués avec succès, retourne TRUE.
   *   Si une erreur est rencontrée durant les tests, émet une exception.
   */
  public function loadFile() {
    // Pas de files, pas de question.
    if (empty($_FILES)) {
      return FALSE;
    }

    // Récupération du fichier via le formulaire.
    $input_file = $_FILES[$this->fileName] ?? NULL;
    if (!$input_file || empty($input_file['name'])) {
      throw new ErrorException(self::ERROR_NO_FILE_MESSAGE, self::ERROR_NO_FILE_CODE);
    }

    // Chargement de la feuille d'audit en mémoire.
    $spreadsheet = IOFactory::load($input_file['tmp_name']);

    // Récupération de la source de l'outil afin de vérifier
    // qu'il s'agit bien d'une feuille copsaé.
    $this->detectAuditType($spreadsheet);
    if (NULL == $this->auditType) {
      throw new ErrorException(self::ERROR_UNKNOWN_SOURCE_MESSAGE, self::ERROR_UNKNOWN_SOURCE);
    }

    // On recherche la feuille de liste d'anomalies par son titre.
    if (NULL == $spreadsheet->getSheetByName(self::ANOMALY_SHEET_NAME)) {
      throw new ErrorException(self::ERROR_OLD_VERSION, self::ERROR_OLD_VERSION_MESSAGE);
    }

    $this->spreadsheet = $spreadsheet;
    return TRUE;

  }

  /**
   * Définition du type d'audit.
   *
   * On détermine la différence entre les deux types d'audit pris en charge
   * simplement par la case dans laquelle est indiquée la source de l'outil.
   *
   * @param \PhpOffice\PhpSpreadsheet\Spreadsheet $spreadsheet
   *   La feuille d'audit chargée.
   */
  public function detectAuditType($spreadsheet) {

    // Audit de conformité RGAA.
    $source = $spreadsheet->getSheet(0)->getCell('B3')->getCalculatedValue() ?? '';
    if (strripos($source, self::DATA_SOURCE_URL) !== FALSE) {
      $this->auditType = self::AUDIT_TYPE_COMPLIANCE;
      return;
    }

    // Audit flash.
    $source = $spreadsheet->getSheet(0)->getCell('B4')->getCalculatedValue() ?? '';
    if (strripos($source, self::DATA_SOURCE_URL) !== FALSE) {
      $this->auditType = self::AUDIT_TYPE_FLASH;
      return;
    }

  }

}
