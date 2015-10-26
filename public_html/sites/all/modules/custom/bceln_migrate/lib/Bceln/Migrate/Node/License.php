<?php

class Bceln_Migrate_Node_License extends Bceln_Migrate_Abstract {
  protected function getCsvFileName() {
    return 'licenses.csv';
  }

  public function __construct($arguments = []) {
    parent::__construct($arguments);
  	$this->destination = new MigrateDestinationNode('license');
  	$this->dealWithPathAuto();    
    $this->map = new MigrateSQLMap($this->machineName,
      [
        'licence_id' => [
          'type' => 'int',
          'not null' => TRUE,
          'description' => 'License ID',
        ],
      ],
      MigrateDestinationNode::getKeySchema()
    );

    $this->addFieldMapping('field_license_eres_text', 'ereserves_txt');
    // $this->addFieldMapping('field_license_eres_text:format', '');

    $this->addFieldMapping('field_license_ill_txt', 'ill_txt');
    // $this->addFieldMapping('field_license_ill_txt:format', '');

    $this->addFieldMapping('field_license_archival_txt', 'archival_txt');
    // $this->addFieldMapping('field_license_archival_txt:format', '');

    $this->addFieldMapping('field_private_note', 'general');
    // $this->addFieldMapping('field_private_note:format', '');

    $this->addFieldMapping('field_license_ereserves', 'ereserves');
    $this->addFieldMapping('field_license_ill', 'ill');
    $this->addFieldMapping('field_license_archival', 'archival');
    $this->addFieldMapping('field_resource', 'db_id')->sourceMigration('resource_import');

    $this->addFieldMapping('field_licence_begins', 'begins');
    $this->addFieldMapping('field_licence_begins:timezone')->defaultValue('America/Vancouver');
    // $this->addFieldMapping('field_licence_begins:rrule', '');
    // $this->addFieldMapping('field_licence_begins:to', '');

    $this->addFieldMapping('field_licence_ends', 'ends');
    $this->addFieldMapping('field_licence_ends:timezone')->defaultValue('America/Vancouver');
    // $this->addFieldMapping('field_licence_ends:rrule', '');
    // $this->addFieldMapping('field_licence_ends:to', '');

    $this->addFieldMapping('field_url', 'url_1');
    $this->addFieldMapping('field_url:title', 'url_1_format');
    // $this->addFieldMapping('field_url:attributes', '');
    // $this->addFieldMapping('field_url:language', '');

    // $this->addFieldMapping('title', '');
    // $this->addFieldMapping('uid', '');
    // $this->addFieldMapping('created', '');
    // $this->addFieldMapping('changed', '');
    // $this->addFieldMapping('status', '');
    // $this->addFieldMapping('promote', '');
    // $this->addFieldMapping('sticky', '');
    // $this->addFieldMapping('revision', '');
    // $this->addFieldMapping('log', '');
    // $this->addFieldMapping('language', '');
    // $this->addFieldMapping('tnid', '');
    // $this->addFieldMapping('translate', '');
    // $this->addFieldMapping('revision_uid', '');
    // $this->addFieldMapping('is_new', '');
    // $this->addFieldMapping('body', '');
    // $this->addFieldMapping('body:summary', '');
    // $this->addFieldMapping('body:format', '');
    // $this->addFieldMapping('field_attachments', '');
    // $this->addFieldMapping('field_attachments:file_class', '');
    // $this->addFieldMapping('field_attachments:preserve_files', '');
    // $this->addFieldMapping('field_attachments:destination_dir', '');
    // $this->addFieldMapping('field_attachments:destination_file', '');
    // $this->addFieldMapping('field_attachments:file_replace', '');
    // $this->addFieldMapping('field_attachments:source_dir', '');
    // $this->addFieldMapping('field_attachments:urlencode', '');
    // $this->addFieldMapping('field_attachments:description', '');
    // $this->addFieldMapping('field_attachments:display', '');
    // $this->addFieldMapping('field_resources_multiyear_cont', '');
    // $this->addFieldMapping('field_resources_multiyear_cont:timezone', '');
    // $this->addFieldMapping('field_resources_multiyear_cont:rrule', '');
    // $this->addFieldMapping('field_resources_multiyear_cont:to', '');
    // $this->addFieldMapping('path', '');
    // $this->addFieldMapping('comment', '');

    $this->addUnmigratedSources([
      // 'begins',
      // 'ends',
      // 'ereserves',
      // 'ereserves_txt',
      // 'ill',
      // 'ill_txt',
      // 'archival',
      // 'archival_txt',
      // 'db_id',
      // 'url_1',
      // 'url_1_format',
      'url_2', // - in the new site the URL will be a repeatable field; to make the migration easier, you could migrate only the first URL; we'll manually do the second for the few items which have it
      'url_2_format',
      // 'general',
    ]);

    $this->addUnmigratedDestinations([
      'title',
      'uid',
      'created',
      'changed',
      'status',
      'promote',
      'sticky',
      'revision',
      'log',
      'language',
      'tnid',
      'translate',
      'revision_uid',
      'is_new',
      'body',
      'body:summary',
      'body:format',
      // 'field_license_eres_text',
      'field_license_eres_text:format',
      // 'field_license_ill_txt',
      'field_license_ill_txt:format',
      // 'field_license_archival_txt',
      'field_license_archival_txt:format',
      // 'field_private_note',
      'field_private_note:format',
      'field_attachments',
      'field_attachments:file_class',
      'field_attachments:preserve_files',
      'field_attachments:destination_dir',
      'field_attachments:destination_file',
      'field_attachments:file_replace',
      'field_attachments:source_dir',
      'field_attachments:urlencode',
      'field_attachments:description',
      'field_attachments:display',
      // 'field_license_ereserves',
      // 'field_license_ill',
      // 'field_license_archival',
      // 'field_resource',
      // 'field_licence_begins',
      // 'field_licence_begins:timezone',
      'field_licence_begins:rrule',
      'field_licence_begins:to',
      // 'field_licence_ends',
      // 'field_licence_ends:timezone',
      'field_licence_ends:rrule',
      'field_licence_ends:to',
      // 'field_url',
      // 'field_url:title',
      'field_url:attributes',
      'field_url:language',
      'field_resources_multiyear_cont',
      'field_resources_multiyear_cont:timezone',
      'field_resources_multiyear_cont:rrule',
      'field_resources_multiyear_cont:to',
      'path',
      'metatag_title',
      'metatag_description',
      'metatag_abstract',
      'metatag_keywords',
      'metatag_robots',
      'metatag_news_keywords',
      'metatag_standout',
      'metatag_generator',
      'metatag_rights',
      'metatag_image_src',
      'metatag_canonical',
      'metatag_shortlink',
      'metatag_publisher',
      'metatag_author',
      'metatag_original-source',
      'metatag_revisit-after',
      'metatag_content-language',
      'metatag_fb:admins',
      'metatag_fb:app_id',
      'metatag_og:site_name',
      'metatag_og:type',
      'metatag_og:url',
      'metatag_og:title',
      'metatag_og:determiner',
      'metatag_og:description',
      'metatag_og:updated_time',
      'metatag_og:see_also',
      'metatag_og:image',
      'metatag_og:image:secure_url',
      'metatag_og:image:type',
      'metatag_og:image:width',
      'metatag_og:image:height',
      'metatag_og:latitude',
      'metatag_og:longitude',
      'metatag_og:street-address',
      'metatag_og:locality',
      'metatag_og:region',
      'metatag_og:postal-code',
      'metatag_og:country-name',
      'metatag_og:email',
      'metatag_og:phone_number',
      'metatag_og:fax_number',
      'metatag_og:locale',
      'metatag_og:locale:alternate',
      'metatag_article:author',
      'metatag_article:publisher',
      'metatag_article:section',
      'metatag_article:tag',
      'metatag_article:published_time',
      'metatag_article:modified_time',
      'metatag_article:expiration_time',
      'metatag_profile:first_name',
      'metatag_profile:last_name',
      'metatag_profile:username',
      'metatag_profile:gender',
      'metatag_og:audio',
      'metatag_og:audio:secure_url',
      'metatag_og:audio:type',
      'metatag_book:author',
      'metatag_book:isbn',
      'metatag_book:release_date',
      'metatag_book:tag',
      'metatag_og:video',
      'metatag_og:video:secure_url',
      'metatag_og:video:width',
      'metatag_og:video:height',
      'metatag_og:video:type',
      'metatag_video:actor',
      'metatag_video:actor:role',
      'metatag_video:director',
      'metatag_video:writer',
      'metatag_video:duration',
      'metatag_video:release_date',
      'metatag_video:tag',
      'metatag_video:series',
      'metatag_twitter:card',
      'metatag_twitter:site',
      'metatag_twitter:site:id',
      'metatag_twitter:creator',
      'metatag_twitter:creator:id',
      'metatag_twitter:url',
      'metatag_twitter:title',
      'metatag_twitter:description',
      'metatag_twitter:image:src',
      'metatag_twitter:image:width',
      'metatag_twitter:image:height',
      'metatag_twitter:image0',
      'metatag_twitter:image1',
      'metatag_twitter:image2',
      'metatag_twitter:image3',
      'metatag_twitter:player',
      'metatag_twitter:player:width',
      'metatag_twitter:player:height',
      'metatag_twitter:player:stream',
      'metatag_twitter:player:stream:content_type',
      'metatag_twitter:app:country',
      'metatag_twitter:app:name:iphone',
      'metatag_twitter:app:id:iphone',
      'metatag_twitter:app:url:iphone',
      'metatag_twitter:app:name:ipad',
      'metatag_twitter:app:id:ipad',
      'metatag_twitter:app:url:ipad',
      'metatag_twitter:app:name:googleplay',
      'metatag_twitter:app:id:googleplay',
      'metatag_twitter:app:url:googleplay',
      'metatag_twitter:label1',
      'metatag_twitter:data1',
      'metatag_twitter:label2',
      'metatag_twitter:data2',
      'comment',
    ]);
  }


  public function prepareRow($row) {
    // Always include this fragment at the beginning of every prepareRow()
    // implementation, so parent classes can ignore rows.
    if (parent::prepareRow($row) === FALSE) {
      return FALSE;
    }

    $remap = [
      'field_license_ereserves' => 'ereserves',
      'field_license_ill' => 'ill',
      'field_license_archival' => 'archival',
    ];
    foreach ($remap as $drupal_field => $csv_field) {
      $field_info = field_info_field($drupal_field);
      $allowed_values = $field_info['settings']['allowed_values'];
      $key = array_search($row->$csv_field, $allowed_values);
      if (FALSE !== $key) {
        $row->$csv_field = $key;
      }
      else if (in_array(trim($row->$csv_field), ['NA', 'NULL'])) {
        $row->$csv_field = '';
      }
    }
  }
}
