<?php
/**
 * ContactCharacteristic Model
 *
 * @copyright     Copyright (c) Dotme Tech FZ LLC. (http://dotmetech.com/)
 * @package       app.Model
 * @author        abubakr haider
 *
 */

App::uses('AppModel', 'Model');

class ContactCharacteristic extends AppModel{

/**
 *
 * name of the model
 *
 */
	public $name = 'ContactCharacteristic';


	public $actsAs = array('Containable');

	public $belongsTo = array(
		'FairCategory' => array(
			'className' => 'FairCategory',
			'foreignKey' => 'fair_category_id'
		),
		'ContactCategory' => array(
			'className' => 'ContactCategory',
			'foreignKey' => 'contact_category_id'
		)
	);
}