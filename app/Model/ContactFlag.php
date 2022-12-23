<?php
/**
 * Fair Model
 *
 * @copyright     Copyright (c) Dotme Tech FZ LLC. (http://dotmetech.com/)
 * @package       app.Model
 * @author        abubakr haider
 *
 */

App::uses('AppModel', 'Model');

class ContactFlag extends AppModel{
	public $name = 'ContactFlag';
	public $actsAs = array('Containable');
	public $belongsTo = array(
        'Flag' => array(
            'className' => 'Flag',
            'foreignKey' => 'flag_id'
        ),
		'User' => array(
            'className' => 'User',
            'foreignKey' => 'created_by'
        )
    );
}