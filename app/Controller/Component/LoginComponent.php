<?php
class LoginComponent extends Component{
	var $name = 'Login';
	var $controller = null;
	var $components = array('Cookie','Auth','Session','Acl','ProfileSetup');
    var $uses = array('User');
    var $last_error = null;

	function startup(Controller $controller){
		$this->controller = $controller;
	}

	function setupCookie($data){		
		if(empty($data)){
			return false;
		}

		$this->Cookie->write('Auth.User', $data, true, '+2 weeks');
		return true;
	}

	function readCookie( $initializeUser = true ){		
		$cookie = $this->Cookie->read('Auth.User');
		if (!empty($cookie)) {
			if ($this->Auth->login($cookie)) {
				$this->Session->delete('Message.auth'); //  Clear auth message, just in case we use it.
				//if($userType!='admin'){
					if( $initializeUser ) $this->initialize_user( $this->Auth->user('id') );
					return true;
				//}
				return true;
			} else { // Delete invalid Cookie
				$this->Cookie->delete('Auth.User');
			}
		}
		return false;
	}

	function markAttendance($userID){
		App::import('Model', 'UserAttendance');
		$userAttandanceObj = new UserAttendance();
		$userAttandanceObj->recursive = -1;
		$date = date('Y-m-d');
		$id = $userAttandanceObj->field('id', "user_id = $userID AND attendence_date = '$date' ");
		if(empty($id)){
			$userAttandanceObj->id = null;
			$data['user_id'] = $userID;
			$data['attendence_date'] = $date;
			$userAttandanceObj->save($data);
		}
		return true;
	}

	function isFirstTimeLogin( $userID ){
		App::import('Model','UserLogin');
		$userLoginObj = new UserLogin();
		$userLoginObj->recursive = -1;
		$conditions = array("UserLogin.user_id = '$userID'");
		$countUserLogin = $userLoginObj->find('count',array('conditions'=>$conditions));
		if($countUserLogin == 1){
			return true;
		}
		return false;
	}

	function logLogin( $userID ){
		App::import('model',array('UserLogin'));
		$loginObj = new UserLogin();
		$loginObj->save(array(
			'user_id' => $userID,
			'ip' => $_SERVER['REMOTE_ADDR'],
			'session_id' => session_id()
		));
	}

	function isSessionTimedOut(){
		if( !$this->Auth->user() ){
			return true;
		}
		return false;
		
		if($this->readCookie() ){
			//return false;
		}
		$requestTime = $this->Session->read('last_request_datetime');
		if( !empty($_GET['strSSOSessionID']) ){
			$requestTime = '';
		}
		if( empty($requestTime) ){
			$requestTime = getMicrotime();
			$this->Session->write('last_request_datetime',$requestTime);
		}
		$timeDiff  = round(getMicrotime() - $requestTime,4);
/*		if( $_SERVER['REMOTE_ADDR'] == '202.166.163.194' ){
			if( $timeDiff > 10 ){
				return true;
			}
		}
*/		if( $timeDiff > TIMEOUT_TIME ){
			return true;
		}

		$requestTime = getMicrotime();
		$this->Session->write('last_request_datetime',$requestTime);
		return false;
	}

	function login_tries($data){
		return;
		App::import('Model',array('LoginHistory'));
		$loginHistoryObj = new LoginHistory();
		$tempData = array();
		if(!empty($data['ip_address'])){
			$tempData['ip_address'] = $data['ip_address'];
		}
		if(!empty($data['user_id']) && $data['user_id']){
			$tempData['user_id'] = $data['user_id'];
		}

		$requiredHitTime = LOGIN_ATTEMPT_TIME;
		$currentTime = time();
		$result = $loginHistoryObj->find('first',array('conditions'=>$tempData,'order'=>'created Desc'));
		if(isset($data['success'])){
			$result['LoginHistory']['no_of_hits'] = 0;
			$result['LoginHistory']['hit_time'] = date('Y-m-d H:i:s');
			$result['LoginHistory']['ip_address'] = $tempData['ip_address'];
		}else if (!empty($result) ){
			$hitTime = strtotime($result['LoginHistory']['hit_time']);
			if($requiredHitTime >= ($currentTime - $hitTime)){
				$result['LoginHistory']['no_of_hits'] = $result['LoginHistory']['no_of_hits'] +1;
			}else{
				$result['LoginHistory']['no_of_hits'] = 1;
				$result['LoginHistory']['hit_time'] = date('Y-m-d H:i:s');
			}
		}else{
			$result['LoginHistory']['no_of_hits'] = 1;
			$result['LoginHistory']['hit_time'] = date('Y-m-d H:i:s');
			$result['LoginHistory']['ip_address'] = $tempData['ip_address'];
		}
		if($loginHistoryObj->save($result)){
			return true;
		}
		return false;
	}

