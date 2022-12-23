<?php

class UtilitiesController extends AclAppController {
	public $name = 'Utilities';

	public function admin_action_names() {
		$actions = $this->AclReflector->get_all_actions();

		$methods = array();
		foreach($actions as $k => $full_action)
    	{
	    	$arr = String::tokenize($full_action, '/');
	    	
			if (count($arr) == 2)
			{
				$plugin_name     = null;
				$controller_name = $arr[0];
				$action          = $arr[1];
			}
			elseif(count($arr) == 3)
			{
				$plugin_name     = $arr[0];
				$controller_name = $arr[1];
				$action          = $arr[2];
			}
			
			if($controller_name == 'App')
			{
			    unset($actions[$k]);
			}
			else
			{
				$aco = $this->AclManager->getAco($controller_name,$action);
				$alias = isset($aco['Aco']['name']) ? $aco['Aco']['name'] : '';
        		if(isset($plugin_name))
                {
                	$methods['plugin'][$plugin_name][$controller_name][] = array('name' => $action, 'alias' => $alias);
                }
                else
                {
            	    $methods['app'][$controller_name][] = array('name' => $action, 'alias' => $alias);
                }
			}
    	}
    	$this->set('methods',$methods);
	}

	public function admin_edit_alias($controller = '',$action = '') {
		if(!empty($this->request->data)) {
			$this->Acl->Aco->id = $this->request->data['Aco']['id'];
			$this->Acl->Aco->saveField('name',$this->request->data['Aco']['name']);

			$this->redirect('/admin/acl/utilities/action_names');
			exit;
		}
		$aco = $this->AclManager->getAco($controller,$action);
		if(empty($aco)) {
			$this->redirect('/admin/acl/acos/synchronize');
			exit;
		}
		$this->set(compact('aco'));
	}

	public function admin_aros_groups() {
		$aros_groups = $this->Acl->Aro->find('all',array(
			'conditions' => array('model' => 'AcoGroup'),
			'recursive' => '-1'
		));

		$this->set(compact('aros_groups'));
	}
	public function admin_add_group($id = null) {
		if(!empty($this->request->data)) {
			$this->request->data['Aro']['model'] = 'AcoGroup';
			$this->Acl->Aro->save($this->request->data);
			if(isset($this->request->query['redirect'])) {
				$this->redirect($this->request->query['redirect']);
				exit;
			}
			$this->redirect('/admin/acl/utilities/aros_groups');
			exit;
		}
		$aro = array();
		if(!empty($id)) {
			$aro = $this->Acl->Aro->find('first',array(
				'conditions' => array('id' => $id)
			));
		}

		$this->set(compact('aro'));
	}

	public function admin_add_actions_to_group($groupID) {
		App::uses('AcosGroup','Model');
		$acoGroupObj = new AcosGroup();
		if(!empty($this->request->data) && !empty($groupID)) {
			$acoGroupObj->deleteAll(array('aro_id' => $groupID));
			foreach ($this->request->data['AcoGroup'] as $key => $value) {
				$acoGroupObj->create();
				$temp = explode('_', $value);
				$temp_data = array();
				$temp_data['aro_id'] = $groupID;
				$temp_data['aco_id'] = $temp[0];
				$temp_data['path'] = $temp[1].'/'.$temp[2];
				$acoGroupObj->save($temp_data);
			}
			if(!empty($this->request->query['redirect'])) {
				$this->redirect($this->request->query['redirect']);
				exit;
			}
			$this->redirect('/admin/acl/utilities/aros_groups');
			exit;
		}
		$selected = $acoGroupObj->find('list',array(
			'conditions' => array('aro_id' => $groupID),
			'fields' => array('aco_id','aco_id')
		));
		$acos = $this->Acl->Aco->find('threaded',array(
			'conditions' => array('parent_id IS NOT NULL'),
			'recursive' => '-1'
		));
		
		$this->set(compact('acos','groupID','selected'));
	}
}