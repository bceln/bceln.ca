<?php

class Bceln_Migrate_TextFormat {
  static protected $filterFormatIdsByName = [];

  static public function getTextFormatIdByName($name) {
    static::loadTextFormatIdByName();
    if (isset(static::$filterFormatIdsByName[$name])) {
      return static::$filterFormatIdsByName[$name];
    }
    else {
      return filter_fallback_format();
    }
  }

  static protected function loadTextFormatIdByName() {
    if (0 == count(static::$filterFormatIdsByName)) {
      foreach (filter_formats() as $format) {
        static::$filterFormatIdsByName[$format->name] = $format->format;
      }
    }
  }
}
