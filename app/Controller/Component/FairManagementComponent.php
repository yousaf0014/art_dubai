<?php
/**
 * FairManagement component
 *
 * Manages fair/events module logics.
 *
 * @copyright     Copyright (c) Dotme Tech FZ LLC. (http://dotmetech.com/)
 * @package       app.Controller.Component
 * @author        abubakr haider
 */
App::uses('Component', 'Controller');

class FairManagementComponent extends Component{

/**
*
* Include other components
*
* @var array
*/
	public $components = array('Paginator');

/**
 * save record based on options
 *
 * @param $model String model name to save records
 * @param $data array containg fair data to be added
 * @param $options array of options
 * @return boolean true on Success, false on error
 */
	public function save($model = null, $data, $options = array()){
		
		$modelObj = $this->initModel($model);
		$crud = 'create';
		if( !empty($options['uuid']) ){
			$data['id'] = $modelObj->getIdByUuid($options['uuid']);
			$crud = 'update';
		}
		if( !empty($options['id']) ){
			$data['id'] = $options['id'];
			$crud = 'update';
		}
		if( isset($data['start_date']) ){
			$data['start_date'] = date('Y-m-d',strtotime($data['start_date']));
		}
		$temp[(String)$model] = $data;
		$storable_obj = serialize($temp);
		$modelObj->create();
		if(!$modelObj->save($temp)){
			$this->log_data($model,$data,'error',$crud);
			return false;
		}
		
		//log data into db
		$this->log_data($model,$data,'success',$crud,$modelObj->id);
		
		return $modelObj->id;
	}

/**
 * Deactivate a Model record based options
 *
 * @param $model String Model Class name
 * @param $options Array options
 * @return boolean true
 */

	public function makeInactive($model = null, $options = array()){

		$modelObj = $this->initModel($model);
		
		if( !empty($options['uuid']) ){
			$id = $modelObj->getIdByUuid($options['uuid']);
		}
		
		if( !empty($options['id']) ){
			$id = $options['id'];
		}

		if( !empty($id) ) {
			$data = array('id' => $id,'active' => '0');
			if(!$modelObj->save($data)) {
				$this->log_data($model,$data,'error','inactive',$modelObj->id);
			}else{
				$this->log_data($model,$data,'success','inactive',$modelObj->id);
			}
		}

		return true;
	}

/**
 * Activate a Model record based options
 *
 * @param $model String Model Class name
 * @param $options Array options
 * @return boolean true
 */

	public function makeActive($model = null, $options = array()){

		$modelObj = $this->initModel($model);
		
		if( !empty($options['uuid']) ){
			$id = $modelObj->getIdByUuid($options['uuid']);
		}
		
		if( !empty($options['id']) ){
			$id = $options['id'];
		}
		
		if( !empty($id) ) {
			$data = array('id' => $id,'active' => '1');
			if(!$modelObj->save($data)) {
				$this->log_data($model,$data,'error','active',$modelObj->id);
			}else{
				$this->log_data($model,$data,'success','active',$modelObj->id);
			}
		}

		return true;
	}

/**
 *
 * get record based on given model and options
 *
 * @param $model String model name
 * @param $options Array options to filter records
 * @return array of records
 *
 */
	
	public function getRecords($model = '',$options = array()){
		
		$modelObj = $this->initModel($model);
		
		$contain = array();
		$recursive = $modelObj->recursive;
		if(isset($options['contain'])) {
			$contain = $options['contain'];
			unset($options['contain']);
		}
		$limit = '';
		if(isset($options['limit'])) {
			$limit = $options['limit'];
			unset($options['limit']);
		}
		$fields = array();
		if(isset($options['fields']) && is_array($options['fields'])) {
			$fields = $options['fields'];
			unset($options['fields']);
		}
		$conditions = array($model.'.active' => '1');
		$conditions = array_merge($options,$conditions);

		$type = 'all';
		if( isset($options['uuid']) || isset($options['id']) || isset($options[$model.'.uuid']) ) {
			$type = 'first';
		}
		
		return $modelObj->find($type,array(
				'conditions' => $conditions,
				'contain' => $contain,
				'fields' => $fields,
				'recursive' => $recursive,
				'limit' => $limit
			));
	}

