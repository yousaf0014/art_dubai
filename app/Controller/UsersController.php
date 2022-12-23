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

class UsersController extends AppController{

/**
 * Controller name.
 *
 * @var string
*/
	public $name = 'Users';

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
		$this->Auth->allow('login','logout','notAuthorized','admin_notAuthorized','forgot_password','reset_password');
		$this->set('title_for_layout','Art Dubai');
	}

	//login function
	public function login() {
		$this->layout = 'login';

		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
	            return $this->redirect($this->Auth->redirectUrl());
	        } else {
	            $this->Session->setFlash(__('Username or password is incorrect'), 'default', array(), 'login_error');
	        }
	    }
	}

	//logout function
	public function logout() {
		 return $this->redirect($this->Auth->logout());
	}

	public function departments() {
		$departments = $this->FairManagement->paginateRecords('Department',array(
			'conditions' => array('active' => '1')
		));
		$this->set(compact('departments'));
	}

	public function addDepartment() {
		$uuid = isset($this->request->query['ID']) ? $this->request->query['ID'] : '';
		if($this->request->is('post') && !empty($this->request->data)) {
			$this->FairManagement->save('Department',$this->request->data['Department'],array('uuid' => $uuid));
			$this->redirect('/Users/departments');
			exit;
		}
		$department = array();
		if(!empty($uuid)) {
			$department = $this->FairManagement->getRecords('Department',array('uuid' => $uuid));
		}
		$this->set(compact('department','uuid'));
	}

	public function deleteDepartment() {
		$uuid = $this->request->query['ID'];
		$this->FairManagement->makeInactive('Department',array('uuid' => $uuid));

		$this->redirect($this->referer());
		exit;
	}
	
	public function employees() {
		$employees = $this->FairManagement->paginateRecords('User',array(
				'conditions' => array('User.active' => '1','User.role' => 'employee')
			));
		$this->set(compact('employees'));
	}
	
	public function addEmployee() {
		$uuid = isset($this->request->query['UID']) ? $this->request->query['UID'] : '';

		if($this->request->is('post') && $this->request->data) {
			//$this->FairManagement->validateUser($this->request->data);
			$data = $this->request->data;
			$data['User']['role'] = 'employee';
			if(!empty($data['User']['password'])) {
				$data['User']['password'] = $this->Auth->password($data['User']['password']);
			}
			if(empty($data['User']['password'])) {
				unset($data['User']['password']);
			}
			$this->FairManagement->save('User',$data['User'],array('uuid' => $uuid));
			$this->redirect(array('controller' => 'users' ,'action' => 'employees', 'plugin' => null));
			exit;
		}
		$departments = $this->FairManagement->getList('Department',array(
			'conditions' => array('active' => '1')
		));
		$fair_categories = $this->FairManagement->getList('FairCategory',array(
			'conditions' => array('active' => '1')
		));
		$employee = array();
		if(!empty($uuid)) {
			$employee = $this->FairManagement->getRecords('User',array('User.uuid' => $uuid));
		}
		$roles = $this->FairManagement->getList('Role',array(
			'conditions' => array('active' => '1')
		));
		$this->set(compact('departments','employee','uuid','roles','fair_categories'));
	}

	public function deleteEmployee() {
		$uuid = $this->request->query['UID'];
		$this->FairManagement->makeInactive('User',array('uuid' => $uuid));

		$this->redirect($this->referer());
		exit;
	}

	public function check($field,$uuid = ''){
		$valid_fields = array('username' => 'username','email' => 'email');
		$value = $this->request->query['data']['User'][$field];
		
		if(isset($valid_fields[$field])) {
			$conditions = array((String)$field => $value,'User.active' => '1');
			if(!empty($uuid)) {
				$conditions[] = "User.uuid <> '$uuid'";
			}

			$count = $this->FairManagement->getCount('User',array(
				'conditions' => $conditions
			));
			if($count) {
				echo 'false';
				exit;
			}
		}
		echo 'true';
		exit;
	}

	public function roles() {
		$roles = $this->FairManagement->paginateRecords('Role',array(
			'conditions' => array('active' => '1')
		));
		$this->set(compact('roles'));
	}

	public function addRole() {
		$uuid = isset($this->request->query['RID']) ? $this->request->query['RID'] : '';
		if($this->request->is('post') && !empty($this->request->data)) {
			$this->FairManagement->save('Role',$this->request->data['Role'],array('uuid' => $uuid));
			$this->redirect('/users/roles');
			exit;
		}
		$role = array();
		if(!empty($uuid)) {
			$role = $this->FairManagement->getRecords('Role',array('uuid' => $uuid));
		}
		$this->set(compact('role','uuid'));
	}

	public function deleteRole() {
		$uuid = $this->request->query['RID'];
		$this->FairManagement->makeInactive('Role',array('uuid' => $uuid));

		$this->redirect($this->referer());
		exit;
	}
	
	public function notAuthorized(){
			
	}
	public function admin_notAuthorized(){
		$this->redirect('/users/notAuthorized');
	}
	public function admin_login() {
		$this->redirect('/users/login');
	}

	public function forgot_password() {
		$this->layout = 'login';
		if(!empty($this->request->data['User']['email'])) {
			$this->request->data['User']['email'] = trim($this->request->data['User']['email']);
			App::uses('User','Model');
			$userObj = new User();

			$user = $userObj->find('first',array(
				'conditions' => array('email' => $this->request->data['User']['email']),
				'recursive' => '-1',
				'fields' => array('id','first_name','last_name','email')
			));
			
			if(!empty($user)) {
				App::uses('EmailInvite','Model');
				$eiObj = new EmailInvite();

				$hash = String::uuid();

				$temp = array(
					'user_id' => $user['User']['id'],
					'hash' => $hash,
					'is_clicked' => null 
				);
				$eiObj->save($temp);

				$emil = $user['User']['email'];

				$subject = SITE_NAME.': Password reset link';

				$name = $user['User']['first_name'].' '.$user['User']['last_name'];

				$message = "<p><strong>Dear $name </strong></p>";

				$message .= '<p>Please click on the link below to proceed with password reset.</p>';

				$message .= Router::url('/',true).'ResetPassword?link='.$hash;

				$options['viewVars'] = array('message' => $message);
				$options['template'] = 'custom';

				if($this->FairManagement->sendEmail($emil,$subject,$options)) {
					$this->Session->setFlash('Password reset link has been sent. Please check your email','happy', array(), 'message');
				}else{
					$this->Session->setFlash('Error sending email','warning', array(), 'message');
				}

				$this->redirect($this->referer());
				exit;
			}else{
				$this->Session->setFlash('Email does not exists in system','warning', array(), 'message');
			}
		}
	}

	public function reset_password() {
		$this->layout = 'login';
		$link = isset($this->request->query['link']) ? $this->request->query['link'] : null;

		$is_valid_link = 'valid';
		$passowrd_error = '';

		App::uses('EmailInvite','Model');
		$eiObj = new EmailInvite();

		$emailInvite = $eiObj->find('first',array(
			'conditions' => array('hash' => $link)
		));
			
		if(!empty($this->request->data) && empty($emailInvite['EmailInvite']['is_clicked'])) {
			$password = $this->request->data['User']['password'];
			$cpassword = $this->request->data['User']['password'];

			if(strlen($password) < 8) {
				$passowrd_error = 'password_length';
			}
			elseif($password !== $cpassword) {
				$passowrd_error = 'passowrd_mismatch';
			}

			if(empty($passowrd_error)) {
				App::uses('User','Model');
				$userObj = new User();

				App::uses('AuthComponent','Controller/Component');
				$authObj = new AuthComponent(new ComponentCollection());

				$password = $authObj->password($password);

				$userObj->id = $emailInvite['EmailInvite']['user_id'];
				
				$userObj->saveField('password',$password);

				$eiObj->create();
				$eiObj->id = $emailInvite['EmailInvite']['id'];
				$eiObj->saveField('is_clicked','1');

				$this->Session->setFlash('Password reset successfully','happy',array(),'message');

				$this->redirect($this->referer().'&success=1');
				exit;
			}
		}

		if(empty($emailInvite)) {
			$is_valid_link = 'invalid_link';
		}

		if(!empty($emailInvite['EmailInvite']['is_clicked'])) {
			$is_valid_link = 'expired_link';
		}

		$this->set(compact('link','is_valid_link','passowrd_error'));
	}
}