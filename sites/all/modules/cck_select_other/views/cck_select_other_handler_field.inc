<?php
/**
 * @file
 */


/**
 * Extension to the Content Field Handler class for CCK Select Other
 */
class cck_select_other_handler_field extends content_handler_field {

  function render($values) {
    $values = parent::render($values);
    $field = content_fields($this->content_field['field_name'], $values->{$this->aliases['type']});
    $options = cck_select_other_options($field);

    return isset($options[$values]) ? $options[$values] : $values;
  }
}