	public function paginateRecords($model,$options = array()){

		$modelObj = $this->initModel($model);
		
		$conditions = isset($options['conditions']) ? $options['conditions'] : array();
		$fields = isset($options['fields']) ? $options['fields'] : array();
		$limit = isset($options['limit']) ? $options['limit'] : 20;
		$contain = isset($options['contain']) ? $options['contain'] : array();
		$recursive = isset($options['recursive']) ? $options['recursive'] : '-1';
		$order = isset($options['order']) ? $options['order'] : array();
		$this->Paginator->settings = array(
			'conditions' => $conditions,
			'fields' => $fields,
			'limit' => $limit,
			'contain' => $contain,
			'recursive' => $recursive,
			'order' => $order
		);
		return $this->Paginator->paginate($modelObj);
	}

	public function getList($model,$options = array()) {

		$modelObj = $this->initModel($model);

		$fields = array('id','name');
		if(isset($options['fields'])) {
			$fields = $options['fields'];
		}
		
		$conditions = array();
		if(isset($options['conditions']) && is_array($options['conditions'])) {
			$conditions = $options['conditions'];
		}
		$order = array();
		if(isset($options['order'])) {
			$order = $options['order'];
		}
		//debug($conditions); exit;
		return $modelObj->find('list',array(
				'conditions' => $conditions,
				'fields' => $fields,
				'order' => $order
			));
	}
/**
 *
 * get ID of a rcord by uuid
 *
 * @param $model String model name
 * @param $uuid String uuid of records
 * @return Number id of record
 *
 */

	public function getIDByUUID($model,$uuid){
		
		$modelObj = $this->initModel($model);

		return $modelObj->field('id',array('uuid' => $uuid));
	}

	public function getUUIDByID($model,$id) {
		$modelObj = $this->initModel($model);
		return $modelObj->field('uuid',array('id' => $id));
	}

/**
 *
 * validate a record for duplication
 *
 * @param $model String model name
 * @param $data array
 * @param $options array
 * @return array of duplicate records
 *
 */
	public function validateRecord($model,$data = array(),$options = array()){		

		$modelObj = $this->initModel($model);

		$conditions = array($model.'.active' => '1');
		foreach ($options['fields'] as $key => $value) {
			$or[] = "($value LIKE '{$data[$value]}' AND {$value} <> '')";
		}
		if(!empty($or)){
			$conditions['OR'] = $or;
		}

		if(!empty($options['uuid'])) {
			$conditions['uuid <>'] = $options['uuid'];
		}
		
		return $modelObj->find('all',array(
			'conditions' => $conditions
		));
	}

	public function tagContactToCompany($contactID,$data = array(),$options = array()){
		if(empty($contactID)) {
			return false;
		}

		App::uses('ContactToCompany','Model');
		$cToCObj = new ContactToCompany();
		
		$cToCObj->deleteAll(array('contact_id' => $contactID));
		
		if(empty($data)) {
			return;
		}

		foreach ($data as $key => $value) {
			$temp = array();
			if(empty($value['id'])){
				continue;
			}
			$temp['contact_id'] = $contactID;
			$temp['company_id'] = $value['id'];
			$temp['job_title'] = $value['job_title'];
			$temp['default'] = (isset($value['default']) && $value['default'] == '1') ? '1' : '0';
			$this->Save('ContactToCompany',$temp);
		}

		return true;
	}
	public function tagContactToContactCharacteristic($contactID,$contactChars = array()) {
		if(empty($contactID)){
			return false;
		}
		App::uses('ContactToContactCharacteristic','Model');
		$cToCharObj = new ContactToContactCharacteristic();
		$cToCharObj->deleteAll(array('contact_id' => $contactID));
		if( !empty($contactChars) ) {
			foreach ($contactChars as $key => $value) {
				$temp = array();
				$temp['contact_id'] = $contactID;
				$temp['contact_characteristic_id'] = $value;
				$this->save('ContactToContactCharacteristic',$temp);
			}
		}

		return true;
	}

