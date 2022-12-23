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

class NotesController extends AppController{

/**
 * Controller name.
 *
 * @var string
*/
	public $name = 'Notes';

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
		$this->set('title_for_layout','Art Dubai');
	}
	public function view() {

		$options['Notes.created_by'] = $_SESSION['Auth']['User']['id'];
		$options['Notes.contact_id'] = $contact_id = $this->request->query['contact_id'];
		$options['contain'] = array('User'=>array('fields' => array('first_name','last_name')));
		$notes = $this->FairManagement->getRecords('Notes',$options);
		$this->set(compact('notes','contact_id'));
	}
	public function addNotes() {
		$contact_id = isset($this->request->query['contact_id']) ? $this->request->query['contact_id'] : '';
		$uuid = isset($this->request->query['NID']) ? $this->request->query['NID'] : '';
		if($this->request->is('post') && !empty($this->request->data)) {
			$this->request->data['Notes']['created_by'] = $_SESSION['Auth']['User']['id'];
			$this->FairManagement->save('Notes',$this->request->data['Notes'],array('uuid' => $uuid));
			if($this->request->is('ajax')) {
				return $this->response;
			}
			$this->redirect($this->referer());
			exit;
		}
		$notes = array();
		if(!empty($uuid)) {
			$notes = $this->FairManagement->getRecords('Notes',array('uuid' => $uuid));
			//print_r($notes);
		}
		$this->set(compact('notes','uuid','contact_id'));
	}

	public function deleteNotes() {
		$uuid = $this->request->query['NID'];
		$this->FairManagement->makeInactive('Notes',array('uuid' => $uuid));
		$this->redirect($this->referer());
		exit;
	}
	
	
}