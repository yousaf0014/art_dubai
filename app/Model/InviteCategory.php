<?php
/**
 * InviteCategory Model
 *
 * @copyright     Copyright (c) Dotme Tech FZ LLC. (http://dotmetech.com/)
 * @package       app.Model
 * @author        abubakr haider
 *
 */

App::uses('AppModel', 'Model');

class InviteCategory extends AppModel{

/**
 *
 * name of the model
 *
 */
	public $name = 'InviteCategory';

	public $actsAs = array('Containable');
	
	public $hasMany = array(
		'InviteList' => array(
			'className' => 'InviteList',
			'foreignKey' => 'invite_category_id'
		)
	);

	public $belongsTo = array(
		'FairCategory' => array(
			'className' => 'FairCategory',
			'foreignKey' => 'fair_category_id'
		)
	);

}