	public function getCount($model,$options) {
		$modelObj = $this->initModel($model);
		$conditions = $contain = array();
		if(isset($options['conditions'])) {
			$conditions = $options['conditions'];
		}
		if(isset($options['contain'])) {
			$contain = $options['contain'];
		}
		return $modelObj->find('count',array(
			'conditions' => $conditions,
			'contain' => $contain
		));
	}

	public function initModel($model) {
		if(empty($model)) {
			return false;
		}

		App::uses((String)$model,'Model');
		return new $model();
	}

	public function importContacts($fuuid,$fairIDs) {
		if(empty($fuuid) || empty($fairIDs)) {
			return false;
		}
		
		$contactObj = $this->initModel('Contact');
		$contactIDs = $contactObj->find('list',array(
			'conditions' => array('fair_id' => $fairIDs,'active' => '1'),
			'fields' => array('id','id')
		));
		
		if(empty($contactIDs)) {
			return;
		}
		
		$fairID = $this->getIDByUUID('Fair',$fuuid);
		
		foreach($contactIDs as $key => $value) {
			$this->mapContactToFair($value,$fairID);
		}

		return true;
	}

	public function mapContactToFair($contactID,$fairID){
		if(empty($contactID) || empty($fairID)) {
			return false;
		}
		
		$cfObj = $this->initModel('ContactsFair');

		$alredyExits = $cfObj->find('count',array(
			'conditions' => array('ContactsFair.contact_id' => $contactID,'ContactsFair.fair_id' => $fairID)
		));
		if($alredyExits){
			return true;
		}

		$temp = array();
		$temp['contact_id'] = $contactID;
		$temp['fair_id'] = $fairID;
		$this->save('ContactsFair',$temp);

		return true;
	}
	public function getFairContacts($fID) {
		$options = array('uuid' => $fID);
		$fair = $this->getRecords('Fair',$options);
		$fair_id = $fair['Fair']['id'];
		$contact_ids = $this->getList('ContactsFair',array(
			'conditions' => array('ContactsFair.fair_id' => $fair_id),
			'fields' => array('contact_id','contact_id'),
		));
		$optList = array(
			'conditions' => array('Contact.id' => $contact_ids,'Contact.active' => '1'),
			'recursive' => '1'
		);
		$contacts = $this->paginateRecords('Contact',$optList);

		return array('contacts' => $contacts,'fair' => $fair);
	}

	public function getTaggedCompanies($contactID = null,$companyID = null) {
		App::uses('ContactToCompany','Model');
		$contactToCompanyObj = new ContactToCompany();
		
		if(empty($contactID) && empty($companyID)) {
			return false;
		}
		$conditions = array();
		if(!empty($contactID)) {
			$conditions['contact_id'] = $contactID;
		}
		if(!empty($companyID)) {
			$conditions['company_id'] = $companyID;
		}
		return $contactToCompanyObj->find('all',array(
				'conditions' => $conditions,
				'contain' => array('Company' => array(
						'fields' => array('id','name')
					)),
				'recursive' => -1
			));
	}
	
