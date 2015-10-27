<?php

class Bceln_Migrate_IpAddress {
  static protected $csvFileName = 'ip_addresses.csv';

  static protected $isLoaded = FALSE;
  static protected $ipAddresses = [];

  static protected function loadIpAddresses() {
    if (! static::$isLoaded) {
      static::$isLoaded = TRUE;
      if (league_csv_library_load()) {
        $fullFileName = Bceln_Migrate_Config::getFullCsvFileName(static::$csvFileName);
        $data = league_csv_load_with_header($fullFileName);
        foreach ($data as $row) {
          $inst_id = $row['inst_id'];
          $ip_address = $row['ip_address'];
          static::$ipAddresses[$inst_id][$ip_address] = $ip_address;
        }
      }
    }
  }

  static public function getIpAddressesByInstId($inst_id) {
    static::loadIpAddresses();

    $inst_id = trim($inst_id);
    if (isset(static::$ipAddresses[$inst_id])) {
      return array_values(static::$ipAddresses[$inst_id]);
    }
    else {
      return [];
    }
  }
}
