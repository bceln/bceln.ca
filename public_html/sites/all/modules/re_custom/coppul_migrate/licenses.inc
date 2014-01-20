<?php

/**
 * A dynamic migration that is reused for each source CSV file.
 */
class Licenses extends Migration {
  public function __construct() {
    
    parent::__construct();
        
    $this->description = t('Import Licenses from a CSV file.');
    //$this->dependencies = array('Components');
    
    $path = dirname(__FILE__) . '/data';
    // Create a MigrateSource object, which manages retrieving the input data.
      
  	$this->map = new MigrateSQLMap($this->machineName,
  		array(
  			'guid' => array(
  				'type' => 'int',
  				'not null' => TRUE,
          'description' => 'UUID of License',
  			)
  	 	),
       	MigrateDestinationNode::getKeySchema()
      );

    $this->source = new MigrateSourceCSV($path . '/' . 'licenses-final.csv', array(), array('header_rows' => 1));

  	$this->destination = new MigrateDestinationNode('license');
    //guid  title ereserves ereserves_txt ill ill_txt archival  archival_txt  url_1 url_2 general
    //Field mapping
    $this->addFieldMapping('title', 'title');
    $this->addFieldMapping('field_license_ereserves', 'ereserves');
    $this->addFieldMapping('field_license_eres_text', 'ereserves_txt');
    $this->addFieldMapping('field_license_ill', 'ill');
    $this->addFieldMapping('field_license_ill_txt', 'ill_txt');
    $this->addFieldMapping('field_license_archival', 'archival');
    $this->addFieldMapping('field_license_archival_txt', 'archival_txt');
    $this->addFieldMapping('field_private_note', 'general');
    $this->addFieldMapping('status')->defaultValue(1);
  }

  // public function prepareRow($row) {
  
  // }

}