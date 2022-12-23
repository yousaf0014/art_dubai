<?php

App::uses('AppModel', 'Model');


class Notes extends AppModel{
	public $name = 'Notes';
	public $actsAs = array('Containable');
	public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'created_by'
        )
    );
}