<?php

/**
 * @file
 * FeedsProfile2Processor class.
 */

/**
 * Feeds processor plugin. Create users from feed items.
 */
class FeedsProfile2Processor extends FeedsProcessor {
  /**
   * Define entity type.
   */
  public function entityType() {
    return 'profile2';
  }

  /**
   * Implements parent::entityInfo().
   */
  protected function entityInfo() {
    $info = parent::entityInfo();
    $info['label plural'] = t('User Profiles');
    return $info;
  }

  /**
   * Creates a new profile in memory and returns it.
   */
  protected function newEntity(FeedsSource $source) {
    $profile = profile2_create(array('type' => $this->bundle()));
    return $profile;
  }

  /**
   * Loads an existing profile.
   */
  protected function entityLoad(FeedsSource $source, $pid) {
    $profile = profile2_load($pid);
    return $profile;
  }

  protected function entityValidate($profile) {
    if (empty($profile->uid)) {
      throw new FeedsValidationException(t("User ID, name, or email missing, or user doesn't exist."));
    }
  }

  /**
   * Save a profile.
   */
  protected function entitySave($profile) {
    profile2_save($profile);
  }

  /**
   * Delete multiple user accounts.
   */
  protected function entityDeleteMultiple($pids) {
    profile2_delete_multiple($pids);
  }

  /**
   * Override setTargetElement to operate on a target item that is a node.
   */
  public function setTargetElement(FeedsSource $source, $target_profile, $target_element, $value) {
    switch ($target_element) {
      case 'created':
        $target_profile->created = feeds_to_unixtime($value, REQUEST_TIME);
        break;
      case 'user_name':
        if ($user = user_load_by_name($value)) {
          $target_profile->uid = $user->uid;
        }
        break;
      case 'user_mail':
        if ($user = user_load_by_mail($value)) {
          $target_profile->uid = $user->uid;
        }
        break;
      default:
        parent::setTargetElement($source, $target_profile, $target_element, $value);
        break;
    }
  }

  /**
   * Return available mapping targets.
   */
  public function getMappingTargets() {
    $targets = parent::getMappingTargets();
    $targets['uid'] = array(
      'name' => t('User ID'),
      'description' => t('The Drupal user ID for the profile.'),
      'optional_unique' => TRUE,
    );
    $targets['user_name'] = array(
      'name' => t('Username'),
      'description' => t("The Drupal username of the profile's user."),
      'optional_unique' => TRUE,
    );
    $targets['user_mail'] = array(
      'name' => t('User email'),
      'description' => t("The email address of the profile's user."),
      'optional_unique' => TRUE,
    );
    $targets['created'] = array(
      'name' => t('Published date'),
      'description' => t('The UNIX time when the profile was created.'),
    );

    // Let other modules expose mapping targets.
    self::loadMappers();
    $entity_type = $this->entityType();
    $bundle = $this->bundle();
    drupal_alter('feeds_processor_targets', $targets, $entity_type, $bundle);

    return $targets;
  }

  /**
   * Get id of an existing feed item term if available.
   */
  protected function existingEntityId(FeedsSource $source, FeedsParserResult $result) {
    if ($pid = parent::existingEntityId($source, $result)) {
      //return $pid;
    }

    // Iterate through all unique targets and try to find a user for the
    // target's value.
    foreach ($this->uniqueTargets($source, $result) as $target => $value) {
      $uid = 0;
      switch ($target) {
        case 'uid':
          $uid = $value;
          break;
        case 'user_name':
          $uid = db_query("SELECT uid FROM {users} WHERE name = :name", array(':name' => $value))->fetchField();
          break;
        case 'user_mail':
          $uid = db_query("SELECT uid FROM {users} WHERE mail = :mail", array(':mail' => $value))->fetchField();
          break;
      }
      if (!empty($uid)) {
        $pid = db_select('profile', 'p')
          ->fields('p', array('pid'))
          ->condition('uid', $uid)
          ->condition('type', $this->bundle())
          ->execute()
          ->fetchField();
        if ($pid) {
          return $pid;
        }
      }
    }
    return 0;
  }
}
