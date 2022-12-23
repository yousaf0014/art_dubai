<?php

class InvitesController extends AppController {

	//name of controller
	public $name = 'Invites';

	/**
	* Include Components
	*
	* @var array
	*/

	public $components = array('FairManagement','RequestHandler');

	public $helpers = array('BarCode');

	//before filter
	public function beforeFilter() {
		parent::beforeFilter();
		$this->set('title_for_layout','Invitation Management - Art Dubai');
	}

	//add a new invite list
	public function addList() {
		$uuid = isset($this->request->query['ID']) ? $this->request->query['ID'] : null;
		$cat_uuid = isset($this->request->query['CATID']) ? $this->request->query['CATID'] : null;
		if($this->request->is('post') && !empty($this->request->data)) {
			$this->FairManagement->save('InviteList',$this->request->data['InviteList'],array('uuid' => $uuid));
			if(!empty($this->request->data['redirect'])) {
				$this->redirect($this->request->data['redirect']);
				exit;
			}
			$this->redirect('/invites/lists');
			exit;
		}

		$invite_categories = $fairs = array();
		if(empty($uuid)) {
			$invite_categories = $this->FairManagement->getList('InviteCategory',array(
				'conditions' => array('active' => '1')
			));
			$fairs = $this->FairManagement->getList('Fair',array(
				'conditions' => array('active' => '1')
			));
		}
		$catID = null;
		if(!empty($cat_uuid)) {
			$catID = $this->FairManagement->getIDByUUID('InviteCategory',$cat_uuid);
		}
		$this->set(compact('invite_categories','cat_uuid','catID','fairs'));
	}

	//paginate invite lists
	public function lists($cat_uuid = null) {
		$conditions = array();
		if(!empty($cat_uuid)) {
			$catID = $this->FairManagement->getIDByUUID('InviteCategory', $cat_uuid);
			$conditions['invite_category_id'] = $catID;
		}
		
		$request = array();
		if(!empty($this->request->query)) {
			$request = $this->request->query;
		}elseif(!empty($this->request->params['named'])){
			$request = $this->request->params['named'];
		}
		$conditions += $this->FairManagement->buildInviteListConditions($request);
		$lists = $this->FairManagement->paginateRecords('InviteList',array(
			'contain' => array(
				'InviteCategory' => array('fields' => array('id','name')),
				'User' => array('fields' => array('id','first_name','last_name')),
				'Fair' => array('fields' => array('id','name'))
			),
			'conditions' => $conditions
		));
		
		foreach($lists as $index => $list) {
			$lists[$index]['contactsCount'] = $this->FairManagement->getCount('ContactsInviteList',array(
				'conditions' => array(
					'ContactsInviteList.invite_list_id' => $list['InviteList']['id'],
					'ContactsInviteList.active' => '1',
					'Contact.id IS NOT NULL',
					'Contact.active' => '1'
				),
				'contain' => array('Contact')
			));
		}
		$fair_cats = $this->FairManagement->getList('FairCategory',array(
			'conditions' => array('active' => '1')
		));
		$fairs = $this->FairManagement->getList('Fair',array(
			'conditions' => array('active' => '1')
		));
		$this->set(compact('lists','cat_uuid','fair_cats','fairs'));
	}

	//edit a invite list
	public function editList() {
		$uuid = isset($this->request->query['ID']) ? $this->request->query['ID'] : null;
		if(empty($uuid)) {
			$this->redirect($this->referer());
			exit;
		}
		$this->request->data = $this->FairManagement->getRecords('InviteList',array('uuid' => $uuid));
		$this->render('addList');
	}