	public function searchCompanies($query,$tagged = '') {
		$conditions = array('active' => '1');
		if(!empty($query)) {
			$conditions[] = "name LIKE '$query%'";
		}
		if(!empty($tagged)) {
			$conditions[] = "id NOT IN($tagged)";
		}
		$companyObj = ClassRegistry::init('Company');
		$raw_companies = $companyObj->find('list',array(
			'conditions' => $conditions,
			'limit' => '20',
			'fields' => array('id','name')
		));
		$companies = array();
		foreach ($raw_companies as $key => $value) {
			$temp = array();
			$temp['id'] = $key;
			$temp['value'] = $value;
			$temp['label'] = $value;
			$companies[] = $temp;
		}
		return $companies;
	}
	public function buildContactsSearchConditions($request_data) {
		$conditions = array('Contact.active' => '1');
		$continue_serach = false;
		$contact_ids = array();
		if(!empty($request_data['fair_category_id'])){
			$conditions['Contact.fair_category_id'] = $request_data['fair_category_id'];
		}
		if(!empty($request_data['name'])) {
			$conditions[] = "(Contact.first_name LIKE '%{$request_data['name']}%' OR Contact.last_name LIKE '%{$request_data['name']}%')";
		}
		if(!empty($request_data['first_name'])) {
			$conditions[] = "Contact.first_name LIKE '%{$request_data['first_name']}%'";
		}
		if(!empty($request_data['last_name'])) {
			$conditions[] = "Contact.last_name LIKE '%{$request_data['last_name']}%'";
		}
		if(!empty($request_data['mobile'])) {
			$conditions[] = "(Contact.mobile LIKE '%{$request_data['mobile']}%' OR Contact.phone LIKE '%{$request_data['mobile']}%')";
		}
		if(!empty($request_data['shared'])) {
			$conditions['Contact.shared'] = '1';
		}
		if(!empty($request_data['countries'])) {
			$conditions['Contact.country'] = $request_data['countries'];
		}
		if(!empty($request_data['city'])) {
			$conditions[] = "Contact.city LIKE '%{$request_data['city']}%'";
		}
		if(!empty($request_data['bar_code'])) {
			$conditions[] = "Contact.bar_code LIKE '{$request_data['bar_code']}%'";	
		}
		if(!empty($request_data['email'])) {
			$conditions[] = "Contact.email LIKE '{$request_data['email']}%'";	
		}
		if(!empty($request_data['guest_off'])) {
			$conditions[] = "Contact.guest_off LIKE '{$request_data['guest_off']}%'";
		}
		if(!empty($request_data['registration_method'])) {
			$conditions['Contact.registration_method'] = $request_data['registration_method'];
		}
		if(!empty($request_data['general_keyword'])) {
			$columns = $this->initModel('Contact')->getColumnTypes();
			foreach ($columns as $key => $value) {
				if($key == 'first_name' || $key == 'last_name'){
					$conditions['OR'][]  = "Contact.$key LIKE '%{$request_data['general_keyword']}%'";
				}else{
					$conditions['OR'][]  = "Contact.$key LIKE '{$request_data['general_keyword']}'";
				}
			}
		}
		if(!empty($request_data['fair_id'])) {
			$contact_ids = $this->getList('ContactsFair',array(
											'conditions' => array('ContactsFair.fair_id' => $request_data['fair_id']),
											'fields' => array('contact_id','contact_id'),
										));
			$continue_serach = true;
		}
		if(!empty($request_data['characteristics'])) {
			$chars_contact_ids = $this->getList('ContactToContactCharacteristic',array(
				'conditions' => array('contact_characteristic_id' => $request_data['characteristics']),
				'fields' => array('contact_id','contact_id')
			));

			if($continue_serach) {
				$contact_ids = array_intersect($chars_contact_ids, $contact_ids);
			}else{
				$contact_ids = $chars_contact_ids;
			}
			$continue_serach = true;
		}
		if(!empty($request_data['flag'])) {
			$flag_contact_ids = $this->getList('ContactFlag',array(
				'conditions' => array('flag_id' => $request_data['flag'],'active' => '1'),
				'fields' => array('contact_id','contact_id')
			));
			
			if($continue_serach) {
				$contact_ids = array_intersect($flag_contact_ids, $contact_ids);
			}else{
				$contact_ids = $flag_contact_ids;
			}
			$continue_serach = true;
		}
		if(!empty($request_data['company'])) {
			$company_contact_ids = $this->getList('ContactToCompany',array(
				'conditions' => array('company_id' => $request_data['company']),
				'fields' => array('contact_id','contact_id')
			));
			if($continue_serach) {
				$contact_ids = array_intersect($company_contact_ids, $contact_ids);
			}else{
				$contact_ids = $company_contact_ids;
			}
			$continue_serach = true;
		}
		if($continue_serach) {
			$conditions['Contact.id'] = $contact_ids;
		}
		return $conditions;
	}

