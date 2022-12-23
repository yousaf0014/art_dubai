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

class Role extends AppModel{

/**
 *
 * name of the model
 *
 */
	public $name = 'Role';

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