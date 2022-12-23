<?php
/**
 * ContactsFair Model
 *
 * @copyright     Copyright (c) Dotme Tech FZ LLC. (http://dotmetech.com/)
 * @package       app.Model
 * @author        abubakr haider
 */

App::uses('AppModel', 'Model');

class ContactsFair extends AppModel{


/**
 * Model name
 *
 * @var string
 */
	public $name = 'ContactsFair';

/**
 * Primary Key name
 *
 * @var string
 */
	
	public $primaryKey = '';

/**
 * 	Define Belongs to relation
 *
 *
 */

	public $belongsTo = array(
		'Contact' => array(
			'className' => 'Contact',
			'foreignKey' => 'contact_id'
		),
		'Fair' => array(
			'className' => 'Fair',
			'foreignKey' => 'fair_id'
		)
	);
}