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

class FairsController extends AppController{

/**
 * Controller name.
 *
 * @var string
*/
	public $name = 'Fairs';

/**
 * Include Components
 *
 * @var array
 */
	public $components = array('FairManagement','RequestHandler');

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

	public function index() {
		if($this->Session->read('Auth.User.role') == 'admin') {
			$this->redirect('/fairs/adminDashbord');	
		}
		$fairCategories = $this->FairManagement->paginateRecords('FairCategory',array(
			'conditions' => array('active' => '1')
		));
		$this->set(compact('fairCategories'));
	}

/**
 *
 * list fair categories
 *
 */

	public function listCategories(){
		$fairCategories = $this->FairManagement->getRecords('FairCategory');
		$contactsCategories = $this->FairManagement->getRecords('ContactCategory');
		$corporateCategories = $this->FairManagement->getRecords('CorporateCategory');
		$inviteCategories = $this->FairManagement->getRecords('InviteCategory');

		$this->set(compact('fairCategories','contactsCategories','corporateCategories','inviteCategories'));
	}

/**
 * Used to handle add/edit a fair(etc art dubai/down town) request.
 *
 * @return void
 */
	public function add(){
		$fID = isset($this->request->query['FID']) ? $this->request->query['FID'] : null;
		$fcID = $this->request->query['FCID'];
		if( $this->request->is('post') && !empty($this->request->data['Fair']) ) {
			$options['uuid'] = $fID;
			if($fairID = $this->FairManagement->save('Fair',$this->request->data['Fair'],$options)) {
				$fid = $this->FairManagement->getUUIDByID('Fair',$fairID);
				if(!empty($this->request->data['Fair']['import_contacts'])) {
					$this->redirect('/Fairs/importContacts?FCID='.$fcID.'&FID='.$fid);
				}
				$this->redirect('/Fairs/viewFairs?FCID='.$fcID);
			}
		}

		$startYear = date('Y');

		$fairCategories = $this->FairManagement->getRecords('FairCategory');

		$fair = array();
		if( !empty($fID) ){
			$options['uuid'] = $fID;
			$fair = $this->FairManagement->getRecords('Fair',$options);
		}
		$this->set(compact('fairTypes','startYear','fairCategories','fair','fID','fcID'));
	}

/**
 * delete a fair/event.
 *
 * @param string $uuid, uuid of fair/event
 * @return Boolean true on Success, false on failure
 */
	
	public function delete(){
		$fID = $this->request->query['FID'];
		$options = array('uuid' => $fID);
		$this->FairManagement->makeInactive('Fair',$options);

		$this->redirect($this->referer());
		exit;
	}

/**
 *
 * add a new fair category
 *
 * @return boolean true on success, false on error
 *
 */

	public function addCategory() {
		$catID = isset($this->request->query['FCID']) ? $this->request->query['FCID'] : '';
		if( !empty($this->request->data['FairCategory']) ) {
			$options['uuid'] = $catID;
			$this->FairManagement->save('FairCategory',$this->request->data['FairCategory'],$options);
			$this->redirect('/Fairs');
		}

		$options = array('uuid'=> $catID);
		$fairCat = $this->FairManagement->getRecords('FairCategory',$options);

		$this->set(compact('fairCat'));
	}

/**
 *
 * add a new fair category
 *
 * @return boolean true on success, false on error
 *
 */
	public function viewFairs(){
		$catUUID = $this->request->query['FCID'];

		$options = array('uuid' => $catUUID);
		$fairCat = $this->FairManagement->getRecords('FairCategory',$options);

		if( empty($fairCat) ){
			$this->redirect('/Fairs/listCategories');
			exit;
		}

		$options = array(
			'conditions' => array('fair_category_id' => $fairCat['FairCategory']['id'], 'active' => '1')
		);
		$fairs = $this->FairManagement->paginateRecords('Fair',$options);
		$counter = 1;
		
		$this->set(compact('fairs','counter','fairCat'));
	}

/**
 *
 * delete a fair category
 *
 * @return boolean true on success, false on error
 *
 */

	public function deleteCategory() {
		$this->layout = null;
		$catUUID = $this->request->query['FCID'];
		$options['uuid'] = $catUUID;
		$this->FairManagement->makeInactive('FairCategory',$options);

		$this->redirect($this->referer());
		exit;
	}

	public function events() {
		$fcID = $this->request->query['FCID'];
		$fID = $this->request->query['FID'];
		$fairID = $this->FairManagement->getIDByUUID('Fair',$fID);
		$options = array('fair_id' => $fairID);
		$events = $this->FairManagement->getRecords('FairEvent',$options);
		$counter = 1;
		$this->set(compact('fcID','events','counter','fID'));
	}

	public function addEvent(){
		$fcID = $this->request->query['FCID'];
		$fID = $this->request->query['FID'];
		$fairEventID = isset($this->request->query['FEID']) ? $this->request->query['FEID'] : '';

		App::uses('FairEvent','Model');
		$fairEventObj = new FairEvent();
		
		if( $this->request->is('post') && !empty($this->request->data) ){
			$options = array('uuid' => $fairEventID);
			
			if( empty($fairEventID) ){
				App::uses('Fair','Model');
				$fairObj = new Fair();
				$this->request->data['FairEvent']['fair_id'] = $fairObj->getIdByUuid($fID);
			}
			
			$this->FairManagement->save('FairEvent',$this->request->data['FairEvent'],$options);
			$this->redirect('/Fairs/events?FID='.$fID.'&FCID='.$fcID);
		}

		$event = array();
		if( !empty($fairEventID) ){
			$options['uuid'] = $fairEventID;
			$event = $this->FairManagement->getRecords('FairEvent',$options);
		}

		$eventTypes = $fairEventObj->getEventTypes();
		$this->set(compact('fcID','fID','eventTypes','fairEventID','event'));
	}

