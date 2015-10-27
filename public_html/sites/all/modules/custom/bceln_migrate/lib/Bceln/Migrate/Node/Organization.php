<?php

class Bceln_Migrate_Node_Organization extends Bceln_Migrate_Abstract {
  protected function getCsvFileName() {
    return 'organizations.csv';
  }

  public function __construct($arguments = []) {
    $this->extraSourceFields = [
      'ip_addresses' => t('IP Addresses looked up in prepareRow()'),
    ];
    parent::__construct($arguments);
  	$this->destination = new MigrateDestinationNode('organization');
  	$this->dealWithPathAuto();    
    $this->map = new MigrateSQLMap($this->machineName,
      [
        'inst_id' => [
          'type' => 'int',
          'not null' => TRUE,
          'description' => 'Organization ID',
        ],
      ],
      MigrateDestinationNode::getKeySchema()
    );

    $this->addFieldMapping('title', 'inst_name');

    $this->addFieldMapping('field_org_nlc_code', 'nlc_code');

    $this->addFieldMapping('field_org_url', 'inst_url');
    // $this->addFieldMapping('field_org_url:title', '');
    // $this->addFieldMapping('field_org_url:attributes', '');
    // $this->addFieldMapping('field_org_url:language', '');

    // $this->addFieldMapping('field_location', '');
    $this->addFieldMapping('field_location:name', 'inst_name');
    $this->addFieldMapping('field_location:street', 'street');
    // $this->addFieldMapping('field_location:additional', '');
    $this->addFieldMapping('field_location:city', 'city');
    $this->addFieldMapping('field_location:province', 'prov');
    $this->addFieldMapping('field_location:postal_code', 'postal_code');
    // $this->addFieldMapping('field_location:country', '');
    // $this->addFieldMapping('field_location:latitude', '');
    // $this->addFieldMapping('field_location:longitude', '');
    // $this->addFieldMapping('field_location:source', '');
    // $this->addFieldMapping('field_location:is_primary', '');

    $this->addFieldMapping('field_org_short_name', 'short_name');

    $this->addFieldMapping('field_sharebc_code', 'iol_code');

    $this->addFieldMapping('field_membership_type', 'membership');

    $this->addFieldMapping('field_org_ip', 'ip_addresses'); // from ip_addresses.csv

    // $this->addFieldMapping('field_org_ip_last_update', ''); // ??

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
    // $this->addFieldMapping('field_private_note', '');
    // $this->addFieldMapping('field_private_note:format', '');
    // $this->addFieldMapping('field_institution_type', '');
    // $this->addFieldMapping('field_public_or_private', '');
    // $this->addFieldMapping('field_fte', '');
    // $this->addFieldMapping('field_org_logo_thumbnail', '');
    // $this->addFieldMapping('field_org_logo_thumbnail:file_class', '');
    // $this->addFieldMapping('field_org_logo_thumbnail:preserve_files', '');
    // $this->addFieldMapping('field_org_logo_thumbnail:destination_dir', '');
    // $this->addFieldMapping('field_org_logo_thumbnail:destination_file', '');
    // $this->addFieldMapping('field_org_logo_thumbnail:file_replace', '');
    // $this->addFieldMapping('field_org_logo_thumbnail:source_dir', '');
    // $this->addFieldMapping('field_org_logo_thumbnail:urlencode', '');
    // $this->addFieldMapping('field_org_logo_thumbnail:alt', '');
    // $this->addFieldMapping('field_org_logo_thumbnail:title', '');
    // $this->addFieldMapping('path', '');
    // $this->addFieldMapping('comment', '');

    $this->addUnmigratedSources([
      // 'inst_name',
      // 'membership',
      // 'street',
      // 'city',
      // 'prov',
      // 'postal_code',
      // 'inst_url',
      // 'nlc_code',
      // 'short_name',
      // 'iol_code',
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
      // 'field_org_nlc_code',
      'field_org_ip_last_update',
      // 'field_org_ip',
      // 'field_org_url',
      'field_org_url:title',
      'field_org_url:attributes',
      'field_org_url:language',
      'field_private_note',
      'field_private_note:format',
      'field_location',
      // 'field_location:name',
      // 'field_location:street',
      'field_location:additional',
      // 'field_location:city',
      // 'field_location:province',
      // 'field_location:postal_code',
      'field_location:country',
      'field_location:latitude',
      'field_location:longitude',
      'field_location:source',
      'field_location:is_primary',
      // 'field_org_short_name',
      'field_institution_type',
      'field_public_or_private',
      'field_fte',
      // 'field_sharebc_code',
      'field_org_logo_thumbnail',
      'field_org_logo_thumbnail:file_class',
      'field_org_logo_thumbnail:preserve_files',
      'field_org_logo_thumbnail:destination_dir',
      'field_org_logo_thumbnail:destination_file',
      'field_org_logo_thumbnail:file_replace',
      'field_org_logo_thumbnail:source_dir',
      'field_org_logo_thumbnail:urlencode',
      'field_org_logo_thumbnail:alt',
      'field_org_logo_thumbnail:title',
      // 'field_membership_type',
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

    $field_info_membership_type = field_info_field('field_membership_type');
    $allowed_values = $field_info_membership_type['settings']['allowed_values'];
    $key = array_search($row->membership, $allowed_values);
    if (FALSE !== $key) {
      $row->membership = $key;
    }

    $row->ip_addresses = Bceln_Migrate_IpAddress::getIpAddressesByInstId($row->inst_id);
  }
}