	function get_login_tries($ip){
		App::import('Model',array('LoginHistory'));
		$loginHistoryObj = new LoginHistory();
		if(empty($ip)){
			return null;
		}
		$result = $loginHistoryObj->find('first',array('conditions'=>array('ip_address'=>$ip)));
		$requiredHitTime = LOGIN_ATTEMPT_TIME;
		$currentTime = time();
		if (!empty($result) ){
			$hitTime = strtotime($result['LoginHistory']['hit_time']);
			if($requiredHitTime >= ($currentTime - $hitTime)){
				return $result['LoginHistory']['no_of_hits'];
			}
		}
		return 0;
	}
	function logRequest( $controller ){
		global $logRequest;
		if( !$logRequest ){
			return false; // IMPORTANT so that only one log is created per log
		}
		$logRequest = false; // IMPORTANT so that only one log is created per log
		// automatic logging of site
		App::import('vendor','browser');

		$browser = new Browser();
		$ua = array();
		$ua[] = $browser->getPlatform();
		$ua[] = $browser->getBrowser();
		$ua[] = $browser->getVersion();
		$browser = implode(' ',$ua);

		App::uses('SystemLogs','Model');
		$systemLogObj = new SystemLogs();
		$systemLogObj->id = null;

		$data = array(			
			'patient_id' => isset($controller->pid) ? $controller->pid : null,
			'browser' => $browser,
			'session_id' => session_id(),
			'referer' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : ''
		);
		
		$user = $controller->Auth->user();
		if( !empty($user['User']['id']) ){
			$data['user_id'] = $user['User']['id'];
			$data['username'] = $user['User']['first_name'].' '.$user['User']['last_name'];
			$data['user_type'] = $user['User']['user_type'];
		}
		$data['ip'] = $_SERVER['REMOTE_ADDR'];
		$data['page_url'] = $_SERVER['REQUEST_URI'];
		$data['request'] = !empty($_REQUEST) ? serialize($_REQUEST) : '';
		$systemLogObj->save($data);
	}

