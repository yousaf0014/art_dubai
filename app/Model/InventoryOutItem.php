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

class InventoryOutItem extends AppModel{

/**
 *
 * name of the model
 *
 */
	public $name = 'InventoryOutItem';
	
	var $belongsTo = array('InventoryOut' =>
							array('className' => 'InventoryOut',
								  'foreignKey' =>'inventory_out_id'
								  ),				
							'ItemCategory' =>
								array('className' => 'ItemCategory',
								  'foreignKey' =>'item_category_id'
								   ),
							'Employee' =>
								array('className' => 'Employee',
								  'foreignKey' =>'assign_to_id'
								   )
					);

}

?>