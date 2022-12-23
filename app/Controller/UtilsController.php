<?php
/**
 * Fairs Management Controller
 *
 * Fairs management controller class contains bussiness logic for
 * event mangemnet module.
 *
 * PHP 5
 *
 * @copyright     Copyright (c) Dotme Tech FZ LLC. (http://dotmetech.com/)
 * @package       app.Controller
 * @author        abubakr haider
 */

App::uses('AppController','Controller');

class UtilsController extends AppController{

/**
 * Controller name.
 *
 * @var string
*/
	public $name = 'Utils';

/**
 * Include Components
 *
 * @var array
 */
	public $components = array('FairManagement','RequestHandler','Util');

/**
 * Include Helpers
 *
 * @var array
 */

	public $helpers = array('PhpExcel');

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
	public function exportContactsPopup(){
		$columns = $this->FairManagement->initModel('Contact')->getColumnTypes();
		$this->set(compact('columns'));
	}
	//function to export contacts
	public function exportContacts() {
		$this->layout = null;
		$request_data = array();
		if(!empty($this->request->query)) {
			$request_data = $this->request->query;
		}elseif(!empty($this->request->params['named'])){
			$request_data = $this->request->params['named'];
		}
		$contacts = array();
		if(!empty($this->request->data['Fields'])){
			$options = $this->FairManagement->buildContactsSearchConditions($request_data);
			$options['fields'] = $this->request->data['Fields'];
			$options['contain'] = array(
				'Country',
				'Fair',
				'CreatedBy' => array('id','first_name','last_name'),
				'UpdatedBy' => array('id','first_name','last_name'),
				'ContactCharacteristic' => array(
					'fields' => array('id','name'),
					'conditions' => array('ContactCharacteristic.active' => '1')
				)
			);
			$contacts = $this->FairManagement->getRecords('Contact',$options);
		}
		$fields = $this->request->data['Fields'];
		$this->set(compact('contacts','fields'));
	}

	public function importContacts() {
		App::uses('Uploader','Uploader.Vendor');
		$uploaderObj = new Uploader();
		$uploaderObj->uploadDir = 'files/tmp/';
		$file = $this->request->data['import'];
		$data = $uploaderObj->upload($file);
		if($data){
			$this->Session->write('contacts_file',$data);
		}else{
			echo 'error';
		}
		exit;
	}

	public function findDuplicates() {
		$file = $this->Session->read('contacts_file');
		$filePath = WWW_ROOT.DS.$file['path'];
		
		$records = $this->Util->readFile($filePath);
		if(empty($records)) {
			return false;
		}
		App::uses('Contact','Model');
		$contactObj = new Contact();
		$fieldsToCheck = $contactObj->getFieldstoCheckForDuplicates();
		$validateOptions = array('fields' => $fieldsToCheck);
		$duplicates = array();
		foreach($records as $index => $record) {
			if($index == 0) {
				continue;
			}
			$data = $this->Util->identifyFields($record);
			$duplicateRecords = $this->FairManagement->validateRecord('Contact',$data,$validateOptions);
			if(!empty($duplicateRecords)) {
				$duplicates[] = array('Contact' => $data,'duplicateRecords' => $duplicateRecords);
			}
		}
		$fairCats = $this->FairManagement->getList('FairCategory',array(
				'conditions' => array('active' => '1')
			));
		$fairs = $this->FairManagement->getList('Fair',array(
				'conditions' => array('active' => '1')
			));
		$this->set(compact('duplicates','fairCats','fairs'));
	}
	public function importRecoreds() {
		$file = $this->Session->read('contacts_file');
		$filePath = WWW_ROOT.DS.$file['path'];
		
		$records = $this->Util->readFile($filePath);
		if(!empty($this->request->data)) {
			foreach ($records as $key => $value) {
				if($key == 0){
					continue;
				}
				$data = $this->Util->identifyFields($value);
				$data['fair_id'] = $fairID = $this->request->data['Contact']['fair_id'];
				$data['fair_category_id'] = $this->request->data['Contact']['fair_category_id'];
				$data['shared'] = isset($this->request->data['Contact']['shared']) ? '1' : '0';
				$data['registration_method'] = 'import';
				$data['bar_code'] = generate_bar_code();
				if(empty($data['first_name']) || empty($data['last_name']) || empty($data['city']) || empty($data['email'])) {
					continue;
				}

				if(isset($this->request->data['Contact']['ignore'][$key])) {
					continue;
				}
				elseif(isset($this->request->data['Contact']['overwrite'][$key]))
				{
					foreach($this->request->data['Contact']['overwrite'][$key] as $index => $uuid ) {
						$contactID = $this->FairManagement->save('Contact',$data,array('uuid' => $uuid));
						$this->FairManagement->mapContactToFair($contactID,$fairID);
					}
				}
				else
				{
					$contactID = $this->FairManagement->save('Contact',$data);
					$this->FairManagement->mapContactToFair($contactID,$fairID);
				}
			}
			$file = $this->Session->read('contacts_file');
			$this->Session->delete('contacts_file');
			$file_path = WWW_ROOT.$file['path'];
			if(file_exists($file_path)) {
				unlink($file_path);
			}
		}
		$this->redirect('/fairs/contacts');
		exit;
	}
	