	function initialize_user($userID){
		$date = date('Y-m-d');
		App::uses('UserAttendance', 'Model');
		App::uses('User', 'Model');
		$userObj = new User();
        $userAttendanceObj = new UserAttendance();
		$userObj->recursive = -1;
		
		$userObj->contain(array('Practice'));
		$user = $userObj->read(null,$userID);
		$this->Session->write('Auth.User.Practice',$user['Practice']);
		
        $userAttendanceObj->markAttendance($userID,$date);
        
		$this->logLogin($userID);
		if( $this->isFirstTimeLogin($userID) ){
			$this->Session->write('Auth.User.first_time_login',true);
		}else{
			$start_date = date('Y-m-d');
			$number_of_days = 6;			
		}

		 $view_array = array('unit_system');
         $unit_system = $this->ProfileSetup->get_sections($userID,$view_array);

		$this->Session->write('Auth.User.unit_system', $unit_system['unit_system']);
		
		
		//diet meals for user
		if( !$this->Session->read('Auth.User.first_time_login') ){
			App::import('model',array('DietMeal'));
			$dietMealObj = new DietMeal();
			$dietMealObj->recursive =   -1;
			$dietID = $user['User']['diet_id'];
			$user_meals = $dietMealObj->find('list',array(
				'conditions'=>"diet_id = $dietID",
				'fields'=>array('sequence', 'name'),
				'order'=>'sequence asc'
				)
			);
			$this->Session->write('Auth.User.user_meals', $user_meals);
		}
		
		//diet meals for user
		$phaseID = $user['User']['phase_id'];

		/*App::import('Model', array('PatientPhasesToFoodExchange', 'FoodExchange'));
		$ppTfexObj = new PatientPhasesToFoodExchange();
		$foodExchange = new FoodExchange();
		
		$ppTfexObj->recursive =  $foodExchange->recursive = -1;
		
		$user_food_exchanges = $ppTfexObj->find('list',array(
			'conditions'=>"patient_phase_id = $phaseID",
			'fields'=>array('food_exchange_id', 'food_exchange_id')
			)
		);
		
		$food_exchanges = $foodExchange->find('all',array(
			'conditions'=>array(
				'id'=>$user_food_exchanges
			)
		));

		$user_food_exchanges = $user_parent_food_exchanges = array();
		foreach($food_exchanges as $fexch){
			$parent_id = !empty($fexch['FoodExchange']['parent_id']) ? $fexch['FoodExchange']['parent_id'] : $fexch['FoodExchange']['id'];
			$user_parent_food_exchanges[$parent_id] = $parent_id;
			$user_food_exchanges[$parent_id][] = $fexch['FoodExchange']['id'];
		}
		
		$user_parent_food_exchanges = $foodExchange->find('list',array(
			'conditions'=>array(
				'id'=>$user_parent_food_exchanges
			),
			'fields'=>array('id', 'name'),
			'order'=>'name'
		));
		
		//debug($user_parent_food_exchanges);	debug($user_food_exchanges); exit;
		
		$this->Session->write('Auth.User.user_parent_food_exchanges', $user_parent_food_exchanges);
		$this->Session->write('Auth.User.user_food_exchanges', $user_food_exchanges);*/
		
		//phase and food exchanges getting code ends here
		
		
//////////////getting optimal food groups and diet protocol id

		/*App::uses('UserToDietProtocol', 'Model');
		App::uses('DietProtocolsToCustomGroup', 'Model');
		$uTDPObj = new UserToDietProtocol();
		$dPTCGObj = new DietProtocolsToCustomGroup();
		
		$diet_protocol_id = $uTDPObj->field('diet_protocol_id', "user_id = $userID AND is_current = 1");
		$this->Session->write('Auth.User.diet_protocol_id', $diet_protocol_id);
		$dPTCGData =array();
		if(!empty($diet_protocol_id)){
			$dPTCGObj->contain('CustomGroup');
			$dPTCGData = $dPTCGObj->find('all', array(
				'conditions'=>array("DietProtocolsToCustomGroup.diet_protocol_id = $diet_protocol_id AND DietProtocolsToCustomGroup.type = 'optimal'")		
			));
		}
		
		$optimal_food_groups = array();
		foreach($dPTCGData as $dpg){
			$optimal_food_groups[$dpg['DietProtocolsToCustomGroup']['custom_group_id']] = $dpg['CustomGroup']['name'];
		}
		
		$this->Session->write('Auth.User.optimal_food_groups', $optimal_food_groups);
		*/
		
		App::import('Model', array('FoodExchange'));
		$foodExchange = new FoodExchange();
		$food_exchanges =  $foodExchange->getExchanges();
		$this->Session->write('food_exchanges', $food_exchanges);
		
//////////////getting optimal food groups and diet protocol id ends here

		$weight_unit = ($unit_system['unit_system'] == 'us') ? 'lbs' : 'kg';
		$height_unit = ($unit_system['unit_system'] == 'us') ? 'inches' : 'cm';
		$this->Session->write('Auth.User.weight_unit', $weight_unit);
		$this->Session->write('Auth.User.height_unit', $height_unit);

		return true;
	}

    function getActionModuleMapping() {
        $mapping = Cache::read('action_module_mapping');
        if (empty($mapping)) {
            App::import('Model', 'AppPermission');
            $AppPermissionObj = new AppPermission();
            $result = $AppPermissionObj->find('all', array('contain' => array('Aco.alias')));

            foreach($result as $record) {
                $crud = array();
                if($record['AppPermission']['_create'] == 1) {
                    $crud[] = '_create';
                }
                if($record['AppPermission']['_read'] == 1) {
                    $crud[] = '_read';
                }

                if($record['AppPermission']['_update'] == 1) {
                    $crud[] = '_update';
                }
                if($record['AppPermission']['_delete'] == 1) {
                    $crud[] = '_delete';
                }

                $moduleInfo = array('module' => $record['Aco']['alias'], 'actions' => array($record['AppPermission']['method_name'] => $crud));
                $mapping[$record['AppPermission']['controller_name']][$record['AppPermission']['method_name']] = $moduleInfo;
            }

            Cache::write('action_module_mapping', $mapping);
        }

        return $mapping;
    }