	public function deleteEvent(){
		$this->layout = null;
		$fcID = $this->request->query['FCID'];
		$fID = $this->request->query['FID'];
		$feID = $this->request->query['FEID'];
		$options['uuid'] = $feID;
		$this->FairManagement->makeInactive('FairEvent',$options);

		$this->redirect($this->referer());
		exit;	
	}
	
	public function contactCategories() {
		$contactsCategories = $this->FairManagement->paginateRecords('ContactCategory',array(
			'conditions' => array('active' => '1')
		));
		$this->set('contactsCategories',$contactsCategories);
	}

	public function addContactCategory() {
		$catID = isset($this->request->query['CCID']) ? $this->request->query['CCID'] : '';
		if( $this->request->is('post') && !empty($this->request->data) ) {
			$options['uuid'] = $catID;
			$this->FairManagement->save('ContactCategory',$this->request->data['ContactCategory'],$options);
			$this->redirect('/Fairs/contactCategories');
		}

		$options = array('uuid'=> $catID);
		$contactCat = $this->FairManagement->getRecords('ContactCategory',$options);

		$this->set(compact('contactCat'));
	}
	
	public function deleteContactCategory() {
		$this->layout = null;
		$catUUID = $this->request->query['CCID'];
		$options['uuid'] = $catUUID;
		$this->FairManagement->makeInactive('ContactCategory',$options);

		$this->redirect($this->referer());
		exit;
	}

	public function contactCharacteristics() {
		$cID = $this->request->query['CID'];
		$contactCCID = $this->FairManagement->getIDByUUID('ContactCategory',$cID);
		$options = array('contact_category_id' => $contactCCID);
		
		$options['contain'] = array(
			'FairCategory' => array(
				'fields' => array('id','name')
			)
		);

		$contactCharacteristics = $this->FairManagement->getRecords('ContactCharacteristic',$options);
		$counter = 1;

		$this->set(compact('cID','contactCharacteristics','counter'));
	}

	public function addContactCharacteristic() {
		$contactCharID = isset($this->request->query['CCID']) ? $this->request->query['CCID'] : '';
		$catID = $this->request->query['CID'];
		if( $this->request->is('post') && !empty($this->request->data) ) {
			$options['uuid'] = $contactCharID;
			$this->FairManagement->save('ContactCharacteristic',$this->request->data['ContactCharacteristic'],$options);
			$this->redirect('/Fairs/contactCharacteristics?CID='.$catID);
		}

		$options = array('uuid'=> $contactCharID);
		$contactChar = $this->FairManagement->getRecords('ContactCharacteristic',$options);
		$contactCats = $this->FairManagement->getRecords('ContactCategory');
		$fairs = $this->FairManagement->getList('FairCategory',array(
			'conditions' => array('active' => '1'),
			'fields' => array('id','name') 
		));
		
		$this->set(compact('contactChar','contactCats','catID','fairs'));
	}

	public function deleteContactCharacteristic() {
		$this->layout = null;
		$catUUID = $this->request->query['CCID'];
		$options['uuid'] = $catUUID;
		$this->FairManagement->makeInactive('ContactCharacteristic',$options);

		$this->redirect($this->referer());
		exit;
	}

	public function corporateCategories() {
		$corporateCategories = $this->FairManagement->paginateRecords('CorporateCategory',array(
			'conditions' => array('active' => '1')
		));
		$this->set('corporateCategories',$corporateCategories);
	}

	public function addCorporateCategory(){
		$cID = isset($this->request->query['CID']) ? $this->request->query['CID'] : null;

		if( $this->request->is('post') && !empty($this->request->data['CorporateCategory']) ) {
			$options['uuid'] = $cID;			
			
			if($this->FairManagement->save('CorporateCategory',$this->request->data['CorporateCategory'],$options)){
				$this->redirect('/Fairs/corporateCategories/');
			}
		}

		if( !empty($cID) ){
			$options['uuid'] = $cID;
			$corporateCategory = $this->FairManagement->getRecords('CorporateCategory',$options);
		}

		$this->set( compact('corporateCategory','cID') );
	}

	public function deleteCorporateCategory() {
		$this->layout = null;
		$catUUID = $this->request->query['CID'];
		$options['uuid'] = $catUUID;
		$this->FairManagement->makeInactive('CorporateCategory',$options);

		$this->redirect($this->referer());
		exit;
	}

	public function viewCompanies() {
		$cID = isset($this->request->query['CID']) ? $this->request->query['CID'] : '';
		$catOptions = $options = $corporateCategories = array();
		if(!empty($cID)) {
			$catOptions = array('uuid' => $cID);
			$corporateCat = $this->FairManagement->getRecords('CorporateCategory',$catOptions);
			$options = array('corporate_category_id' => $corporateCat['CorporateCategory']['id']);
		}else{
			$corporateCategories = $this->FairManagement->getList('CorporateCategory',array(
					'conditions' => array('active' => '1')
				));
		}
		$conditions = array('Company.active' => '1');
		if(!empty($this->request->query)) {
			$request = $this->request->query;
		}elseif(!empty($this->request->params['named'])){
			$request = $this->request->params['named'];
		}
		// debug($request);
		if(!empty($request['corporate_category_id'])) {
			$conditions['corporate_category_id'] = $request['corporate_category_id'];
		}
		if(!empty($request['name'])) {
			$conditions[] = "name LIKE '%{$request['name']}%'";
		}
		if(!empty($request['mobile'])) {
			$conditions[] = "(mobile LIKE '%{$request['mobile']}%' OR phone LIKE '%{$request['mobile']}%')";
		}

		$viewFields = $this->FairManagement->getList('ModelField',array(
			'conditions' => array('model' => 'Company'),
			'fields' => array('field','field'),
			'order' => array('id ASC')
		));
		$options['contain'] = array('Country');
		if(isset($viewFields['created_by'])) {
			$options['contain'] += array('CreatedBy' => array(
				'fields' => array('id','first_name','last_name')
			));
		}
		if(isset($viewFields['updated_by'])) {
			$options['contain'] += array('UpdatedBy'  => array(
				'fields' => array('id','first_name','last_name')
			));
		}
		$options['conditions'] = $conditions;
		$companies = $this->FairManagement->paginateRecords('Company',$options);
		$this->set(compact('cID','companies','counter','corporateCat','corporateCategories','viewFields'));
	}

