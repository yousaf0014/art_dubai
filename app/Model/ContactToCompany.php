<?php
/**
 * ContactCategory Model
 *
 * @copyright     Copyright (c) Dotme Tech FZ LLC. (http://dotmetech.com/)
 * @package       app.Model
 * @author        M.Fakhir Iqbal
 *
 */

App::uses('AppModel', 'Model');

class ContactToCompany extends AppModel{

/**
 *
 * name of the model
 *
 */
	public $name = 'ContactToCompany';

/**
 * Attach containable behavior
 *
 * @var array
 */
    public $actsAs = array('Containable');

	var $belongsTo = array('Company' =>
							array('className' => 'Company',
								  'foreignKey' =>'company_id'
							),
							'Contact' => array('className' => 'Contact',
											  'foreignKey' =>'contact_id'
											 )
					);

}