<?php

class Bceln_Migrate_Node_Resource extends Bceln_Migrate_Abstract {
  protected function getCsvFileName() {
    return 'resources.csv';
  }

  public function __construct($arguments = []) {
    $this->extraSourceFields = [
      'subscriptions' => t('Subscribed Organizations looked up in prepareRow()'),
    ];
    parent::__construct($arguments);
  	$this->destination = new MigrateDestinationNode('resource');
  	$this->dealWithPathAuto();    
    $this->map = new MigrateSQLMap($this->machineName,
      [
        'db_id' => [
          'type' => 'int',
          'not null' => TRUE,
          'description' => 'Resource ID',
        ],
      ],
      MigrateDestinationNode::getKeySchema()
    );

    $this->addFieldMapping('field_legacy_id', 'db_id');
    $this->addFieldMapping('title', 'db_name');

    $this->addFieldMapping('field_private_note', 'notes');
    // $this->addFieldMapping('field_private_note:format', '');

    $this->addFieldMapping('field_resource_content_producer', 'content_producer');

    $this->addFieldMapping('field_resources_chron_coverage', 'chron_coverage');

    $this->addFieldMapping('field_resources_usage_stats', 'usage_stats');
    // $this->addFieldMapping('field_resources_usage_stats:format', '');

    $this->addFieldMapping('field_resource_vend_desc', 'more_info');
    // $this->addFieldMapping('field_resource_vend_desc:title', '');
    // $this->addFieldMapping('field_resource_vend_desc:attributes', '');
    // $this->addFieldMapping('field_resource_vend_desc:language', '');

    $this->addFieldMapping('field_resource_vendor_ref', 'vendor_id')->sourceMigration('vendor_import');

    $this->addFieldMapping('field_organization_ref', 'subscriptions')->sourceMigration('organization_import'); // from subscriptions.csv

    $this->addFieldMapping('field_resources_note_subscribers', 'subscrib_notes');
    // $this->addFieldMapping('field_resources_note_subscribers:format', '');

    $this->addFieldMapping('field_resources_multi_consortial', 'multiconsort_note');
    // $this->addFieldMapping('field_resources_multi_consortial:format', '');

    $this->addFieldMapping('field_content_types', 'content_types')->separator(',');
    // $this->addFieldMapping('field_content_types:source_type', '');
    $this->addFieldMapping('field_content_types:create_term')->defaultValue(TRUE);
    $this->addFieldMapping('field_content_types:ignore_case')->defaultValue(TRUE);

    $this->addFieldMapping('field_title_lists', 'title_lists');
    // $this->addFieldMapping('field_title_lists:title', '');
    // $this->addFieldMapping('field_title_lists:attributes', '');
    // $this->addFieldMapping('field_title_lists:language', '');

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
    // $this->addFieldMapping('field_resources_generic_url', '');
    // $this->addFieldMapping('field_resources_generic_url:title', '');
    // $this->addFieldMapping('field_resources_generic_url:attributes', '');
    // $this->addFieldMapping('field_resources_generic_url:language', '');
    // $this->addFieldMapping('field_platform', '');
    // $this->addFieldMapping('field_platform:format', '');
    // $this->addFieldMapping('field_access', '');
    // $this->addFieldMapping('field_access:source_type', '');
    // $this->addFieldMapping('field_access:create_term', '');
    // $this->addFieldMapping('field_access:ignore_case', '');
    // $this->addFieldMapping('path', '');
    // $this->addFieldMapping('comment', '');

    $this->addUnmigratedSources([
      // 'db_name',
      // 'notes',
      // 'content_producer',
      // 'chron_coverage',
      // 'content_types',
      // 'more_info',
      // 'usage_stats',
      // 'vendor_id',
      // 'title_lists',
      // 'multiconsort_note',
      // 'subscrib_notes',
    ]);

    $this->addUnmigratedDestinations([
      // 'title',
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
      // 'field_private_note',
      'field_private_note:format',
      // 'field_resource_vend_desc',
      'field_resource_vend_desc:title',
      'field_resource_vend_desc:attributes',
      'field_resource_vend_desc:language',
      // 'field_resource_content_producer',
      // 'field_resources_chron_coverage',
      // 'field_resources_usage_stats',
      'field_resources_usage_stats:format',
      'field_resources_generic_url',
      'field_resources_generic_url:title',
      'field_resources_generic_url:attributes',
      'field_resources_generic_url:language',
      // 'field_resource_vendor_ref',
      // 'field_organization_ref',
      // 'field_resources_note_subscribers',
      'field_resources_note_subscribers:format',
      // 'field_resources_multi_consortial',
      'field_resources_multi_consortial:format',
      // 'field_content_types',
      'field_content_types:source_type',
      // 'field_content_types:create_term',
      // 'field_content_types:ignore_case',
      'field_platform',
      'field_platform:format',
      // 'field_title_lists',
      'field_title_lists:title',
      'field_title_lists:attributes',
      'field_title_lists:language',
      'field_access',
      'field_access:source_type',
      'field_access:create_term',
      'field_access:ignore_case',
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

    if ('#N/A' == trim($row->title_lists)) {
      $row->title_lists = '';
    }

    // This data row might have an empty ID. In that case, provide a FAKE id.
    if (('PsycCRITIQUES' == trim($row->db_name)) && empty($row->db_id)) {
      $row->db_id = 1337;
    }

    $row->subscriptions = Bceln_Migrate_Subscription::getSubscriptionsByDbId($row->db_id);
  }
}
