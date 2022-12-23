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

class ItemCategory extends AppModel{

/**
 *
 * name of the model
 *
 */
	public $name = 'ItemCategory';
	
	public $hasMany = array(
        'InventoryOutItem' =>
        	array(
        		'className' => 'InventoryOutItem',        		
                'foreignKey' => 'item_category_id'
            )
    );

}

?>