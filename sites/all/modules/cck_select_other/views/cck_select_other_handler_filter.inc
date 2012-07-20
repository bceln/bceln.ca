<?php
/**
 * @file
 */


/**
 * Extends Content Handler Filter Many To One for CCK Select Other
 */
class cck_select_other_handler_filter extends content_handler_filter_many_to_one {

  function get_value_options() {
    $this->value_options = cck_select_other_options($this->content_field);
  }

  function query() {
    if ($this->value[0] == 'other') {
    }
    else {
      parent::query();
    }
  }
}
