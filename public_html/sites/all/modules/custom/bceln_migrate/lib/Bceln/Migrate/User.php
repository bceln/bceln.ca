<?php

class Bceln_Migrate_User extends Bceln_Migrate_Abstract {
  protected function getCsvFileName() {
    return 'users.csv';
  }

  public function __construct($arguments = []) {
    parent::__construct($arguments);
  	$this->destination = new MigrateDestinationUser();
    $this->map = new MigrateSQLMap($this->machineName,
      [
        'contact_id' => [
          'type' => 'int',
          'not null' => TRUE,
          'description' => 'User ID',
        ],
      ],
      MigrateDestinationUser::getKeySchema()
    );

    $this->addFieldMapping('mail', 'email');
    // $this->addFieldMapping('name', '');
    // $this->addFieldMapping('pass', '');
    // $this->addFieldMapping('status', '');
    // $this->addFieldMapping('created', '');
    // $this->addFieldMapping('access', '');
    // $this->addFieldMapping('login', '');
    // $this->addFieldMapping('roles', '');
    // $this->addFieldMapping('role_names', '');
    // $this->addFieldMapping('picture', '');
    // $this->addFieldMapping('signature', '');
    // $this->addFieldMapping('signature_format', '');
    // $this->addFieldMapping('timezone', '');
    // $this->addFieldMapping('language', '');
    // $this->addFieldMapping('theme', '');
    // $this->addFieldMapping('init', '');
    // $this->addFieldMapping('data', '');
    // $this->addFieldMapping('is_new', '');
    // $this->addFieldMapping('path', '');
    // $this->addFieldMapping('metatag_title', '');
    // $this->addFieldMapping('metatag_description', '');
    // $this->addFieldMapping('metatag_abstract', '');
    // $this->addFieldMapping('metatag_keywords', '');
    // $this->addFieldMapping('metatag_robots', '');
    // $this->addFieldMapping('metatag_news_keywords', '');
    // $this->addFieldMapping('metatag_standout', '');
    // $this->addFieldMapping('metatag_generator', '');
    // $this->addFieldMapping('metatag_rights', '');
    // $this->addFieldMapping('metatag_image_src', '');
    // $this->addFieldMapping('metatag_canonical', '');
    // $this->addFieldMapping('metatag_shortlink', '');
    // $this->addFieldMapping('metatag_publisher', '');
    // $this->addFieldMapping('metatag_author', '');
    // $this->addFieldMapping('metatag_original-source', '');
    // $this->addFieldMapping('metatag_revisit-after', '');
    // $this->addFieldMapping('metatag_content-language', '');
    // $this->addFieldMapping('metatag_fb:admins', '');
    // $this->addFieldMapping('metatag_fb:app_id', '');
    // $this->addFieldMapping('metatag_og:site_name', '');
    // $this->addFieldMapping('metatag_og:type', '');
    // $this->addFieldMapping('metatag_og:url', '');
    // $this->addFieldMapping('metatag_og:title', '');
    // $this->addFieldMapping('metatag_og:determiner', '');
    // $this->addFieldMapping('metatag_og:description', '');
    // $this->addFieldMapping('metatag_og:updated_time', '');
    // $this->addFieldMapping('metatag_og:see_also', '');
    // $this->addFieldMapping('metatag_og:image', '');
    // $this->addFieldMapping('metatag_og:image:secure_url', '');
    // $this->addFieldMapping('metatag_og:image:type', '');
    // $this->addFieldMapping('metatag_og:image:width', '');
    // $this->addFieldMapping('metatag_og:image:height', '');
    // $this->addFieldMapping('metatag_og:latitude', '');
    // $this->addFieldMapping('metatag_og:longitude', '');
    // $this->addFieldMapping('metatag_og:street-address', '');
    // $this->addFieldMapping('metatag_og:locality', '');
    // $this->addFieldMapping('metatag_og:region', '');
    // $this->addFieldMapping('metatag_og:postal-code', '');
    // $this->addFieldMapping('metatag_og:country-name', '');
    // $this->addFieldMapping('metatag_og:email', '');
    // $this->addFieldMapping('metatag_og:phone_number', '');
    // $this->addFieldMapping('metatag_og:fax_number', '');
    // $this->addFieldMapping('metatag_og:locale', '');
    // $this->addFieldMapping('metatag_og:locale:alternate', '');
    // $this->addFieldMapping('metatag_article:author', '');
    // $this->addFieldMapping('metatag_article:publisher', '');
    // $this->addFieldMapping('metatag_article:section', '');
    // $this->addFieldMapping('metatag_article:tag', '');
    // $this->addFieldMapping('metatag_article:published_time', '');
    // $this->addFieldMapping('metatag_article:modified_time', '');
    // $this->addFieldMapping('metatag_article:expiration_time', '');
    // $this->addFieldMapping('metatag_profile:first_name', '');
    // $this->addFieldMapping('metatag_profile:last_name', '');
    // $this->addFieldMapping('metatag_profile:username', '');
    // $this->addFieldMapping('metatag_profile:gender', '');
    // $this->addFieldMapping('metatag_og:audio', '');
    // $this->addFieldMapping('metatag_og:audio:secure_url', '');
    // $this->addFieldMapping('metatag_og:audio:type', '');
    // $this->addFieldMapping('metatag_book:author', '');
    // $this->addFieldMapping('metatag_book:isbn', '');
    // $this->addFieldMapping('metatag_book:release_date', '');
    // $this->addFieldMapping('metatag_book:tag', '');
    // $this->addFieldMapping('metatag_og:video', '');
    // $this->addFieldMapping('metatag_og:video:secure_url', '');
    // $this->addFieldMapping('metatag_og:video:width', '');
    // $this->addFieldMapping('metatag_og:video:height', '');
    // $this->addFieldMapping('metatag_og:video:type', '');
    // $this->addFieldMapping('metatag_video:actor', '');
    // $this->addFieldMapping('metatag_video:actor:role', '');
    // $this->addFieldMapping('metatag_video:director', '');
    // $this->addFieldMapping('metatag_video:writer', '');
    // $this->addFieldMapping('metatag_video:duration', '');
    // $this->addFieldMapping('metatag_video:release_date', '');
    // $this->addFieldMapping('metatag_video:tag', '');
    // $this->addFieldMapping('metatag_video:series', '');
    // $this->addFieldMapping('metatag_twitter:card', '');
    // $this->addFieldMapping('metatag_twitter:site', '');
    // $this->addFieldMapping('metatag_twitter:site:id', '');
    // $this->addFieldMapping('metatag_twitter:creator', '');
    // $this->addFieldMapping('metatag_twitter:creator:id', '');
    // $this->addFieldMapping('metatag_twitter:url', '');
    // $this->addFieldMapping('metatag_twitter:title', '');
    // $this->addFieldMapping('metatag_twitter:description', '');
    // $this->addFieldMapping('metatag_twitter:image:src', '');
    // $this->addFieldMapping('metatag_twitter:image:width', '');
    // $this->addFieldMapping('metatag_twitter:image:height', '');
    // $this->addFieldMapping('metatag_twitter:image0', '');
    // $this->addFieldMapping('metatag_twitter:image1', '');
    // $this->addFieldMapping('metatag_twitter:image2', '');
    // $this->addFieldMapping('metatag_twitter:image3', '');
    // $this->addFieldMapping('metatag_twitter:player', '');
    // $this->addFieldMapping('metatag_twitter:player:width', '');
    // $this->addFieldMapping('metatag_twitter:player:height', '');
    // $this->addFieldMapping('metatag_twitter:player:stream', '');
    // $this->addFieldMapping('metatag_twitter:player:stream:content_type', '');
    // $this->addFieldMapping('metatag_twitter:app:country', '');
    // $this->addFieldMapping('metatag_twitter:app:name:iphone', '');
    // $this->addFieldMapping('metatag_twitter:app:id:iphone', '');
    // $this->addFieldMapping('metatag_twitter:app:url:iphone', '');
    // $this->addFieldMapping('metatag_twitter:app:name:ipad', '');
    // $this->addFieldMapping('metatag_twitter:app:id:ipad', '');
    // $this->addFieldMapping('metatag_twitter:app:url:ipad', '');
    // $this->addFieldMapping('metatag_twitter:app:name:googleplay', '');
    // $this->addFieldMapping('metatag_twitter:app:id:googleplay', '');
    // $this->addFieldMapping('metatag_twitter:app:url:googleplay', '');
    // $this->addFieldMapping('metatag_twitter:label1', '');
    // $this->addFieldMapping('metatag_twitter:data1', '');
    // $this->addFieldMapping('metatag_twitter:label2', '');
    // $this->addFieldMapping('metatag_twitter:data2', '');

    $this->addUnmigratedSources([
      'last_name',
      'first_name',
      'title',
      'phone',
      'fax',
      // 'email',
      'last_updated',
      'inst_id',
      'description',
    ]);

    $this->addUnmigratedDestinations([
      // 'mail',
      'name',
      'pass',
      'status',
      'created',
      'access',
      'login',
      'roles',
      'role_names',
      'picture',
      'signature',
      'signature_format',
      'timezone',
      'language',
      'theme',
      'init',
      'data',
      'is_new',
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
    ]);
  }
}