	public function contactsImportSample() {
		$countries = $this->FairManagement->getList('Country',array(
			'conditions' => array('active' => '1'),
			'fields' => array('iso','nicename')
		));

		
		$fields = $this->Util->getFieldsOrder();
		$this->set(compact('countries','fields'));
	}

	public function printContacts() {
		$this->layout = 'print';
		$catID = isset($this->request->query['CID']) ? $this->request->query['CID'] : '';
		$fID = isset($this->request->query['FID']) ? $this->request->query['FID'] : '';
		$contacts = $fair = $fairCategories = $fairsByYear = array();

		$conditions = array('Contact.active' => '1');
		if($this->request->is('post') && !empty($this->request->data)) {
			$request_data = $this->request->data;
			if(!empty($request_data['fair_category_id'])){
				$conditions['fair_category_id'] = $request_data['fair_category_id'];
			}
			if(!empty($request_data['name'])) {
				$conditions[] = "(Contact.first_name LIKE '%{$request_data['name']}%' OR Contact.last_name LIKE '%{$request_data['name']}%')";
			}
			if(!empty($request_data['mobile'])) {
				$conditions[] = "(Contact.mobile LIKE '%{$request_data['mobile']}%' OR Contact.phone LIKE '%{$request_data['mobile']}%')";
			}
			if(!empty($request_data['shared'])) {
				$conditions['Contact.shared'] = '1';
			}
			if(!empty($request_data['fair_id'])) {
				$conditions['Contact.id'] = $this->FairManagement->getList('ContactsFair',array(
												'conditions' => array('ContactsFair.fair_id' => $request_data['fair_id']),
												'fields' => array('contact_id','contact_id')
											));
			}
		}
		$optList = array(
			'conditions' => $conditions,
			'contain' => array('Fair','Country'),
			'recursive' => '1'
		);
		
		$contacts = $this->FairManagement->paginateRecords('Contact',$optList);

		$this->set(compact('catID','fair','contacts'));
	}

	public function exportCompanies() {
		$this->layout = null;
		$options['contain'] = array('Country');
		$companies = $this->FairManagement->getRecords('Company',$options);
		$this->set(compact('companies'));
	}

