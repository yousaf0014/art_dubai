<?php
/**
 * Company Model
 *
 * @copyright     Copyright (c) Dotme Tech FZ LLC. (http://dotmetech.com/)
 * @package       app.Model
 * @author        abubakr haider
 *
 */

App::uses('AppModel', 'Model');

class Company extends AppModel{

/**
 *
 * name of the model
 *
 */
	public $name = 'Company';

/**
 * Attach containable behavior
 *
 * @var array
 */
    public $actsAs = array('Containable');

/**
 * Define belongsTo Relationship
 *
 * @var array
 */
    
    public $belongsTo = array(
        'Country' => array(
            'className' => 'Country',
            'foreignKey' => false,
            'conditions' => array('`Country`.`iso` = `Company`.`country`'),
            'dependent' => false
        ),
        'CreatedBy' => array(
            'className' => 'User',
            'foreignKey' => 'created_by'
        ),
        'UpdatedBy' => array(
            'className' => 'User',
            'foreignKey' => 'updated_by'
        ),
        'CorporateCategory' => array(
            'className' => 'CorporateCategory',
            'foreignKey' => 'corporate_category_id'
        )
    );

}