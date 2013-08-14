<?php
/**
 * @file
 * ehlbc_rules.rules_defaults.inc
 */

/**
 * Implements hook_default_rules_configuration().
 */
function ehlbc_rules_default_rules_configuration() {
  $items = array();
  $items['ehlbc_rules_force_profile_creation'] = entity_import('rules_config', '{ "ehlbc_rules_force_profile_creation" : {
      "LABEL" : "Force profile creation",
      "PLUGIN" : "reaction rule",
      "TAGS" : [ "profile" ],
      "REQUIRES" : [ "php", "rules" ],
      "ON" : [ "user_login" ],
      "IF" : [
        { "php_eval" : { "code" : "\\u002F\\u002F Check if the user contact profile is empty:\\u000D\\u000Areturn ehlbc_rules_condition_profile_empty($account);" } }
      ],
      "DO" : [
        { "drupal_message" : { "message" : "Welcome!\\u000D\\u000A\\u000D\\u000AYou must fill in your Profile before continuing to use this site." } },
        { "redirect" : { "url" : "user\\u002F[account:uid]\\u002Fedit\\u002Fcontact" } }
      ]
    }
  }');
  $items['ehlbc_rules_user_profile_reminder'] = entity_import('rules_config', '{ "ehlbc_rules_user_profile_reminder" : {
      "LABEL" : "User profile reminder",
      "PLUGIN" : "reaction rule",
      "TAGS" : [ "profile" ],
      "REQUIRES" : [ "php", "rules" ],
      "ON" : [ "user_login" ],
      "IF" : [
        { "php_eval" : { "code" : "\u002F\u002F Returns true if the profile was created over a year ago:\u000D\u000Areturn ehlbc_rules_condition_profile_over_one_year_old($account);" } }
      ],
      "DO" : [
        { "drupal_message" : { "message" : "Hey, it\u0027s been over a year since you joined this site and we\u0027d like to make sure that your contact information is still correct. Please \u003Ca href=\u0022\u002Fuser\u002F[account:uid]\u002Fedit\u002Fcontact\u0022\u003Echeck your profile\u003C\u002Fa\u003E and make sure all the information is correct." } }
      ]
    }
  }');
  return $items;
}