	public function exportInventory() {

		//This function list all the categories
		
		//Get list of categories, fairs, events and employees...
		$itemCategories = $this->FairManagement->getRecords('ItemCategory');
		$Fairs = $this->FairManagement->getRecords('Fair');
		$Events = $this->FairManagement->getRecords('FairEvent');
		$Employees = $this->FairManagement->getRecords('Employee');		
		
		$this->set( compact( 'itemCategories','Fairs','Events','Employees') );		
		
		//setting conditions		
		$conditions = array("InventoryOutItem.active"=> '1');
		
		$item_category_id = empty($this->request->data['InventoryOutItem']['item_category_id']) ? '' : $this->request->data['InventoryOutItem']['item_category_id'];
				
		//$chk_type = empty( $_GET['InventoryOut']['type'] ) ? '' : $_GET['InventoryOut']['type'];
		$fair_id = empty( $_GET['fair_id'] ) ? '' : $_GET['fair_id'];
		$event_id = empty( $_GET['event_id'] ) ? '' : $_GET['event_id'];
		$assign_to_id = empty( $_GET['assign_to_id'] ) ? '' : $_GET['assign_to_id'];
		$item_less = empty( $_GET['item_less'] ) ? '' : $_GET['item_less'];
				
		if( !empty( $item_category_id ))
		{
			$category = array("InventoryOutItem.item_category_id" => $item_category_id );
			$conditions = array_merge($conditions,$category);
		}
			
		if( !empty( $fair_id ) )
		{
			$type = array(							
							"InventoryOut.fair_id" => $fair_id
						  );
			$conditions = array_merge($conditions,$type);
		}
		
		if( !empty( $event_id ) )
		{
			$type = array(							
							"InventoryOut.event_id" => $event_id 
						  );
			 $conditions = array_merge($conditions,$type);
		}			
		
		
		if( !empty( $assign_to_id ))
		{
			$assign_to = array("InventoryOutItem.assign_to_id" => $assign_to_id );
			$conditions = array_merge($conditions,$assign_to);
		}
		
		if( !empty( $item_less ))
		{
			if( $item_less == '1' )
			{
				$qty = array('InventoryOutItem.qty_in < InventoryOutItem.qty_out' );
				$conditions = array_merge($conditions,$qty);
			}
			else
			{
				$qty = array('InventoryOutItem.qty_in > InventoryOutItem.qty_out' );
				$conditions = array_merge($conditions,$qty);
			}
		}
				
		//end setting conditions	
		

		App::import('Model','InventoryOutItem');
		$inventoryObj = new InventoryOutItem();
		$this->paginate = array(
							'conditions'=> $conditions,
							'recursive'=>'2',
							'limit' => 20,
							'order' => array('name' => 'asc')
						);
			
		
		$Items =$this->paginate( $inventoryObj );
		$this->set(compact('Items','item_category_id','chk_type','fair_id','event_id','assign_to_id','item_less'));


	}

