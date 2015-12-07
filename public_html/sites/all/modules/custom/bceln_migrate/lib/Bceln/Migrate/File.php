<?php

class Bceln_Migrate_File {
  static protected $csvFileName = 'license_files.csv';

  static protected $isLoaded = FALSE;
  static protected $fileNames = [];

  static protected function loadFileNames() {
    if (! static::$isLoaded) {
      static::$isLoaded = TRUE;
      if (league_csv_library_load()) {
        $fullCsvFileName = Bceln_Migrate_Config::getFullCsvFileName(static::$csvFileName);
        $data = league_csv_load_with_header($fullCsvFileName);
        $dirName = Bceln_Migrate_Config::getFullLicenseFileDirectoryName();
        foreach ($data as $row) {
          $licenceId = $row['licence_id'];
          foreach (['pdf-filename_1', 'pdf-filename_2'] as $columnName) {
            $fileName = $row[$columnName];
            // Check if source file actually exists.
            $fullFileName = $dirName . '/' . $fileName;
            if (file_exists($fullFileName)) {
              static::$fileNames[$licenceId][$fileName] = $fileName;
            }
            else if ('' != trim($fileName)) {
              $message = t('Could not find file %file for license with ID %licence_id!', ['%file' => $fullFileName, '%licence_id' => $licenceId]);
              Migration::currentMigration()->saveMessage($message);
            }
          }
        }
      }
    }
  }

  static public function getFileNameByLicenseId($licence_id) {
    static::loadFileNames();

    $licence_id = trim($licence_id);
    if (isset(static::$fileNames[$licence_id])) {
      return array_values(static::$fileNames[$licence_id]);
    }
    else {
      return [];
    }
  }
}