	//make a invite list inactive
	public function deleteList() {
		$uuid = isset($this->request->query['ID']) ? $this->request->query['ID'] : null;
		$this->FairManagement->makeInactive('InviteList',array('uuid' => $uuid));
		$this->redirect($this->referer());
		exit;
	}
	public function createList() {
		if($this->request->is('ajax')) {
			$this->layout = 'ajax';
		}
		if($this->request->is('post') && !empty($this->request->data)) {
			$query = $this->request->query;
			$conditions = $this->FairManagement->buildContactsSearchConditions($query);
			$contacts = $this->FairManagement->getList('Contact',array(
					'conditions' => $conditions,
					'fields' => array('id','id')
				)
			);
			$data = $this->request->data['InviteList'];
			if(!empty($data['name']) && !empty($data['fair_id']) ) {
				$invite_list_id = $this->FairManagement->save('InviteList',$data);
			}elseif (!empty($data['id'])) {
				$invite_list_id = $data['id'];
			}
			if(!empty($invite_list_id) && !empty($contacts)) {
				foreach($contacts as $key => $contact_id) {
					$this->FairManagement->addContactToInviteList($contact_id,$invite_list_id);
				}
			}
			if($this->request->is('ajax')) {
				$this->response->type('json');
				echo '1';
				return $this->response;
			}

		}
		$categories = $this->FairManagement->getRecords('InviteCategory',array(
			'active' => '1',
			'fields' => array('id','name'),
			'contain' => array('InviteList' => array(
				'fields' => array('id','name')
			))
		));
		$invite_lists = $this->FairManagement->getList('InviteList',
			array(
				'conditions' => array('active' => '1'),
				'fields' => array('id','name')
			)
		);
		
		$fairs = $this->FairManagement->getList('Fair',array(
			'conditions' => array('active' => '1')
		));
		$optGroups = $invite_lists;
		/*foreach($categories as $invite_category) {
			if(!empty($invite_category['InviteList'])){
				$cat_id = $invite_category['InviteCategory']['id'];
				$cat_name = $invite_category['InviteCategory']['name'];
				foreach($invite_category['InviteList'] as $invite_list) {
					$list_name = $invite_list['name'];
					$list_id = $invite_list['id'];
					
					if(isset($optGroups[$cat_id.' '.$cat_name])) {
						$optGroups[$cat_id.' '.$cat_name] += array($list_id => $list_name);
					}else{
						$optGroups[$cat_id.' '.$cat_name] = array($list_id => $list_name);
					}
				}
			}
		}*/
		$invite_categories = $this->FairManagement->getList('InviteCategory',array(
			'conditions' => array('active' => '1'),
			'fields' => array('id','name')
		));
		$this->set(compact('invite_lists','optGroups','invite_categories','fairs'));
	}

	public function index() {
		$list_id = isset($this->request->query['list_id']) ? $this->request->query['list_id'] : null;
		$is_search_init = isset($this->request->query['is_search_init']) ? $this->request->query['is_search_init'] : null;
		$search_in_contacts = isset($this->request->query['search_in_contacts']) ? $this->request->query['search_in_contacts'] : null;
		$conditions = array('ContactsInviteList.active' => '1');
		$invite_list = array();
		if(!empty($list_id)) {
			$conditions['ContactsInviteList.invite_list_id'] = $this->FairManagement->getIDByUUID('InviteList',$list_id);
			$invite_list = $this->FairManagement->getRecords('InviteList',array(
					'InviteList.uuid' => $list_id,
					'contain' => array('Fair')
				)
			);
		}

		$model = 'ContactsInviteList';
		$contain = array('Contact','InviteList');
		if($is_search_init && $search_in_contacts) {
			$model = 'Contact';
			$conditions = array();
			$contain = array();
		}
		$request_data = array();
		if(!empty($this->request->query)) {
			$request_data = $this->request->query;
		}elseif(!empty($this->request->params['named'])){
			$request_data = $this->request->params['named'];
		}

		if(!empty($request_data['list_actions'])) {
			foreach($request_data['list_actions'] as $key => $value) {
				$conditions['ContactsInviteList.'.$value] = '1';
			}
		}
		//build search conditions
		$conditions += $this->FairManagement->buildContactsSearchConditions($request_data);
		
		$contacts = $this->FairManagement->paginateRecords($model,array(
			'conditions' => $conditions,
			'contain' => $contain,
			'order' => $model.'.created DESC'
		));
		$listOpt = array(
			'fields' => array('id','name'),
			'conditions' => array('active' => '1')
		);
		$fairCategories = $this->FairManagement->getList('FairCategory',$listOpt);
		$fairsByYear = $this->FairManagement->getList('Fair',$listOpt);
		$countries = $this->FairManagement->getList('Country',array(
			'conditions' => array('active' => '1'),
			'fields' => array('iso','nicename')
		));
		$charCategories = $this->FairManagement->getList('ContactCategory',array(
			'conditions' => array('active' => '1')
		));

		$contactCharacteristics = $this->FairManagement->getRecords('ContactCharacteristic',array(
			'fields' => array('id','name','contact_category_id'),
		));
		$contactChars = array();
		foreach ($contactCharacteristics as $characteristic) {
			$id = $characteristic['ContactCharacteristic']['id'];
			$name = $characteristic['ContactCharacteristic']['name'];
			$cat_id = $characteristic['ContactCharacteristic']['contact_category_id'];
			$cat_name = $charCategories[$cat_id];
			if(isset($contactChars[$cat_id.' '.$cat_name])) {
				$contactChars[$cat_id.' '.$cat_name] += array($id => $name);
			}else{
				$contactChars[$cat_id.' '.$cat_name] = array($id => $name);
			}
		}
		$this->set(compact('contacts','fairCategories','fairsByYear','countries','contactChars','request_data','invite_list'));
	}