	public function exportContactsList() {
		$list_id = isset($this->request->query['list_id']) ? $this->request->query['list_id'] : null;
		$conditions = array('ContactsInviteList.active' => '1');
		if(!empty($list_id)) {
			$conditions['ContactsInviteList.invite_list_id'] = $this->FairManagement->getIDByUUID('InviteList',$list_id);
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
		$contacts = $this->FairManagement->paginateRecords('ContactsInviteList',array(
			'conditions' => $conditions,
			'contain' => array('Contact','InviteList'),
			'order' => 'ContactsInviteList.created DESC'
		));
		$this->set(compact('contacts'));
	}

	public function selectViewFields($model = '') {
		if(!empty($model)) {
			$columns = $this->FairManagement->initModel((string)$model)->getColumnTypes();
			$selected = $this->FairManagement->getList('ModelField',array(
				'conditions' => array('model' => $model),
				'fields' => array('field','field')
			));
			$this->set(compact('columns','model','selected'));
		}
		if(!empty($this->request->data['Fields'])) {
			$this->FairManagement->initModel('ModelField')->deleteAll(array('model' => $model));
			foreach ($this->request->data['Fields'] as $key => $value) {
				$temp = array();
				$temp['model'] = $model;
				$temp['field'] = $value;
				$this->FairManagement->save('ModelField',$temp);
			}
			$this->redirect('/utils/selectViewFields');
			exit;
		}
	}

	public function showInactiveContacts() {
		$request_data = array();
		if(!empty($this->request->query)) {
			$request_data = $this->request->query;
		}elseif(!empty($this->request->params['named'])){
			$request_data = $this->request->params['named'];
		}
		//build search conditions
		$conditions = $this->FairManagement->buildContactsSearchConditions($request_data);
		$conditions = $conditions + array('Contact.active <>' => '1');
		unset($conditions['Contact.active']);
		// debug($conditions); exit;
		$contacts = $this->FairManagement->paginateRecords('Contact',array(
			'conditions' => $conditions,
			// 'contain' => array('Contact')
		));
		$listOpt = array(
			'fields' => array('id','name'),
			'conditions' => array('active' => '1')
		);
		$fairCategories = $this->FairManagement->getList('FairCategory',$listOpt);
		$fairsByYear = $this->FairManagement->getList('Fair',$listOpt);
		$countries = $this->FairManagement->getCountriesByRegion();
		$this->set(compact('contacts','fairCategories','fairsByYear','countries'));
		$charCategories = $this->FairManagement->getRecords('ContactCategory',array(
			'active' => '1',
			'contain' => array('ContactCharacteristic')
		));
		$contactChars = array();
		foreach($charCategories as $charCategory) {
			if(!empty($charCategories['ContactCharacteristic'])){
				$cat_id = $invite_category['ContactCategory']['id'];
				$cat_name = $invite_category['ContactCategory']['name'];
				foreach($charCategory['ContactCharacteristic'] as $char) {
					$sub_name = $char['name'];
					$sub_id = $char['id'];
					
					if(isset($contactChars[$cat_id.' '.$sub_name])) {
						$contactChars[$cat_id.' '.$cat_name] += array($sub_id => $sub_name);
					}else{
						$contactChars[$cat_id.' '.$cat_name] = array($sub_id => $sub_name);
					}
				}
			}
		}
		$this->set(compact('contacts','fairsByYear','countries','contactChars','request_data'));
	}
	public function makeContactActive($contactUUID,$logID) {
		$this->FairManagement->makeActive('Contact',array('uuid' => $contactUUID));
		$this->redirect($this->referer());
		exit;
	}

	public function viewContactHistory() {
		$con_uuid = $this->request->query['CONID'];
		$con_id = $this->FairManagement->getIDByUUID('Contact',$con_uuid);
		$history = $this->FairManagement->paginateRecords('Log',array(
			'conditions' => array('Log.model' => 'Contact','Log.foreign_key' => $con_id),
			'order' => 'Log.created DESC',
			'contain' => 'User'
		));
		$this->set(compact('history'));
	}
	public function exportContactTypes() {
		$contact_types = $this->FairManagement->getRecords('ContactCategory');
		$this->set(compact('contact_types'));
	}
	public function exportItemCats() {
		$itemCategories = $this->FairManagement->getRecords('ItemCategory');
		$this->set(compact('itemCategories'));
	}
	public function exportContactCharacteristics() {
		$contactCharacteristics = $this->FairManagement->getRecords('ContactCharacteristic',array(
			'contain' =>  array('FairCategory','ContactCategory')
		));
		$this->set(compact('contactCharacteristics'));
	}
	public function importItemCats() {
		if(isset($this->request->query['readFile']) && $this->request->query['readFile'] == '1'){
			$file = $this->Session->read('item_cats_file');
			$filePath = WWW_ROOT.DS.$file['path'];
			
			$records = $this->Util->readFile($filePath);
			if(empty($records)) {
				return false;
			}
			foreach ($records as $key => $value) {
				if($key == 0) {
					continue;
				}
				$temp = array();
				$temp['name'] = $value[0];
				$temp['description'] = $value[1];
				$temp['active'] = '1';
				$this->FairManagement->save('ItemCategory',$temp);
			}
			$this->Session->setFlash('File imported successfully', 'happy');
			$this->redirect('/ItemCategories/index');
			exit;
		}else{
			App::uses('Uploader','Uploader.Vendor');
			$uploaderObj = new Uploader();
			$uploaderObj->uploadDir = 'files/tmp/';
			$file = $this->request->data['import'];
			$data = $uploaderObj->upload($file);
			if($data){
				$this->Session->write('item_cats_file',$data);
			}else{
				echo 'error';
			}
		}
		exit;
	}
	public function importContactCats() {
		if(isset($this->request->query['readFile']) && $this->request->query['readFile'] == '1'){
			$file = $this->Session->read('contact_cats_file');
			$filePath = WWW_ROOT.DS.$file['path'];
			
			$records = $this->Util->readFile($filePath);
			if(empty($records)) {
				return false;
			}
			foreach ($records as $key => $value) {
				if($key == 0) {
					continue;
				}
				$temp = array();
				$temp['name'] = $value[0];
				$temp['description'] = $value[1];
				$temp['active'] = '1';
				$this->FairManagement->save('ContactCategory',$temp);
			}
			$this->Session->setFlash('File imported successfully', 'happy');
			$this->redirect('/fairs/contactCategories');
			exit;
		}else{
			App::uses('Uploader','Uploader.Vendor');
			$uploaderObj = new Uploader();
			$uploaderObj->uploadDir = 'files/tmp/';
			$file = $this->request->data['import'];
			$data = $uploaderObj->upload($file);
			if($data){
				$this->Session->write('contact_cats_file',$data);
			}else{
				echo 'error';
			}
		}
		exit;
	}
}