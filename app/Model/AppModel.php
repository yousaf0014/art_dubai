<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {

/**
* Set recursive to -1
*
*
* @var integer
*/

	public $recursive = -1;	
/**
 *
 * called before saving a record
 *
 * @param array $options
 * @return boolean true Success
 */
	public function beforeSave($options = array()) {
		$userID = !empty($_SESSION['Auth']['User']['id']) ? $_SESSION['Auth']['User']['id'] : null;
		$primar_key = $this->id;
		if(isset($this->data[$this->name]['id']) && empty($primar_key)){
			$primar_key = $this->data[$this->name]['id']; 
		}
		
		if (isset($this->_schema['uuid']) && empty($primar_key)){
			$this->data[$this->name]['uuid'] = String::uuid();
		}

		if (isset($this->_schema['created_by']) && empty($primar_key) && !empty($userID) ){
			$this->data[$this->name]['created_by'] = $userID;
		}
		
		if ( isset($this->_schema['updated_by']) && !empty($userID) ){
			$this->data[$this->name]['updated_by'] = $userID;
		}
		return true;
	}

/**
 *
 * get ID of a record by uuid
 *
 * @param String $uuid, uuid of the record
 * @return String id of the record
 */

	public function getIdByUuid($uuid){
		$recursion = $this->recursive;
		$this->recursive = -1;
		$id = $this->field('id',"uuid = '$uuid'");
		$this->recursive = $recursion;
		
		return $id;
	}
}