	function getCrudPermissions($aroAlias, $acoAlias) {		
        $allowed = $this->Acl->check($aroAlias, $acoAlias, '*');
        if($allowed) {
            $arr['AcoPath']['alias'] = $acoAlias;
            $arr['aros_acos'] = array('_create' => 1, '_read' => 1, '_update' => 1, '_delete' => 1);
        }else {
            /*$arr['AcoPath']['alias'] = $acoAlias;
			$arr['aros_acos'] = array('_create' => '-1', '_read' => '-1', '_update' => '-1', '_delete' => '-1');*/
            $crud['_create'] = ($this->Acl->check($aroAlias, $acoAlias, 'create') ? '1' : '0');
            $crud['_read'] = ($this->Acl->check($aroAlias, $acoAlias, 'read') ? '1' : '0');
            $crud['_update'] = ($this->Acl->check($aroAlias, $acoAlias, 'update') ? '1' : '0');
            $crud['_delete'] = ($this->Acl->check($aroAlias, $acoAlias, 'delete') ? '1' : '0');
            $arr['AcoPath']['alias'] = $acoAlias;
            $arr['aros_acos'] = $crud;
        }
        return $arr;
    }

	function getPermissions($AroAlias){
		$finalPermissions = array();
		if(!empty($AroAlias))
		{
			$permissions = array();
			$acosList = $this->Acl->Aco->find('list', array('fields' => array('id','alias'), 'recursive' => '-1'));
			
			foreach($acosList as $key => $AcoAlias)
			{
				$crudInfo = $this->getCrudPermissions($AroAlias, $AcoAlias);
				$crud['crud_info'] = $crudInfo;
				$crud['aco_id'] = $key;
				$permissions[$AcoAlias] = $crud;
			}

			$arrName = 'tabsInfo';
			$index = 0;

			foreach($permissions as $key => $permission)
			{
				//if(in_array(1, $permission['crud_info']['aros_acos']))
				if($permission['crud_info']['aros_acos']['_read'] == '1')
				{
					$pathInfo = $this->Acl->Aco->getPath($permission['aco_id'], array('alias'));
					$pathStr = '';
					foreach($pathInfo as $thisPath)
					{
						$pathStr .= '[\''.$thisPath['Aco']['alias'].'\']';
					}

					eval('$'.$arrName.$pathStr." = '';");
				}

				$finalPermissions[$key] = $permission['crud_info']['aros_acos'];
			}
		}
		return $finalPermissions;
	}



    function h2_validate_member_credentials($username, $password){
		App::import('model',array('User'));
		$this->User = new User();
        $this->User->recursive = -1;        
		$password = $this->Auth->password($password);
        $userData = $this->User->find('first',array('conditions'=>array('User.password' => $password,'OR' => array('User.username'=>$username, 'User.email' =>$username)),'fields'=>array('User.id','User.active','User.deleted')));
        if( !empty($userData) ){
            return $userData;
        }
        return false;
    }	

	function update_member($data){
		if( empty($data['member_id']) ){
			return false;
		}
		App::import('model',array('User'));
		$userObj = new User();
		$userObj->recursive = -1;
		App::import('Component', array('Progress'));
    	//$this->Session = new SessionComponent();'Session',
    	$this->Progress = new ProgressComponent();
    	
		$conditions = array('member_id' => $data['member_id']);
		$member = $userObj->find('first',array(
			'conditions' => $conditions
		));

		if(empty($member)){
			$data['uuid'] = String::uuid();
			$data['user_type'] = 'patient';
			$data['active'] = '1';
			$data['profile_steps'] = '0';
			$data['profile_completed'] = '0';
			
			$userData['User'] = $data;
			if( $userObj->save($userData) ){
				$lastInsertedID =$userObj->id;
				//$start_date = !empty($data['start_date'])?$data['start_date']:date('Y-m-d');
				//$this->Progress->saveMeasures(array('weight'=>$data['startweight']),$lastInsertedID,$start_date);
				$last_weight_date = !empty($data['lastweightindate'])?date('Y-m-d',strtotime($data['lastweightindate'])):date('Y-m-d');
				if(!empty($data['currentweight'])){
					$this->Progress->saveMeasures(array('weight'=>$data['currentweight']),$lastInsertedID,$last_weight_date);					
				}

				$userObj->recursive = 1;
				return $userObj->read();
			}
			
		}else{
		
			$data['id'] = $member['User']['id'];
			$userObj->id = $data['id'];
			
			$userData['User'] = $data;
			if(empty($member['User']['profile_completed'])){
				$userData['User'] = $data;
				if( $userObj->save($userData) ){
					$lastInsertedID =$userObj->id;
					$last_weight_date = !empty($data['lastweightindate'])?date('Y-m-d',strtotime($data['lastweightindate'])):date('Y-m-d');
					if(!empty($data['currentweight'])){
						$this->Progress->saveMeasures(array('weight'=>$data['currentweight']),$lastInsertedID,$last_weight_date);					
					}
	
					$userObj->recursive = 1;
					return $userObj->read();
				}
			}
		
			//writing session here just for comparison to show alert on dashboard
			$this->Session->write('mercola_site_nutrition_type', $data['nutrition_type']);
			/*if($member['User']['nutrition_type'] != $data['nutrition_type']){
				$this->update_nutrition_type($member['User']['id'],$data);
			}*/
			$this->update_users_nutrition_type($member['User']['id']);

			$userObj->recursive = 1;
			return $userObj->read();
		}		
		return false;
	}
	function logout(){		
		if( ENABLE_SSO ){
			
		}
		//$this->Cookie->delete('Auth.User');
		$this->Session->destroy();
	}
	