	public function logValue() {
		$values = array('invited' => 'invited', 'printed' => 'printed', 'attended' => 'attended', 'sms' => 'sms');
		$log_values = array('0' => '0', '1' => '1');
		$action = $this->request->query['action'];
		$log = $this->request->query['value'];
		$id = $this->request->query['id'];
		if(isset($values[$action]) && isset($log_values[$log]) && !empty($id)) {
			$data['id'] = $id;
			$data[$action] = $log;
			$is_exists = $this->FairManagement->getCount('ContactsInviteList',array(
				'conditions' => array('id' => $id)
			));
			if($is_exists) {
				$this->FairManagement->save('ContactsInviteList',$data);
				echo '1';
			}else{
				echo '0';
			}
		}
		return $this->response;
	}

	public function removeContact() {
		$id = $this->request->query['ID'];
		$this->FairManagement->makeInactive('ContactsInviteList',array('id' => $id));
		$this->redirect($this->referer());
		exit;
	}

	public function addContactToInviteList(){
		$list_uuid = $this->request->query['list_uuid'];
		$contact_uuid = $this->request->query['contact_uuid'];

		$contact_id = $this->FairManagement->getIDByUUID('Contact',$contact_uuid);
		$list_id = $this->FairManagement->getIDByUUID('InviteList',$list_uuid);

		$this->FairManagement->addContactToInviteList($contact_id,$list_id);
		echo '1';
		return $this->response;
	}

