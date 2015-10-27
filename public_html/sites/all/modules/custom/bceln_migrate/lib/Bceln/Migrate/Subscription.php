<?php

class Bceln_Migrate_Subscription {
  static protected $csvFileName = 'subscriptions.csv';

  static protected $isLoaded = FALSE;
  static protected $subscriptions = [];

  static protected function loadSubscriptions() {
    if (! static::$isLoaded) {
      static::$isLoaded = TRUE;
      if (league_csv_library_load()) {
        $fullFileName = Bceln_Migrate_Config::getFullCsvFileName(static::$csvFileName);
        $data = league_csv_load_with_header($fullFileName);
        foreach ($data as $row) {
          $db_id = $row['db_id'];
          $inst_id = $row['inst_id'];
          static::$subscriptions[$db_id][$inst_id] = $inst_id;
        }
      }
    }
  }

  static public function getSubscriptionsByDbId($db_id) {
    static::loadSubscriptions();

    $db_id = trim($db_id);
    if (isset(static::$subscriptions[$db_id])) {
      return array_values(static::$subscriptions[$db_id]);
    }
    else {
      return [];
    }
  }
}
