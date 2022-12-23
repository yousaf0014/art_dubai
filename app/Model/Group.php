<?php
/**
 * Role Model
 *
 * @copyright     Copyright (c) Dotme Tech FZ LLC. (http://dotmetech.com/)
 * @package       app.Model
 * @author        abubakr haider
 *
 */

App::uses('AppModel', 'Model');

class Group extends AppModel{

/**
 *
 * name of the model
 *
 */
	public $name = 'Group';

	public $useTable = 'roles';
/**
 *
 * Attach behavior to model
 *
 */	
	public $actsAs = array(
		'Acl' => array('type' => 'requester'),
		'Utility.Sluggable' => array('field' => 'name','slug' => 'slug')
	);

	public function parentNode() {
        return null;
    }
}