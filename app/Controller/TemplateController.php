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

class TemplateController extends AppController{

/**
 * Controller name.
 *
 * @var string
*/
	public $name = 'Template';

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
		$this->set('title_for_layout',SITE_NAME);
	}

	public function view() {
		//echo '<pre>'; print_r($_SESSION); echo '</pre>';
		$Template = $this->FairManagement->paginateRecords('Template');
		$this->set(compact('Template'));
	}
	public function addTemplate() { 
		$uuid = isset($this->request->query['UID']) ? $this->request->query['UID'] : '';
		if($this->request->is('post') && !empty($this->request->data)) {
			//print_r($this->request->data['Template']); die;
			$this->FairManagement->save('Template',$this->request->data['Template'],array('uuid' => $uuid));
			$this->redirect('/template/view');
			exit;
		}
		$TemplateData = array();
		if(!empty($uuid)) {
			$TemplateData = $this->FairManagement->getRecords('Template',array('uuid' => $uuid));
		}
		$this->set(compact('TemplateData','uuid'));
	}

	public function deleteTemplate() {
		$uuid = $this->request->query['UID'];
		$this->FairManagement->makeInactive('Template',array('uuid' => $uuid));
		$this->redirect($this->referer());
		exit;
	}
	public function getTemplate() {
		$template_uuid = isset($this->request->query['template_id']) ? $this->request->query['template_id'] : null;

		$template = $this->FairManagement->getRecords('Template',array(
			'uuid' => $template_uuid
		));

		echo json_encode($template);

		return $this->response;
	}
}