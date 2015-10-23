<?php

abstract class Bceln_Migrate_Abstract extends Migration {
  abstract protected function getCsvFileName();

  public function __construct($arguments = []) {
    parent::__construct($arguments);
    $this->setCsvSource($this->getCsvFileName());
  }

  protected function getFullCsvFileName($csvFileName = '') {
    if ('' == $csvFileName) {
      $csvFileName = $this->getCsvFileName();
    }

    $modulePath = drupal_get_path('module', 'bceln_migrate');
    $defaultDataDirectory = $modulePath . '/data';
    $dataDirectory = variable_get('bceln_migrate_data_directory', $defaultDataDirectory);

    $csvFileKey = str_replace('.', '_', $csvFileName);
    $defaultFileName = $csvFileName;
    $fileName = variable_get('bceln_migrate_csv_file_name_' . $csvFileKey, $defaultFileName);
    return $dataDirectory . '/' . $fileName;
  }

  protected function setCsvSource($csvFileName = '') {
    if ('' == $csvFileName) {
      $csvFileName = $this->getCsvFileName();
    }
    $fullFileName = $this->getFullCsvFileName($csvFileName);
    $sourceOptions = [
      'header_rows' => TRUE,
      'embedded_newlines' => TRUE,
    ];
    $this->source = new MigrateSourceCSV($fullFileName, [], $sourceOptions);
  }
}
