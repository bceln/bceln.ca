<?php

class Bceln_Migrate_Profile extends Bceln_Migrate_Abstract {
  protected function getCsvFileName() {
    return 'users.csv';
  }

  public function __construct($arguments = []) {
    parent::__construct($arguments);
  	$this->destination = new MigrateDestinationProfile2('contact');
  	$this->dealWithPathAuto();    
    $this->map = new MigrateSQLMap($this->machineName,
      [
        'contact_id' => [
          'type' => 'int',
          'not null' => TRUE,
          'description' => 'User ID',
        ],
      ],
      MigrateDestinationProfile2::getKeySchema()
    );

    $this->addFieldMapping('field_legacy_id', 'contact_id');
    $this->addFieldMapping('uid', 'contact_id')->sourceMigration('user_import');
    $this->addFieldMapping('revision_uid', 'contact_id')->sourceMigration('user_import');
    $this->addFieldMapping('field_contact_last_name', 'last_name');
    $this->addFieldMapping('field_organization_ref', 'inst_id')->sourceMigration('organization_import');
    $this->addFieldMapping('field_contact_fax', 'fax');
    $this->addFieldMapping('field_contact_jobtitle', 'title');
    $this->addFieldMapping('field_contact_phone', 'phone');
    $this->addFieldMapping('field_contact_first_name', 'first_name');

    $this->addFieldMapping('field_private_note', 'description');
    // $this->addFieldMapping('field_private_note:format', '');

    // $this->addFieldMapping('language', '');
    // $this->addFieldMapping('field_contact_photo', '');
    // $this->addFieldMapping('field_contact_photo:file_class', '');
    // $this->addFieldMapping('field_contact_photo:preserve_files', '');
    // $this->addFieldMapping('field_contact_photo:destination_dir', '');
    // $this->addFieldMapping('field_contact_photo:destination_file', '');
    // $this->addFieldMapping('field_contact_photo:file_replace', '');
    // $this->addFieldMapping('field_contact_photo:source_dir', '');
    // $this->addFieldMapping('field_contact_photo:urlencode', '');
    // $this->addFieldMapping('field_contact_photo:alt', '');
    // $this->addFieldMapping('field_contact_photo:title', '');
    // $this->addFieldMapping('field_contact_groups', '');
    // $this->addFieldMapping('field_contact_groups:source_type', '');
    // $this->addFieldMapping('field_contact_groups:create_term', '');
    // $this->addFieldMapping('field_contact_groups:ignore_case', '');
    // $this->addFieldMapping('field_contact_skype_address', '');
    // $this->addFieldMapping('path', '');

    $this->addUnmigratedSources([
      // 'last_name',
      // 'first_name',
      // 'title',
      // 'phone',
      // 'fax',
      'email', // @see Bceln_Migrate_User
      'last_updated',
      // 'inst_id',
      // 'description',
    ]);

    $this->addUnmigratedDestinations([
      // 'uid',
      // 'revision_uid',
      'language',
      // 'field_contact_last_name',
      'field_contact_photo',
      'field_contact_photo:file_class',
      'field_contact_photo:preserve_files',
      'field_contact_photo:destination_dir',
      'field_contact_photo:destination_file',
      'field_contact_photo:file_replace',
      'field_contact_photo:source_dir',
      'field_contact_photo:urlencode',
      'field_contact_photo:alt',
      'field_contact_photo:title',
      // 'field_organization_ref',
      // 'field_contact_fax',
      // 'field_contact_jobtitle',
      // 'field_contact_phone',
      // 'field_contact_first_name',
      'field_contact_groups',
      'field_contact_groups:source_type',
      'field_contact_groups:create_term',
      'field_contact_groups:ignore_case',
      'field_contact_skype_address',
      // 'field_private_note',
      'field_private_note:format',
      'path',
    ]);
  }
}
