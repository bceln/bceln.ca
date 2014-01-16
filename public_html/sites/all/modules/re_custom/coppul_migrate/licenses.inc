<?php

/**
 * A dynamic migration that is reused for each source CSV file.
 */
class CLicenses extends Migration {
  public function __construct() {
    
    parent::__construct();
        
    $this->description = t('Import Licenses from a CSV file.');
    //$this->dependencies = array('Components');
    
    $path = dirname(__FILE__) . '/data';
    // Create a MigrateSource object, which manages retrieving the input data.
      
  	$this->map = new MigrateSQLMap($this->machineName,
  		array(
  			'name' => array(
  				'type' => 'varchar',
  				'length' => 255,
  				'not null' => TRUE,
  			)
  	 	),
       	MigrateDestinationNode::getKeySchema()
      );

    $this->source = new MigrateSourceCSV($path . '/' . 'licenses-final.csv', array(), array('header_rows' => 1));

  	$this->destination = new MigrateDestinationNode('license');

    //Field mapping
    $this->addFieldMapping('title', 'name');
    $this->addFieldMapping('field_component', 'component')->separator('||');
    $this->addFieldMapping('field_component:source_type')->defaultValue('tid');
    $this->addFieldMapping('field_employer_type', 'type')->separator('||');
    $this->addFieldMapping('field_employer_type:source_type')->defaultValue('tid');
    $this->addFieldMapping('status')->defaultValue(1);
  }

  public function prepareRow($row) {
    // This implementation is created to handle duplicate rows
    // where an Organization can belong to multiple components.

    // Get the next row
    $nextrow = $this->source->getNextRow();
    // Make sure it's not the same row
    if($row->csvrownum != $nextrow->csvrownum) {
      // If then next row has the same name
      if($row->name === $nextrow->name) {
        do {
          // Get the taxonomy term/component of the next row
          $row->component .= ' || ' . $nextrow->component;
          // Iterate to the row after that (the next next row)
          $nextrow = $this->source->getNextRow();
          // And loop as long as the names are the same
        } while($row->name === $nextrow->name);
      }
    }
    // Rewind a row because the second NextRow() will have advanced it too far..
    $this->source->performRewind();
  }

}