	public function sendSms() {
		$cil_id = $this->request->query['cil_id'];
		if(!empty($this->request->data)) {
			$this->FairManagement->save('ContactsInviteList',array('sms' => '1'),array('id' => $cil_id));
			return $this->response;
		}
		$templates = $this->FairManagement->getList('Template',array(
			'active' => '1',
			'type' => '1', //1 for sms
			'fields' => array('id','title')
		));
		$this->set(compact('cil_id','templates'));
	}
	public function getTemplate() {
		$tmpl_id = $this->request->query['tmpl_id'];
		$template = $this->FairManagement->getRecords('Template',array('id' => $tmpl_id));
		echo json_encode($template);
		exit;
	}
	//print invite list
	public function printInviteList() {
		$list_uuid = $this->request->query['list_id'];
		$list_id = $this->FairManagement->getIDByUUID('InviteList',$list_uuid);
		$contacts = $this->FairManagement->getRecords('ContactsInviteList',array(
			'ContactsInviteList.invite_list_id' => $list_id,
			'ContactsInviteList.active' => '1',
			'Contact.active' => '1',
			'contain' => array('Contact')
		));
		$this->set(compact('contacts'));
	}
	public function printListContact() {
		$contact_uuid = $this->request->query['CONID'];
		$clist_id = $this->request->query['clist_id'];
		if(!empty($clist_id)) {
			$this->FairManagement->save('ContactsInviteList',array('printed' => '1'),array('id' => $clist_id));	
		}
		$contact = $this->FairManagement->getRecords('Contact',array(
			'uuid' => $contact_uuid
		));
		$this->set(compact('contact'));
	}
	public function bulkAction($action = '',$save = '') {
		if(empty($action)) {
			return false;
		}
		if($action == 'delete') {
			$contact_uuids = $this->request->data['contact_uuids'];
			foreach ($contact_uuids as $key => $value) {
				$this->FairManagement->makeInactive('Contact',array('uuid' => $value));
			}
			return $this->response;
		}elseif( $save && ($action == 'sms' || $action == 'send_invitation') ) {
			$contact_uuids = $this->request->data['contact_uuids'];
			$subject = $this->request->data['Template']['subject'];
			$contents = $this->request->data['Template']['contents'];
			$footer = $this->request->data['Template']['footer'];
			set_time_limit(0);
			foreach ($contact_uuids as $key => $value) {
				if($action == 'send_invitation') {
					$this->sendInvitation($action,$value,$subject,$contents,$footer);
				}elseif($action == 'sms') {
					$this->sendSMSMessage($action,$value,$subject,$contents,$footer);
				}
			}
			exit;
			return $this->response;
		}elseif($action == 'list_delete') {
			
			return $this->response;
		}
		
		if($action == 'send_invitation') {
			$templates = $this->FairManagement->getList('Template',array(
				'conditions' => array('active' => '1','type' => '2'),
				'fields' => array('uuid','title')
			));
		}elseif($action == 'sms') {
			$templates = $this->FairManagement->getList('Template',array(
				'conditions' => array('active' => '1','type' => '1'),
				'fields' => array('uuid','title')
			));
		}

		$this->set(compact('templates','action'));
	}

	public function sendInvitation($action,$contact_uuid,$subject,$contents,$footer = '') {
		$contact = $this->FairManagement->getRecords('Contact',array(
			'uuid' => $contact_uuid,
			'fields' => array('id','uuid','email','first_name','last_name','invite_category_id','bar_code')
		));
		
		$email = isset($contact['Contact']['email']) ? $contact['Contact']['email'] : null;

		if($action == 'send_invitation') {
			
			$options['template'] = 'e_invite';
			App::uses('BarCodeHelper','View/Helper');
			$barCodeObj = new BarCodeHelper(new View());
			
			if(!file_exists(Router::url('/',true).'img/barcode/barcode_'.$contact['Contact']['uuid'].'.png')) {

				$barCodeObj->barcode();
				$barCodeObj->setType('C128');
				$barCodeObj->setCode($contact['Contact']['bar_code']);
				$barCodeObj->setSize(80,200);
				$barCodeObj->hideCodeType('C128');

				$file = 'img/barcode/barcode_'.$contact['Contact']['uuid'].'.png';

				$barCodeObj->writeBarcodeFile($file);

			}

			$options['attachments'] = array(
				'barcode.png' => array(
					'file' => WWW_ROOT.DS.'img/barcode/barcode_'.$contact['Contact']['uuid'].'.png',
					'mimetype' => 'img/png',
					'contentId' => 'barcode'
				)
			);
			$options['viewVars'] = array('contents' => $contents,'footer' => $footer);
			if($this->FairManagement->sendEmail($email,$subject,$options)) {

			}
		}
	}
	public function sendSMSMessage($action,$contact_uuid,$subject,$contents,$footer = '') {

	}
	public function deleteFromList() {
		$contact_list_ids = isset($this->request->data['contact_uuids']) ? $this->request->data['contact_uuids'] : array();
		foreach ($contact_list_ids as $key => $value) {
			$this->FairManagement->makeInactive('ContactsInviteList',array('id' => $value));
		}

		return $this->response;
	}
}