	function ma_build_request($data){
		$xml = '';
		foreach($data as $key=>$value){
			$xml .="<key name='$key'>
						<value>$value</value>
					</key>";
		}
		
		return "<?xml version='1.0' encoding='utf-8' ?>
				<data>
				<struct>
					$xml
				</struct>
				</data>";
	}
	
	function ma_soa_call($url,$data){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt($ch, CURLOPT_POST,           1 );		
		curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: text/xml')); 
		curl_setopt($ch, CURLOPT_POSTFIELDS,     $data ); 
		return curl_exec ($ch);
	}
	
	function ma_authenticate( $userID, $password ){
		$request = $this->ma_build_request(array(
			'usrID' => $userID,
			'usrPwd' => $password,
			'site' => 'T'
		));
		
		$response = $this->ma_soa_call('http://soa.marketamerica.com/1.0/yourVendorCode/eng/xml/security/authenticate/',$request);
		
		App::import('Xml'); 
		// now parse it 
		$parsed_xml =& new XML($response); 
		$parsed_xml = Set::reverse($parsed_xml); // this is what i call magic 
		$parsed_xml = Set::extract('Data.Struct.Key.Struct.Key.{n}',$parsed_xml);
		if(!$parsed_xml){
			return false;
		}
		$data = array();
		foreach($parsed_xml as $row){
			$data[$row['name']] = isset($row['value']) ? $row['value'] : $row['Value'] ;
		}
		$data_array = array(
			'prdCountry' => 'product_country',
			'isDistributorshipPC' => 'is_coach',
			'fName' => 'first_name',
			'lName' => 'last_name',
			'pcID' => 'member_id'
		);
		
		$results = array();
		foreach($data_array as $k=>$v){
			$results[$v] = $data[$k];
		}
		
		if($data['svrStatus'] == '0' && empty($data['svrMessage']) ){
			return $results;
		}else{
			return false;
		}
	}
	
	function ma_get_profile( $pcID ){
		$request = $this->ma_build_request(array(
			'pcID' => $pcID,
			'distId' => '',
			'site' => 'T'
		));
		$response = $this->ma_soa_call('http://soa.marketamerica.com/1.0/mis/eng/xml/profile/profileLong/',$request);

		App::import('Xml'); 
		// now parse it 
		$parsed_xml =& new XML($response); 
		
		$parsed_xml = Set::reverse($parsed_xml); // this is what i call magic 
		$parsed_xml = Set::extract('Data.Struct.Key.Struct.Key.{n}',$parsed_xml);
		
		$data = array();
		foreach($parsed_xml as $row){
			if( isset($row['Value']) ){
				$data[$row['name']] = $row['Value'];
			}else if( isset($row['value']) ){
				$data[$row['name']] = $row['value'];
			}
		}
		
		if($data['svrStatus'] == '0' && empty($data['svrMessage']) ){
			// do nothing
		}else{
			return false;
		}
		
		$data_array = array(
			'prdCountry' => 'product_country',
			'distributorshipPc' => 'is_coach',
			'firstName' => 'first_name',
			'lastName' => 'last_name',
			'distID' => 'distributor_id',
			'siteCountry' => 'site_country',
			'email' => 'email'
		);
		
		$results = array();
		foreach($data_array as $k=>$v){
			$results[$v] = $data[$k];
		}
		
		return $results;		
	}
	
