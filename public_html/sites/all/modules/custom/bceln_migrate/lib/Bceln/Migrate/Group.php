<?php

class Bceln_Migrate_Group {
  static protected $groupCsvFileName = 'groups.csv';
  static protected $relationCsvFileName = 'contacts_groups.csv';

  static protected $isLoaded = FALSE;
  static protected $groupNamesByContactId = [];

  static protected function loadGroups() {
    if (! static::$isLoaded) {
      static::$isLoaded = TRUE;
      if (league_csv_library_load()) {
        $groups = [];
        $groupData = league_csv_load_with_header(Bceln_Migrate_Config::getFullCsvFileName(static::$groupCsvFileName));
        $relationData = league_csv_load_with_header(Bceln_Migrate_Config::getFullCsvFileName(static::$relationCsvFileName));
        foreach ($groupData as $row) {
          $group_id = trim($row['group_id']);
          $group_name = trim($row['group_name']);
          $groups[$group_id] = $group_name;
        }
        foreach ($relationData as $row) {
          $contact_id = trim($row['contact_id']);
          $group_id = trim($row['group_id']);
          if (isset($groups[$group_id])) {
            $group_name = $groups[$group_id];
            static::$groupNamesByContactId[$contact_id][$group_name] = $group_name;
          }
        }
      }
    }
  }

  static public function getGroupNamesByContactId($contact_id) {
    static::loadGroups();

    $contact_id = trim($contact_id);
    if (isset(static::$groupNamesByContactId[$contact_id])) {
      return array_values(static::$groupNamesByContactId[$contact_id]);
    }
    else {
      return [];
    }
  }
}
