<?php
App::uses('AppModel', 'Model');
/**
 * ContactsInviteList Model
 *
 * @property Contact $Contact
 * @property n $ContactList
 * @property InviteList $InviteList
 */
class ContactsInviteList extends AppModel {

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = null;

/**
 * containable behaviour
 *
 * @var array
 */
	public $actsAs = array('Containable');
/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Contact' => array(
			'className' => 'Contact',
			'foreignKey' => 'contact_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'InviteList' => array(
			'className' => 'InviteList',
			'foreignKey' => 'invite_list_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