	function ma_decrypted($string){
		$request = $this->ma_build_request(array(
			'decryptString' => $string
		));
		$response = $this->ma_soa_call('http://soa.marketamerica.com/1.0/mis/eng/xml/services/decryptedStringData/',$request);

		App::import('Xml'); 
		// now parse it 
		$parsed_xml =& new XML($response); 
		
		$parsed_xml = Set::reverse($parsed_xml); // this is what i call magic 		
		$parsed_xml = Set::extract('Data.Struct.Key.Struct.Key.{n}',$parsed_xml);
		
		$tokens = explode(',',$parsed_xml[0]['value']);
		if( count($tokens) == 2 ){
			return array(
				'member_id' => $tokens[0],
				'password' => $tokens[1],
			);
		}
		return false;		
	}
	
	function ma_has_subscription($member_id){
		return false;
	}	  
	
	
	function ma_check_login(){		    	
		$site_cookie = '';		
		if( isset($_COOKIE[SITE_COOKIE]) ){
			$site_cookie = $_COOKIE[SITE_COOKIE];
		}		
		if( $this->Auth->user() && $site_cookie != $this->Session->read('Auth.User.site_cookie')){
			
			$this->logout();
			return;
		}
    	if(!$this->Auth->user('id') && $site_cookie != '' ){
			//debug($_SESSION);
    		$this->ma_cookie_login($site_cookie);			
    	}
		return;
    	//return false;
    }
    
    function ma_cookie_login($site_cookie){		
		$auth = $this->ma_decrypted(urldecode($site_cookie));
		if ( !$auth = $this->ma_decrypted(urldecode($site_cookie)) ){
			return false;
		}
		if(empty($auth['member_id']) || empty($auth['password']) ){
			return false;
		}
		//$auth['member_id'] = '2826022';
		//$auth['password']  = 'AMERICA';
		if ( !$memberData = $this->ma_authenticate($auth['member_id'],$auth['password'])){
			return false;
		}
		$hasSubscribe = $this->ma_has_subscription($auth['member_id']);
		
		App::import('Model','User');
		$userObj = new User();
		$userObj->recursive = -1;
		$userData = $userObj->find('first', array('conditions' => array('member_id' => $auth['member_id']) ) );
		if(empty($userData['User'])){			
			$userObj->create();
			$userData['User']['id'] = nulll;
			$userData['User']['uuid'] = String::uuid();			
		}
		$userData['User']['member_id']   =  $auth['member_id'];			
		$userData['User']['first_name']  =  $memberData['first_name'];
		$userData['User']['last_name']   =  $memberData['last_name'];
		$userData['User']['is_coach']    =  ($memberData['is_coach']) ? 'true' : 'false';
		$userData['User']['country']     =   $memberData['product_country'];		
		$userObj->save($userData);
		
		if($hasSubscribe){
			$userObj->recursive = -1;
			$user = $userObj->read();
			$user['User']['site_cookie'] = $site_cookie;
			$this->Session->write('Auth.User',$user['User']);
			$this->initialize_user($userObj->id);			
			//debug($_SESSION);
			//exit();			
			return true;
		}
		return false;
	}
	
	function set_employee_permissions($user_id){
		$utrObj = ClassRegistry::init('UserTrainerRoles');
		$utrObj->recursive = -1;
		
		$traObj = ClassRegistry::init('TrainerRoleActions'); 
		$traObj->recursive = -1;
		
		$taObj = ClassRegistry::init('TrainerActions');
		$taObj->recursive = -1;
		
		$roles_ids = array();
		$slugs = array();
		$roles = $utrObj->find('all', array(
					'conditions'=> array('UserTrainerRoles.user_id'=>$user_id),
					'fields'=>array('UserTrainerRoles.trainer_role_id')
				));
		foreach($roles as $r){
			$roles_ids[] = $r['UserTrainerRoles']['trainer_role_id'];
		}
		$action_ids = array();
		$action = $traObj->find('all', array(
					'conditions'=> array('TrainerRoleActions.trainer_role_id'=>$roles_ids),
					'fields'=>array('TrainerRoleActions.trainer_action_id')
				));
		foreach($action as $r){
			$action_ids[] = $r['TrainerRoleActions']['trainer_action_id'];
		}
		
		$action_slugs = $taObj->find('all', array(
					'conditions'=> array('TrainerActions.id'=>$action_ids),
					'fields'=>array('TrainerActions.slug')
				));
		foreach($action_slugs as $r){
			$slugs[$r['TrainerActions']['slug']] = $r['TrainerActions']['slug'];
		}
		
		if(!empty($slugs)){
			$this->Session->write('Auth.User.trainer_permissions',$slugs);                
			$this->controller->trainer_perm = $slugs;	
		}
	}
	
}
?>