	public function buildInviteListConditions($request) {
		$conditions = array('InviteList.active' => '1');
		if(!empty($request['fair_category_id'])) {
			$conditions['InviteList.fair_id'] = $this->getList('Fair',array(
				'conditions' => array('fair_category_id' => $request['fair_category_id'],'active' => '1'),
				'fields' => array('id','id')
			));
		}

		if(!empty($request['fair_id'])) {
			$conditions['InviteList.fair_id'] = $request['fair_id'];
		}

		if(!empty($request['name'])) {
			$conditions[] = "InviteList.name LIKE '%{$request['name']}%'";
		}
		return $conditions;
	}
	public function addContactToInviteList($contact_id,$invite_list_id,$options = array()) {
		if(empty($contact_id) || empty($invite_list_id)) {
			return false;
		}
		$temp = array();
		$temp['contact_id'] = $contact_id;
		$temp['invite_list_id'] = $invite_list_id;
		$already_exists = $this->getCount('ContactsInviteList',array(
			'conditions' => array('contact_id' => $contact_id, 'invite_list_id' => $invite_list_id, 'active' => '1')
		));
		if($already_exists < 1) {
			$temp = $temp + $options;
			$this->save('ContactsInviteList',$temp);
		}
	}

	public function log_data($model,$data,$message,$crud,$foreign_key = null) {
		$temp = array();
		$temp['Log']['model'] = $model;
		$temp['Log']['foreign_key'] = $foreign_key;
		$temp['Log']['message'] = $message;
		$temp['Log']['type'] = $crud;
		$temp['Log']['data'] = serialize($data);

		App::uses('Log','DatabaseLogger.Model');
		$logObj = new Log();
		$logObj->create();
		$logObj->save($temp);
		return true;
	}
	public function getCountriesByRegion(){
		$raw_countries = $this->getRecords('Country',array(
			'active' => '1',
			'fields' => array('iso','nicename','region')
		));
		$countries = array();
		foreach ($raw_countries as $key => $value) {
			if(isset($countries[$value['Country']['region']])) {
				$countries[$value['Country']['region']] += array($value['Country']['iso'] => $value['Country']['nicename']);
			}else{
				$countries[$value['Country']['region']] = array($value['Country']['iso'] => $value['Country']['nicename']);
			}
		}
		return $countries;
	}
	public function sendEmail($email_to,$subject,$options = array()){
		$sendAs = isset($options['sendAs']) ? $options['sendAs'] : 'html';
		App::uses('CakeEmail', 'Network/Email');
		$email = new CakeEmail();

		if(isset($options['template'])) {
			$email->template($options['template']);
		}
		if(isset($options['viewVars'])) {
			$email->viewVars($options['viewVars']);
		}
		if(isset($options['attachments'])) {
			$email->attachments($options['attachments']);
		}
		$email_to = trim($email_to);
		if(!filter_var($email_to, FILTER_VALIDATE_EMAIL)) {
			return false;
		}
		$email->config('smtp');
		$email->emailFormat($sendAs);
		$email->from(email_from());
		$email->to($email_to);
		$email->subject($subject);
		if(isset($options['cc_email'])) {
			$email->cc($options['cc_email']);
		}
		if(isset($options['bcc'])) {
			$email->bcc($options['bcc']);
		}
		if($email->send()){
			return true;
		}
		return false;
	}
}