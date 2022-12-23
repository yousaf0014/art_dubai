<?php
/**
 * Users Controller
 *
 * Users Controller contain the logic for authentication and authorization
 *
 * PHP 5
 *
 * @copyright     Copyright (c) Dotme Tech FZ LLC. (http://dotmetech.com/)
 * @package       app.Controller
 * @author        abubakr haider
 */

App::uses('AppController','Controller');

class FlagController extends AppController{

/**
 * Controller name.
 *
 * @var string
*/
	public $name = 'Flag';

/**
 * Include Components
 *
 * @var array
 */
	public $components = array('RequestHandler','FairManagement');

/**
 * Called before the controller action. used to perform logic that needs to 
 * happen before each controller action.
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		//$this->Auth->allow('login','logout','notAuthorized','admin_notAuthorized');
		$this->set('title_for_layout','Art Dubai');
	}

	//login function
	public function flags() {
		$flag = $this->FairManagement->getRecords('Flag');
		$this->set(compact('flag'));
	}
	public function addFlag() { 
		$uuid = isset($this->request->query['FID']) ? $this->request->query['FID'] : '';
		if($this->request->is('post') && !empty($this->request->data)) {
		
			$this->FairManagement->save('Flag',$this->request->data['Flag'],array('uuid' => $uuid));
			$this->redirect('/flag/flags');
			exit;
		}
		$flag = array();
		//echo $uuid; die;
		if(!empty($uuid)) {
			$flag = $this->FairManagement->getRecords('Flag',array('uuid' => $uuid));
		}
		$this->set(compact('flag','uuid'));
	}

	public function deleteFlag() {
		$uuid = $this->request->query['FID'];
		$this->FairManagement->makeInactive('Flag',array('uuid' => $uuid));

		$this->redirect($this->referer());
		exit;
	}
	public function view() {
		$flag = $this->FairManagement->getRecords('Flag');
		$options['ContactFlag.contact_id'] = $_REQUEST['contact_id'];
		$options['contain'] = array(
			'Flag' => array('fields' => array('color','title')),
			'User'=>array('fields' => array('first_name','last_name')
		));
		$options['ContactFlag.created_by'] = $this->userID;
		$options['ContactFlag.active'] = '0';
		
		$contactFlag = $this->FairManagement->getRecords('ContactFlag',$options);
		
		$this->set(compact('flag','contactFlag'));
	}
	public function addContactFlag($flag_id,$contact_id) {
		App::uses('ContactFlag', 'Model');
		$ContactFlagObj = new ContactFlag();

		$options = array('contact_id' => $contact_id);
		$flagRec = $this->FairManagement->getRecords('ContactFlag',$options);
		$ContactFlagObj->updateAll(
			array('active' => '0'),
			array('contact_id' => $contact_id)		
		);
		$data['contact_id'] = $contact_id;
		$data['flag_id'] = $flag_id;
		$data['created_by'] = $this->userID;
		$this->FairManagement->save('ContactFlag',$data);			
		exit;
	}
}