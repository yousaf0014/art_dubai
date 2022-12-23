<?php
/**
 * User Model
 *
 * @copyright     Copyright (c) Dotme Tech FZ LLC. (http://dotmetech.com/)
 * @package       app.Model
 * @author        abubakr haider
 *
 */

App::uses('AppModel', 'Model');

class User extends AppModel{

/**
 *
 * name of the model
 *
 */
	public $name = 'User';

/**
 * Define belongsTo Relationship
 *
 * @var array
 */
    
    public $belongsTo = array(
        'Role' =>
            array(
                'className' => 'Role',
                'foreignKey' => 'role_id'
            )
    );


/**
 *
 * Attach beaviors to the model
 *
 */
	public $actsAs = array('Containable');

    public function afterSave($created, $options = array()) {
        App::uses('Aro','Model');
        $arObj = new Aro();
        if (isset($this->data['User']['role_id'])) {
            $role_id = $this->data['User']['role_id'];
        } else {
            $role_id = $this->field('role_id');
        }
        if(!empty($role_id)) {
            $role = array('Role' => array(
                'id' => $role_id
            ));
            $parent_node = $arObj->node($role);
        }
        $parent_id = isset($parent_node[0]['Aro']['id']) ? $parent_node[0]['Aro']['id'] : null;
        if($created) {
            $arObj->create();
            $arObj->save(array(
                'model' => 'User',
                'parent_id' => $parent_id,
                'foreign_key' => $this->id,
            ));
        }else{
            $user = array(
                'User' => array('id' => $this->id)
            );
            $node = $arObj->node($user);
            $node_id = isset($node[0]['Aro']['id']) ? $node[0]['Aro']['id'] : null;
            $arObj->create();
            $arObj->save(array(
                'id' => $node_id,
                'model' => 'User',
                'parent_id' => $parent_id,
                'foreign_key' => $this->id
            ));
        }

    }

}