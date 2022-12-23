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

class InventoryOut extends AppModel{

/**
 *
 * name of the model
 *
 */
	public $name = 'InventoryOut';		
	
	public $hasMany = array(
        'InventoryOutItem' =>
        	array(
        		'className' => 'InventoryOutItem',        		
                'foreignKey' => 'inventory_out_id'
            )
    );

}

?>