<?php
/**
 * Fair Model
 *
 * @copyright     Copyright (c) Dotme Tech FZ LLC. (http://dotmetech.com/)
 * @package       app.Model
 * @author        abubakr haider
 */

App::uses('AppModel', 'Model');

/**
 *
 * Include uploader plugin Attachment bevhavior to hanle file uploading
 * at model layer
 *
 */

App::uses('AttachmentBehavior', 'Uploader.Model/Behavior');

class FairEvent extends AppModel{


/**
 * Model name
 *
 * @var string
 */
	public $name = 'FairEvent';

/**
 *
 * Define attachment behavior of uploader plugin
 *
 * @var array
 */

	public $actsAs = array(
		'Uploader.Attachment' => array(
			'location_map' => array(
				'tempDir' => TMP,
				'append' => '',
				'prepend' => '',
				'uploadDir' => '/files/maps/',
				'dbColumn' => 'location_map',
				'overwrite' => false,
				'nameCallback' => 'formatName',
				'extension' => array('jpg', 'png', 'jpeg'),
				'transforms' => array(
					array('method' => 'resize', 'width' => 960,'dbColumn' => 'map', 'append' => false, 'overwrite' => true, 'aspect' => false)
				)
			)
		)
	);
/**
 *
 * callback function to formate the name of uploaded file
 *
 * @param $name string file name
 * @param $file Object contains file inof such size,extension,mime type etc, 
 * @return String file name
 */
	public function formatName($name, $file) {
		return sprintf('%s-%s', $name, $file->size());
	}
	
/**
 * used to get categories/types
 *
 * @return array fair categories/types
 */
	public function getEventTypes(){
		return array('pre' => 'Pre Fair','on' => 'On Fair', 'post' => 'Post Fair');
	}
}