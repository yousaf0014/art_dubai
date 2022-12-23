<?php
/**
 * ContactCategory Model
 *
 * @copyright     Copyright (c) Dotme Tech FZ LLC. (http://dotmetech.com/)
 * @package       app.Model
 * @author        abubakr haider
 *
 */

App::uses('AppModel', 'Model');

class ContactCategory extends AppModel{

/**
 *
 * name of the model
 *
 */
	public $name = 'ContactCategory';

	public $actsAs = array('Containable');
	
	public $hasMany = array(
		'ContactCharacteristic' => array(
			'className' => 'ContactCharacteristic',
			'foreignKey' => 'contact_category_id'
		)
	);

}