<?php

abstract class Bceln_Migrate_Abstract extends Migration {
  abstract protected function getCsvFileName();

  protected $extraSourceFields = [];

  public function __construct($arguments = []) {
    parent::__construct($arguments);
    $this->setCsvSource($this->getCsvFileName());
  }

  protected function setCsvSource($csvFileName = '') {
    if ('' == $csvFileName) {
      $csvFileName = $this->getCsvFileName();
    }
    $fullFileName = Bceln_Migrate_Config::getFullCsvFileName($csvFileName);
    $sourceOptions = [
      'header_rows' => TRUE,
      'embedded_newlines' => TRUE,
    ];
    $this->source = new MigrateSourceCSV($fullFileName, [], $sourceOptions, $this->extraSourceFields);
  }

  protected function dealWithPathAuto() {
    $fields = $this->destination->fields();
    if (isset($fields['pathauto'])) {
      $this->addFieldMapping('pathauto')->defaultValue(1);
    }
  }
}
