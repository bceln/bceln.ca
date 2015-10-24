<?php

class Bceln_Migrate_Node_Vendor extends Bceln_Migrate_Abstract {
  protected function getCsvFileName() {
    return 'vendors.csv';
  }

  public function __construct($arguments = []) {
    parent::__construct($arguments);
  	$this->destination = new MigrateDestinationNode('vendor');
  	$this->dealWithPathAuto();    
    $this->map = new MigrateSQLMap($this->machineName,
      [
        'inst_id' => [
          'type' => 'int',
          'not null' => TRUE,
          'description' => 'Vendor ID',
        ],
      ],
      MigrateDestinationNode::getKeySchema()
    );

    $this->addFieldMapping('title', 'inst_name');

    $this->addFieldMapping('field_vendor_url', 'inst_url');
    // $this->addFieldMapping('field_vendor_url:title', '');
    // $this->addFieldMapping('field_vendor_url:attributes', '');
    // $this->addFieldMapping('field_vendor_url:language', '');

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
    // $this->addFieldMapping('path', '');
    // $this->addFieldMapping('comment', '');

    $this->addUnmigratedSources([
      // 'inst_name',
      // 'inst_url',
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
      // 'field_vendor_url',
      'field_vendor_url:title',
      'field_vendor_url:attributes',
      'field_vendor_url:language',
      'field_private_note',
      'field_private_note:format',
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
}
