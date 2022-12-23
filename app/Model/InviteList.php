<?php
/**
 * InviteList Model
 *
 * @copyright     Copyright (c) Dotme Tech FZ LLC. (http://dotmetech.com/)
 * @package       app.Model
 * @author        abubakr haider
 */

App::uses('AppModel', 'Model');

class InviteList extends AppModel{

/**
 * Model name
 *
 * @var string
 */
	public $name = 'InviteList';

	public $actsAs = array('Containable');

	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'created_by'
        ),
        'Fair' => array(
        	'className' => 'Fair',
        	'foreignKey' => 'fair_id'
        ),
        'InviteCategory' => array(
        	'className' => 'InviteCategory',
        	'foreignKey' => 'invite_category_id'
        )
    );

}