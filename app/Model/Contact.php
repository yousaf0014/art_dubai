<?php
/**
 * Country Model
 *
 * @copyright     Copyright (c) Dotme Tech FZ LLC. (http://dotmetech.com/)
 * @package       app.Model
 * @author        abubakr haider
 */

App::uses('AppModel', 'Model');

/**
 *
 * Include uploader plugin Attachment bevhavior to hanle file uploading
 * at model layer
 *
 */

App::uses('AttachmentBehavior', 'Uploader.Model/Behavior');

class Contact extends AppModel{

/**
 * Model name
 *
 * @var string
 */
	public $name = 'Contact';

/**
 * Attach containable behavior
 *
 * @var array
 */
    public $actsAs = array('Containable');
    
/**
 * Define hasMany Relationship
 *
 * @var array
 */
	
	public $hasAndBelongsToMany = array(
        'Fair' => array(
        	'className' => 'Fair',
        	'joinTable' => 'contacts_fairs',
            'foreignKey' => 'contact_id',
            'associationForeignKey' => 'fair_id'
        ),
        'Flag' => array(
            'className' => 'Flag',
            'joinTable' => 'contact_flags',
            'foreignKey' => 'contact_id',
            'associationForeignKey' => 'flag_id',
            'order' => 'ContactFlag.id DESC',
            'conditions' => array('ContactFlag.active' => '1')
        ),
        'ContactCharacteristic' => array(
            'className' => 'ContactCharacteristic',
            'joinTable' => 'contact_to_contact_characteristics',
            'foreignKey' => 'contact_id',
            'associationForeignKey' => 'contact_characteristic_id',
        ),
        'Company' => array(
            'className' => 'Company',
            'joinTable' => 'contact_to_companies',
            'foreignKey' => 'contact_id',
            'associationForeignKey' => 'company_id',
        ),
        'InviteList' => array(
            'className' => 'InviteList',
            'joinTable' => 'contacts_invite_lists',
            'foreignKey' => 'contact_id',
            'associationForeignKey' => 'invite_list_id',
            'conditions' => array('InviteList.active' => '1','ContactsInviteList.active' => '1')
        )
    );

/**
 * Define belongsTo Relationship
 *
 * @var array
 */
    
    public $belongsTo = array(
        'Country' => array(
            'className' => 'Country',
            'foreignKey' => false,
            'conditions' => array('`Country`.`iso` = `Contact`.`country`'),
            'dependent' => false
        ),
        'CreatedBy' => array(
            'className' => 'User',
            'foreignKey' => 'created_by'
        ),
        'UpdatedBy' => array(
            'className' => 'User',
            'foreignKey' => 'updated_by'
        )
    );

    public function getFieldstoCheckForDuplicates() {
        return array('first_name','last_name','phone','mobile','email','website');
    }
}