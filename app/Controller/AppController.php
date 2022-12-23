<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $components = array('Session','Auth','RequestHandler','Acl');

	public $userID = null;

	public function beforeFilter() {
		$this->logRequest();
		$this->Auth->authenticate = array(
			'Form' => array(
					'userModel' => 'User',
					'fields' => array('username' => 'email'),
					'scope' => array('User.active' => 1)
				)
		);
		$this->Auth->loginRedirect = array('controller' => 'fairs', 'action' => 'index');
		$this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login');
        $this->Auth->authorize = array('Actions' => array('actionPath' => 'controllers'));
        $this->Auth->unauthorizedRedirect = array('action' => 'notAuthorized','controller' => 'users', 'plugin' => null);
        // $this->Auth->allow();
		if( $this->Auth->user() ) {
			if($this->Session->read('Auth.User.role') == 'admin') {
        		$this->Auth->allow();
        	}
			$this->set('first_name',$this->Auth->user('first_name'));
			$this->set('last_name',$this->Auth->user('last_name'));

			$this->set('user_type',$this->Auth->user('role'));
			
            $this->userID = $this->Auth->user('id');
        }
	}

	private function logRequest() {
		App::uses('Browser','Vendor');
		
		$browser = new Browser();
		$ua = array();
		$ua[] = $browser->getPlatform();
		$ua[] = $browser->getBrowser();
		$ua[] = $browser->getVersion();
		$browser = implode(' ',$ua);

		App::uses('SystemLog','Model');
		$systemLogObj = new SystemLog();
		$systemLogObj->id = null;

		$data = array(
			'browser' => $browser,
			'session_id' => $this->Session->id(),
			'referer' => $this->request->referer()
		);
		
		$user = $this->Session->read('Auth.User');
		if( !empty($user['id']) ){
			$data['user_id'] = $user['id'];
			$data['username'] = $user['first_name'].' '.$user['last_name'];
		}
		$data['ip'] = $this->request->clientIp();
		$data['page_url'] = $_SERVER['REQUEST_URI'];
		$data['request'] = !empty($_REQUEST) ? serialize($_REQUEST) : '';
		$systemLogObj->save($data);
	}
}