	public function addCompany() {
		$catID = isset($this->request->query['CID']) ? $this->request->query['CID'] : '';
		$coID = isset($this->request->query['COID']) ? $this->request->query['COID'] : '';
		
		$is_ajax = false;
		if($this->request->is('ajax')) {
			$this->layout = 'ajax';
			$is_ajax = 1;
		}

		if($this->request->is('get') && !empty($this->request->query['NEW'])) {
			$company_data = $this->Session->read('company');
			if(!empty($company_data)) {
				$company_id = $this->FairManagement->save('Company',$company_data,array('uuid' => $coID));
			}
			$this->Session->delete('company');
			if(!$is_ajax) {
				$this->redirect('/Fairs/viewCompanies?CID='.$catID);
			}else{
				$this->response->type('json');
				echo json_encode(array('company' => array('id' => $company_id, 'name' => $company_data['name'])));
				return $this->response;
			}
			exit;
		}
		elseif($this->request->is('post') && !empty($this->request->data)) {
			if(empty($this->request->query['OW']) ) {
				$validateOptions = array(
					'uuid' => $coID,
					'fields' => array('name','phone','mobile','fax','email','website')
				);
				$duplicateRecords = $this->FairManagement->validateRecord('Company',$this->request->data['Company'],$validateOptions);
				if(!empty($duplicateRecords)) {
					$this->Session->write('company',$this->request->data['Company']);
					$company_data = $this->request->data['Company'];
					$this->set(compact('duplicateRecords','validateOptions','catID','coID','company_data','is_ajax'));
					$this->render('show_duplicate_companies');
				}else{
					$company_id = $this->FairManagement->save('Company',$this->request->data['Company'],array('uuid' => $coID));
					if(!$is_ajax) {
						$this->redirect('/Fairs/viewCompanies?CID='.$catID);
					}else{
						$this->response->type('json');
						echo json_encode(array('company' => array('id' => $company_id,'name' => $this->request->data['Company']['name'])));
						return $this->response;
					}
					exit;
				}
			}
			if(!empty($this->request->query['OW'])) {
				$company_data = $this->Session->read('company');
				if(!empty($company_data) && !empty($this->request->data['Company']['uuid']) ) {
					foreach($this->request->data['Company']['uuid'] as $index => $key ) {
						$company_id = $this->FairManagement->save('Company',$company_data,array('uuid' => $key));
					}
					$this->FairManagement->makeInactive('Company',array('uuid' => $coID));
				}

				$this->Session->delete('company');
				if(!$is_ajax) {
					$this->redirect('/Fairs/viewCompanies?CID='.$catID);
				}else{
					$this->response->type('json');
					echo json_encode(array('company' => array('id' => $company_id, 'name' => $company_data['name'])));
					return $this->response;
				}
				exit;
			}
		}

		$company = array();
		if( !empty($coID) ){
			$options = array();
			$options['uuid'] = $coID;
			$company = $this->FairManagement->getRecords('Company',$options);
		}
		if(!empty($this->request->query['EDIT'])) {
			$company['Company'] = $this->Session->read('company');
		}
		$corporateCategories = $this->FairManagement->getRecords('CorporateCategory');
		$countries = $this->FairManagement->getRecords('Country');
		$this->set(compact('catID','coID','corporateCategories','company','countries','is_ajax'));
	}

	public function deleteCompany() {
		$this->layout = null;
		$comanyUUID = $this->request->query['COID'];
		$options['uuid'] = $comanyUUID;
		$this->FairManagement->makeInactive('Company',$options);

		$this->redirect($this->referer());
		exit;
	}
	
	public function inviteCategories() {
		$inviteCategories = $this->FairManagement->paginateRecords('InviteCategory',array(
			'conditions' => array('InviteCategory.active' => '1'),
			'contain' => array(
				'FairCategory',
				'InviteList' => array(
					'conditions' => array('active' => '1'),
					'fields' => array('id','uuid','name','invite_category_id')
				)),
		));

		foreach ($inviteCategories as $key => $value) {
			$inviteCategories[$key]['InviteCategory']['listCount'] = $this->FairManagement->initModel('InviteList')->find('count',array(
				'conditions' => array('invite_category_id' => $value['InviteCategory']['id'],'active' => '1')
			));
		}
		$this->set('inviteCategories',$inviteCategories);
	}

	public function addInviteCategory() {
		$catID = isset($this->request->query['CID']) ? $this->request->query['CID'] : '';
		if( $this->request->is('post') && !empty($this->request->data) ) {
			$options['uuid'] = $catID;
			$this->FairManagement->save('InviteCategory',$this->request->data['InviteCategory'],$options);
			$this->redirect('/Fairs/inviteCategories');
		}
		$inviteCat = array();
		if( !empty($catID) ){
			$options = array('uuid'=> $catID);
			$inviteCat = $this->FairManagement->getRecords('InviteCategory',$options);	
		}
		$fair_cats = $this->FairManagement->getList('FairCategory',array(
			'conditions' => array('active' => '1')
		));
		$this->set(compact('inviteCat','catID','fair_cats'));
	}

