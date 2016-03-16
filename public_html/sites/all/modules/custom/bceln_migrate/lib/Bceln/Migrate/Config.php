<?php

class Bceln_Migrate_Config {

  /**
   * The uid on the new system to be used as default node author.
   */
  static public function getDefaultUid() {
    return 1;
  }

  static public function getModuleName() {
    return 'bceln_migrate';
  }

  static public function getFullCsvFileName($csvFileName = '') {
    $modulePath = drupal_get_path('module', static::getModuleName());
    $defaultDataDirectory = $modulePath . '/data';
    $varName = static::getModuleName() . '_data_directory';
    $dataDirectory = variable_get($varName, $defaultDataDirectory);

    $defaultFileName = $csvFileName;
    $csvFileKey = str_replace('.', '_', $csvFileName);
    $varName = static::getModuleName() . '_csv_file_name_' . $csvFileKey;
    $fileName = variable_get($varName, $defaultFileName);

    return $dataDirectory . '/' . $fileName;
  }

  static public function getFullLicenseFileDirectoryName() {
    $modulePath = drupal_get_path('module', static::getModuleName());
    $defaultLicenseFileDirectory = variable_get('file_public_path', 'sites/default/files') . '/bceln_migrate_license_file_directory';
    $varName = static::getModuleName() . '_license_file_directory';
    $licenseFileDirectory = variable_get($varName, $defaultLicenseFileDirectory);

    return rtrim($licenseFileDirectory, '/');
  }
}