	public function deleteInviteCategory() {
		$this->layout = null;
		$catUUID = $this->request->query['CID'];
		$options['uuid'] = $catUUID;
		$this->FairManagement->makeInactive('InviteCategory',$options);

		$this->redirect($this->referer());
		exit;
	}
	public function contacts() {
		$catID = isset($this->request->query['CID']) ? $this->request->query['CID'] : '';
		$fID = isset($this->request->query['FID']) ? $this->request->query['FID'] : '';
		$contacts = $fair = $fairCategories = $fairsByYear = array();
		if(!empty($catID) || !empty($fID)) {
			$data = $this->FairManagement->getFairContacts($fID);
			$contacts = $data['contacts'];
			$fair = $data['fair'];
			$render = 'fair_contacts';
		}else{
			$request_data = array();
			if(!empty($this->request->query)) {
				$request_data = $this->request->query;
			}elseif(!empty($this->request->params['named'])){
				$request_data = $this->request->params['named'];
			}
			//build search conditions
			$conditions = $this->FairManagement->buildContactsSearchConditions($request_data);
			// debug($conditions); exit;
			$limit = 20;
			if(!empty($request_data['limit'])) {
				$limit = $request_data['limit'];
			}
			$optList = array(
				'conditions' => $conditions,
				'limit' => $limit,
				'contain' => array(
					'Fair' => array(
						'fields' => array('id','name'),
						'conditions' => array('active' => '1')
					),
					'Flag' => array(
						'fields' => array('color','id')
 					),
					'ContactCharacteristic' => array(
						'fields' => array('id','name'),
						'conditions' => array('ContactCharacteristic.active' => '1')
					),
					'CreatedBy' => array(
						'fields' => array('id','first_name','last_name')
					),
					'UpdatedBy' => array(
						'fields' => array('id','first_name','last_name')
					),
					'InviteList' => array(
						'fields' => array('InviteList.id','InviteList.uuid','InviteList.name')
					)
				)
			);
			
			$contacts = $this->FairManagement->paginateRecords('Contact',$optList);

			$listOpt = array(
				'fields' => array('id','name'),
				'conditions' => array('active' => '1')
			);
			$fairCategories = $this->FairManagement->getList('FairCategory',$listOpt);
			$fairsByYear = $this->FairManagement->getList('Fair',$listOpt);
			$charCategories = $this->FairManagement->getList('ContactCategory',array(
				'conditions' => array('active' => '1')
			));
			$flags = $this->FairManagement->getRecords('Flag',array(
				'active' => '1',
				'fields' => array('id','color','title')
			));
			$companies = $this->FairManagement->getList('Company',array(
				'conditions' => array('Company.active' => '1'),
				'fields' => array('id','name')
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

			$countries = $this->FairManagement->getCountriesByRegion();
			$render = 'contacts';
		}
		
		$viewFields = $this->FairManagement->getList('ModelField',array(
			'conditions' => array('model' => 'Contact'),
			'fields' => array('field','field'),
			'order' => 'id ASC'
		));
		$allFields = $this->FairManagement->initModel('Contact')->getColumnTypes();
		$field_diff = array_diff_key($allFields,$viewFields);
		
		$this->set(compact('catID','fair','contacts','fairCategories','fairsByYear','contactChars','countries','request_data','viewFields','field_diff','flags','companies'));
		$this->render($render);
	}
	public function deleteContact(){
		$this->layout = null;
		$conID = $this->request->query['COID'];
		$options['uuid'] = $conID;
		$this->FairManagement->makeInactive('Contact',$options);

		$this->redirect($this->referer());
		exit;
	}

	public function addContact() {
		$catID = isset($this->request->query['CID']) ? $this->request->query['CID'] : '';
		$fid = isset($this->request->query['FID']) ? $this->request->query['FID'] : '';
		$conID = isset($this->request->query['CONID']) ? $this->request->query['CONID'] : '';
		$invite_list_id = isset($this->request->query['list_id']) ? $this->request->query['list_id'] : '';
		$from = $redirect_append = $fairID = '';
		if(!empty($this->request->query['FROM'])) {
			$from = $this->request->query['FROM'];
		}
		$fairCategories = $companies = $fairs = array();
		if($from == 'Companies' || (empty($catID) && empty($fid) && empty($conID))) {
			$fairCategories = $this->FairManagement->getRecords('FairCategory');
			//$fairs = $this->FairManagement->getRecords('Fair');
		}
		if(!empty($catID) && !empty($fid)) {
			$redirect_append = '?CID='.$catID.'&FID='.$fid;
		}
		App::uses('Uploader','Uploader.Vendor');
		$uploaderObj = new Uploader();
		if(!empty($this->request->data['Contact']['photo'])) {
			$photo = $this->request->data['Contact']['photo'];
			$uploaderObj->uploadDir = 'files/tmp/';
			$this->request->data['Contact']['uploaded_photo'] = $uploaderObj->upload($photo);
		}
		if($this->request->is('get') && !empty($this->request->query['NEW'])) {
			$contact_info = $this->Session->read('contact');
			if($from == 'invites' && empty($conID)) {
				$contact_info['Contact']['registration_method'] = 'on_site';
			}elseif(empty($conID)) {
				$contact_info['Contact']['registration_method'] = 'manual';
			}
			if(empty($conID) && empty($from)) {
				$contact_info['Contact']['fair_category_id'] = $this->FairManagement->getIDByUUID('FairCategory',array('uuid' => $catID));
				$fairID = $contact_info['Contact']['fair_id'] = $this->FairManagement->getIDByUUID('Fair',array('uuid' => $fid));
			}elseif($from == 'Companies' || (empty($catID) && empty($fid) && empty($conID))) {
				$fairID = $contact_info['Contact']['fair_id'];
			}elseif (!empty($fid)) {
				$fairID = $this->FairManagement->getIDByUUID('Fair',array('uuid' => $fid));
			}
			$this->_addContact($conID, $contact_info,$fairID,$invite_list_id);
			$this->Session->delete('contact');

			if($from == 'Companies') {
				$this->redirect('/Fairs/viewCompanies?CID='.$catID);
				exit;
			}
			if($from == 'invites') {
				$this->redirect('/invites/index?list_id='.$invite_list_id);
				exit;
			}
			$this->redirect('/Fairs/contacts'.$redirect_append);
			exit;
		}
		if($this->request->is('post') && !empty($this->request->data) ) {
			$contact_data = $this->request->data;
			if(empty($this->request->query['OW'])) {
				$validateOptions = array(
					'uuid' => $conID,
					'fields' => $this->FairManagement->initModel('Contact')->getFieldstoCheckForDuplicates()
				);
				$duplicateRecords = $this->FairManagement->validateRecord('Contact',$contact_data['Contact'],$validateOptions);
				if(!empty($duplicateRecords)) {
					$this->Session->write('contact',$contact_data);
					$contact_data = $contact_data['Contact'];
					$this->set(compact('duplicateRecords','catID','conID','contact_data','from','countries','fid','tagCH','invite_list_id'));
					$this->render('show_duplicate_contacts');
				}else{
					if(empty($conID) && empty($from)) {
						$contact_data['Contact']['fair_category_id'] = $this->FairManagement->getIDByUUID('FairCategory',array('uuid' => $catID));
						$fairID = $contact_data['Contact']['fair_id'] = $this->FairManagement->getIDByUUID('Fair',array('uuid' => $fid));
					}elseif ($from == 'Companies' || (empty($catID) && empty($fid) && empty($conID))) {
						$fairID = $contact_data['Contact']['fair_id'];
					}elseif(!empty($fid)){
						$fairID = $this->FairManagement->getIDByUUID('Fair',array('uuid' => $fid));
					}
					if($from == 'invites' && empty($conID)) {
						$contact_data['Contact']['registration_method'] = 'on_site';
					}elseif(empty($conID)) {
						$contact_data['Contact']['registration_method'] = 'manual';
					}
					
					$this->_addContact($conID, $contact_data,$fairID,$invite_list_id);
					if($from == 'Companies') {
						$this->redirect('/Fairs/viewCompanies?CID='.$catID);
						exit;
					}
					if($from == 'invites') {
						$this->redirect('/invites/index?list_id='.$invite_list_id);
						exit;
					}
					$this->redirect('/Fairs/contacts'.$redirect_append);
					exit;
				}
			}
			if(!empty($this->request->query['OW'])) {
				$contact_info = $this->Session->read('contact');
				if(!empty($this->request->data['Contact']['uuid'])) {
					if(empty($conID) && empty($from)) {
						$contact_data['Contact']['fair_category_id'] = $this->FairManagement->getIDByUUID('FairCategory',array('uuid' => $catID));
						$fairID = $contact_data['Contact']['fair_id'] = $this->FairManagement->getIDByUUID('Fair',array('uuid' => $fid));
					}elseif($from == 'Companies' || (empty($catID) && empty($fid) && empty($conID))) {
						$fairID = $contact_data['Contact']['fair_id'];
					}elseif(!empty($fid)){
						$fairID = $this->FairManagement->getIDByUUID('Fair',array('uuid' => $fid));
					}
					if($from == 'invites' && empty($conID)) {
						$contact_info['Contact']['registration_method'] = 'on_site';
					}elseif(empty($conID)) {
						$contact_info['Contact']['registration_method'] = 'manual';
					}
					foreach ($this->request->data['Contact']['uuid'] as $key => $value) {
						$this->_addContact($value,$contact_info,$fairID,$invite_list_id);
					}
					$this->FairManagement->makeInactive('Contact',array('uuid' => $conID));
				}

				if($from == 'Companies') {
					$this->redirect('/Fairs/viewCompanies?CID='.$catID);
					exit;
				}
				if($from == 'invites') {
					$this->redirect('/invites/index?list_id='.$invite_list_id);
					exit;
				}
				$this->redirect('/Fairs/contacts'.$redirect_append);
				exit;
			}
		}
		
		$contact = $tagedCompanies = $cities = array();
		if(!empty($conID)) {
			$this->request->data = $contact = $this->FairManagement->getRecords('Contact',array('uuid' => $conID));
			$contactID = isset($contact['Contact']['id']) ? $contact['Contact']['id'] : '';
			$tagedCompanies = $this->FairManagement->getTaggedCompanies($contactID);
			$country_name = $this->request->data['Contact']['country'];
			$country_code = $this->FairManagement->initModel('Country')->field('iso3',array("nicename LIKE '$country_name'"));
			$cities = $this->FairManagement->getList('City',array(
				'conditions' => array('country_code' => $country_code),
				'fields' => array('name','name')
			));
		}
		if(!empty($this->request->query['EDIT'])) {
			$this->request->data = $contact = $this->Session->read('contact');
			$tagged = isset($contact['ContactToCompany']) ? $contact['ContactToCompany'] : array();
			$tagedCompanies = $this->formatTagged($tagged);
			if(empty($conID)) {
				$fairs = $this->FairManagement->getList('Fair',array(
					'conditions' => array('fair_category_id' => $contact['Contact']['fair_category_id'],'active' => '1')
				));
			}
			$country_name = $this->request->data['Contact']['country'];
			$country_code = $this->FairManagement->initModel('Country')->field('iso3',array("nicename LIKE '$country_name'"));
			$cities = $this->FairManagement->getList('City',array(
				'conditions' => array('country_code' => $country_code),
				'fields' => array('name','name')
			));
		}
		if(!empty($this->request->query['cids'])) {
			$company_ids = trim($this->request->query['cids']);
			$company_ids = explode(',', $company_ids);
			$tagedCompanies = $this->FairManagement->initModel('Company')->find('all',array(
				'conditions' => array('id' => $company_ids)
			));
		}
		$invite_types = array();
		$companies = $this->FairManagement->getRecords('Company');

		if(!empty($this->request->data['Contact']['fair_category_id'])) {
			$invite_types = $this->FairManagement->getList('InviteCategory',array(
				'conditions' => array('active' => '1','fair_category_id' => $this->request->data['Contact']['fair_category_id'])
			));
		}
		$countries = $this->FairManagement->getList('Country',array(
			'conditions' => array('active' => '1'),
			'fields' => array('nicename','nicename'),
			'order' => 'nicename ASC'
		));
		$socialMedias = array('facebook' => 'Facebook','twitter' => 'Twitter','linkedin' => 'Linkedin', 'instagram' => 'Instagram');
		$this->set(compact('catID','conID','countries','contact','from','fairCategories','companies','tagedCompanies','fid','fairs','tagCH','socialMedias','invite_types','cities'));
	}
	
	public function formatTagged($data) {
		if(empty($data)) {
			return false;
		}
		$array = array();
		foreach ($data as $d) {
			$array[] = array(
				'ContactToCompany' => array(
					'company_id' => $d['id'],
					'job_title' => $d['job_title']
				),
				'Company' => array(
					'id' => $d['id'],
					'name' => $d['name']
				)
			);
		}
		return $array;
	}

	public function tagCharacteristics() {
		$cid = isset($this->request->query['CID']) ? $this->request->query['CID'] : '';
		$fid = isset($this->request->query['FID']) ? $this->request->query['FID'] : '';
		$conID = $this->request->query['CONID'];
		$contact = $this->FairManagement->getRecords('Contact',array(
			'Contact.uuid' => $conID,
			'fields' => array('id','fair_category_id')
		));
		$contactID = $contact['Contact']['id'];
		$fair_cat_id = $contact['Contact']['fair_category_id'];

		if($this->request->is('post')) {
			if(!empty($this->request->data['ContactToContactCharacteristic'])) {
				$contactChars = $this->request->data['ContactToContactCharacteristic'];
				$this->FairManagement->tagContactToContactCharacteristic($contactID,$contactChars);

			}else{
				$this->FairManagement->tagContactToContactCharacteristic($contactID);
			}
			if(!empty($this->request->data['redirect_path'])) {
				$this->redirect($this->request->data['redirect_path']);
				exit;
			}
			$this->redirect('/Fairs/contacts');
			exit;
		}
		$options = array(
			'contain' => array('ContactCharacteristic' => array(
				'conditions' => array('fair_category_id' => $fair_cat_id)
			)),
		);
		$characteristics = $this->FairManagement->getRecords('ContactCategory',$options);

		$optList = array(
			'fields' => array('contact_characteristic_id','contact_characteristic_id'),
			'conditions' => array('contact_id' => $contactID)
		);
		$tagedCharacteristics = $this->FairManagement->getList('ContactToContactCharacteristic',$optList);

		$coptList = array(
			'conditions' => array('active' => '1')
		);

		$ccCount = $this->FairManagement->getCount('ContactCharacteristic',$coptList);

		$this->set(compact('cid','fid','conID','characteristics','tagedCharacteristics','ccCount'));
	}

	protected function _addContact($conID, $contact_data,$fairID,$invite_list_id = null) {
		if(empty($contact_data)) {
			return false;
		}
		if(!empty($contact_data['Contact']['uploaded_photo'])) {
			$photo = $contact_data['Contact']['uploaded_photo'];
			App::uses('Uploader','Uploader.Vendor');
			$uploaderObj = new Uploader();
			$uploaderObj->uploadDir = '/files/contact_photos/';
			$path = WWW_ROOT.$contact_data['Contact']['uploaded_photo']['path'];
			$data = $uploaderObj->import($path,array('delete' => true));
			$uploaderObj->resize(array('width' => '100','append' => '-thumb'));
			$contact_data['Contact']['photo'] = $data['path'];
		}else{
			unset($contact_data['Contact']['photo']);
		}
		$contact_data['Contact']['shared'] = !empty($contact_data['Contact']['shared']) ? '1' : '0';
		if(empty($conID)) {
			$contact_data['Contact']['bar_code'] = generate_bar_code();
		}
		if(!empty($contact_data['Contact']['city_other'])) {
			
			$city_name = strtolower($contact_data['Contact']['city_other']);
			$country = $contact_data['Contact']['country'];
			$country_code = $this->FairManagement->initModel('Country')->field('iso3',array("nicename LIKE '$country'"));
			$found = $this->FairManagement->initModel('City')->find('count',array(
				'conditions' => array('country_code' => $country_code,"LOWER(name) LIKE '$city_name'")
			));

			$city_name = ucwords($city_name);
			
			if(empty($found)) {
				$temp_city = array('name' => $city_name,'country_code' => $country_code);
				$this->FairManagement->save('City',$temp_city);
			}
			$contact_data['Contact']['city'] = $city_name;
		}
		$contactID = $this->FairManagement->save('Contact',$contact_data['Contact'],array('uuid' => $conID));
		$this->FairManagement->mapContactToFair($contactID,$fairID);
		if(!empty($contact_data['ContactToCompany'])) {
			$this->FairManagement->tagContactToCompany($contactID,$contact_data['ContactToCompany']);
		}elseif(empty($contact_data['ContactToCompany'])) {
			$this->FairManagement->tagContactToCompany($contactID);
		}

		if(!empty($invite_list_id)) {
			$invite_list_id = $this->FairManagement->getIDByUUID('InviteList',$invite_list_id);
			$this->FairManagement->addContactToInviteList($contactID,$invite_list_id,array('invited' => '1'));
		}
		return $contactID;
	}

	public function importContacts() {
		$fcuuid = $this->request->query['FCID'];
		$fid = $this->request->query['FID'];
		if(!empty($this->request->data['Fair'])) {
			$fairIDs = $this->request->data['Fair'];
			$this->FairManagement->importContacts($fid,$this->request->data['Fair']);
			$this->redirect('/Fairs/viewFairs?FCID='.$fcuuid);
			exit;
		}
		$fcid = $this->FairManagement->getIDByUUID('FairCategory',array('uuid' => $fcuuid));
		$fairs = $this->FairManagement->getRecords('Fair',array('fair_category_id' => $fcid,'uuid <>' => $fid));
		$this->set(compact('fairs','fcuuid','fid'));
	}

	public function addContactDocuments(){
	
		//This function adds and shows contact documents.			
				
		$cID = isset($this->request->query['CID']) ? $this->request->query['CID'] : '';	
		$contact_uuid = $this->request->query['contact_uuid'];
		$FID = isset($this->request->query['FID']) ? $this->request->query['FID'] : '';
		
		//debug( $this->request->data['ContactDocument']['attachment4']['name'] );exit;		

		if( $this->request->is('post') && !empty( $this->request->data['ContactDocument']['title'] ) ) {
			//$options['uuid'] = $cID;				
			
			$title = $this->request->data['ContactDocument']['title'];
			$att1 = $this->request->data['ContactDocument']['attachment1']['name'];
			$att2 = $this->request->data['ContactDocument']['attachment2']['name'];
			$att3 = $this->request->data['ContactDocument']['attachment3']['name'];
			$att4 = $this->request->data['ContactDocument']['attachment4']['name'];
			
			$temp['title'] = $title;
			$temp['contact_id'] = $contact_uuid;
			$temp['attachment1'] = $att1;
			$temp['attachment2'] = $att2;
			$temp['attachment3'] = $att3;
			$temp['attachment4'] = $att4;
			
			//debug(WEBROOT_DIR);exit;
			if( !empty( $this->request->data['ContactDocument']['attachment1']['name'] ))	
				move_uploaded_file( $this->request->data['ContactDocument']['attachment1']['tmp_name'], '..'.DS.WEBROOT_DIR.DS."upload".DS. $this->request->data['ContactDocument']['attachment1']['name'] );
			
			if( !empty( $this->request->data['ContactDocument']['attachment2']['name'] ))			
				move_uploaded_file( $this->request->data['ContactDocument']['attachment2']['tmp_name'], '..'.DS.WEBROOT_DIR.DS."upload".DS. $this->request->data['ContactDocument']['attachment2']['name'] );
			
			if( !empty( $this->request->data['ContactDocument']['attachment3']['name'] ))			
				move_uploaded_file( $this->request->data['ContactDocument']['attachment3']['tmp_name'], '..'.DS.WEBROOT_DIR.DS."upload".DS. $this->request->data['ContactDocument']['attachment3']['name'] );
			
			if( !empty( $this->request->data['ContactDocument']['attachment4']['name'] ))			
				move_uploaded_file( $this->request->data['ContactDocument']['attachment4']['tmp_name'], '..'.DS.WEBROOT_DIR.DS."upload".DS. $this->request->data['ContactDocument']['attachment4']['name'] );
			
			if($this->FairManagement->save('ContactDocument',$temp)){
				// $this->redirect("/Fairs/contacts?CID=$cID&FID=$FID");
			}
		}
			
		$options['contact_id'] = $contact_uuid;	
		$all_images = $this->FairManagement->getRecords('ContactDocument',$options);		
		$this->set( compact('all_images','cID','contact_uuid','FID') );
	}
	
	public function deleteContactDocuments(){
	
		//This function deletes the documents attached to a contact
		$contact_id = $this->request->query['CID'];
		$options = array('contact_id' => $contact_id);
		
		$this->loadModel('ContactDocument');
		if( !empty($contact_id) )
		{
			$query = "update contact_documents set active=0 where id='$contact_id'";
			$this->ContactDocument->query($query);			
		}		
		
		$this->redirect($this->referer());
		exit;
		
	}

	public function search_companies(){
		$query = $this->request->query['term'];
		$tagged = isset($this->request->query['tagged']) ? trim($this->request->query['tagged'],',') : array();
		$companies = $this->FairManagement->searchCompanies($query,$tagged);

		$this->RequestHandler->setContent('json','application/json');
		echo json_encode($companies);
		exit;
	}
	public function addGuestOf(){

		if(!empty($this->request->data)){
			
			$fair = $this->FairManagement->getRecords('Fair',array('id' => $this->request->data['guestOf']['fair_id']));
			
			$fair_category = $this->FairManagement->getRecords('FairCategory',array('id' => $fair['Fair']['fair_category_id']));
			
			$companyID = $this->request->data['company_ids'];
			$companyID = explode(',',$companyID);
			
			$dataInvite['fair_id'] = $this->request->data['guestOf']['fair_id'];
			$dataInvite['invite_category_id'] = $this->request->data['guestOf']['invite_category_id'];
			$dataInvite['name'] = $this->request->data['guestOf']['inputName'];
			$lastInviteId =  $this->FairManagement->save('InviteList',$dataInvite);
			
			$dataContacts['fair_id'] = $this->request->data['guestOf']['fair_id'];
			$dataContacts['fair_category_id'] = $fair_category['FairCategory']['id'];
			$dataContacts['guest_off'] = $this->request->data['guestOf']['guest_of'];
			$dataContacts['registration_method'] = 'manual';
			$invitesCounter = $this->request->data['guestOf']['invites'];
			
			for($res=0;$res<$invitesCounter;$res++){
				$dataContacts['bar_code'] = generate_bar_code();
				$lastContactId = $this->FairManagement->save('Contact',$dataContacts);
				$this->FairManagement->mapContactToFair($lastContactId,$dataInvite['fair_id']);
				$dataInviteList['contact_id'] = $lastContactId;
				$dataInviteList['invite_list_id'] = $lastInviteId;
				$this->FairManagement->save('ContactsInviteList',$dataInviteList);
				
				$contact_companies['company_id'] = $companyID[0];
				$contact_companies['contact_id'] = $lastContactId;				
				$lastContactId = $this->FairManagement->save('ContactToCompany',$contact_companies);				
			}
			$this->redirect('/Fairs/viewCompanies');
		}else{
			$this->layout = 'ajax';
			$conditions = array('Company.active' => '1');
			$request = $this->request->data;
			$fairs = $this->FairManagement->getRecords('Fair',array('active' => '1'));
			$inviteCategories = $this->FairManagement->getRecords('InviteCategory',array('active' => '1'));
			$this->set(compact('fairs','inviteCategories'));
		}
	
	}
	public function addContactAsGuest() {
		if(!empty($this->request->data)) {
			$data = $this->request->data;
			$temp = array();
			$temp['fair_id'] = $data['GuestOf']['fair_id'];
			$temp['fair_event_id'] = $data['GuestOf']['event_id'];
			$temp['invite_category_id'] = $data['GuestOf']['invite_category_id'];
			$temp['name'] = $data['GuestOf']['list_name'];
			$lastInviteId = $this->FairManagement->save('InviteList',$temp);

			$invites = $data['GuestOf']['invites'];
			
			$fair = $this->FairManagement->getRecords('Fair',array('id' => $this->request->data['GuestOf']['fair_id']));
			
			$fair_category = $this->FairManagement->getRecords('FairCategory',array('id' => $fair['Fair']['fair_category_id']));

			$dataContacts['fair_id'] = $this->request->data['GuestOf']['fair_id'];
			$dataContacts['fair_category_id'] = $fair_category['FairCategory']['id'];
			$dataContacts['guest_off'] = $data['GuestOf']['guest_of'];
			$dataContacts['registration_method'] = 'manual';
			for($i = 0; $i < $invites; $i++) {
				$dataContacts['bar_code'] = generate_bar_code();
				$lastContactId = $this->FairManagement->save('Contact',$dataContacts);
				$this->FairManagement->mapContactToFair($lastContactId,$dataContacts['fair_id']);

				$dataInviteList['contact_id'] = $lastContactId;
				$dataInviteList['invite_list_id'] = $lastInviteId;
				$this->FairManagement->save('ContactsInviteList',$dataInviteList);
			}
			echo '1';
			return $this->response;
			exit;
		}
		$this->layout = 'ajax';
		$con_id = isset($this->request->query['CONID']) ? $this->request->query['CONID'] : null;
		$fairs = $this->FairManagement->getRecords('Fair',array('active' => '1'));
		$contact_name = $this->FairManagement->getRecords('Contact',array(
			'uuid' => $con_id,
			'fields' => array('first_name','last_name')
		));
		$inviteCategories = $this->FairManagement->getRecords('InviteCategory',array('active' => '1'));
		$this->set(compact('fairs','inviteCategories','con_id','contact_name'));
	}
	public function fetechFairs() {
		$fair_category_id = $this->request->query['cat_id'];
		$fairs = $this->FairManagement->initModel('Fair')->find('all',array(
			'conditions' => array('Fair.active' => '1','Fair.fair_category_id' => $fair_category_id),
			'fields' => array('id','name','year')
		));
		$json_bj = array();
		foreach($fairs as $key => $value){
			$json_bj[] = array('key' => $value['Fair']['id'],'value' => $value['Fair']['name'],'year' => $value['Fair']['year']);
		}
		echo json_encode($json_bj);
		exit;
	}
	public function fetchEvents() {
		$fair_id = $this->request->query['fair_id'];
		$events = $this->FairManagement->getList('FairEvent',array(
			'conditions' => array('FairEvent.active' => '1','FairEvent.fair_id' => $fair_id)
		));
		$json_bj = array();
		foreach($events as $key => $value){
			$json_bj[] = array('key' => $key,'value' => $value);
		}
		echo json_encode($json_bj);
		exit;
	}

	public function getCities() {
		$country_code = $this->request->query['country_code'];
		$iso3 = $this->FairManagement->initModel('Country')->field('iso3',array("nicename LIKE '$country_code'"));
		$cities = $this->FairManagement->getList('City',array(
			'conditions' => array('City.country_code' => $iso3),
			'fields' => array('name','name'),
			'order' => 'name ASC'
		));
		$json_bj = array('country_code' => $iso3);
		foreach($cities as $key => $value){
			$json_bj['cities'][] = array('key' => $key,'value' => $value);
		}
		echo json_encode($json_bj);
		exit;
	}
	//view company details
	public function viewCompany() {
		$company_uuid = $this->request->query['COID'];
		$company = $this->FairManagement->getRecords('Company',array(
			'Company.uuid' => $company_uuid,
			'contain' => array(
				'CorporateCategory',
				'Country',
				'CreatedBy' => array('id','first_name','last_name'),
				'UpdatedBy' => array('id','first_name','last_name'),
			)
		));
		$this->set(compact('company'));
	}

	//view contact details
	public function viewContact() {
		$contact_uuid = $this->request->query['CONID'];
		$contact = $this->FairManagement->getRecords('Contact',array(
			'Contact.uuid' => $contact_uuid,
			'contain' => array(
				'Fair' => array(
					'fields' => array('id','name'),
					'conditions' => array('Fair.active' => '1')
				),
				'CreatedBy' => array(
					'fields' => array('id','first_name','last_name')
				),
				'UpdatedBy' => array(
					'fields' => array('id','first_name','last_name')
				),
				'ContactCharacteristic' => array(
					'fields' => array('id','name')
				),
				'Company' => array(
					'fields' => array('id','name')
				)
			)
		));
		$this->set(compact('contact'));
	}
	public function adminDashbord() {

	}
	public function getInviteTypes() {
		$fair_category_id = $this->request->query['cat_id'];
		$invite_categories = $this->FairManagement->initModel('InviteCategory')->find('all',array(
			'conditions' => array('InviteCategory.active' => '1','InviteCategory.fair_category_id' => $fair_category_id),
			'fields' => array('id','name')
		));
		$json_bj = array();
		foreach($invite_categories as $key => $value){
			$json_bj[] = array('key' => $value['InviteCategory']['id'],'value' => $value['InviteCategory']['name']);
		}
		echo json_encode($json_bj);
		exit;
	}
	public function printAddress() {
		$this->layout = 'print';
		$conID = $this->request->query['CONID'];

		$contact = $this->FairManagement->getRecords('Contact',array(
			'uuid' => $conID,
			'fields' => array('first_name','last_name','address','city','country')
		));
		
		$this->set(compact('contact'));
	}
}