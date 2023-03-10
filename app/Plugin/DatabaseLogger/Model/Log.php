<?php
class Log extends DatabaseLoggerAppModel {
	public $name = 'Log';
	public $displayField = 'type';
	public $searchFields = array('Log.type');
	public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'created_by'
        ),
        'Contact' => array(
            'className' => 'Contact',
            'foreignKey' => 'foreign_key'
        ),
    );
	
	public $actsAs = array('Containable');

	function beforeSave($options = array()){
		$this->data[$this->alias]['ip'] = env('REMOTE_ADDR');
		$this->data[$this->alias]['hostname'] = env('HTTP_HOST');
		$this->data[$this->alias]['uri'] = env('REQUEST_URI');
		$this->data[$this->alias]['refer'] = env('HTTP_REFERER');
		$this->data[$this->alias]['created_by'] = isset($_SESSION['Auth']['User']['id']) ? $_SESSION['Auth']['User']['id'] : null;
		return true;
	}
	
	/**
	* Return a text search on message
	*/
	function textSearch($query = null){
		if($query){
			if(strpos($query, 'type@') === 0){
				$query = str_replace('type@','', $query);
				if(strpos($query, '|')){
					$types = explode('|', $query);
					$retval = array();
					foreach($types as $type){
						$retval['OR'][] = array('Log.type' => $type);
					}
					return $retval;
				} else {
					return array('Log.type' => $query);
				}
			} else {
				$escapedQuery = $this->getDataSource()->value($query);
				return array("MATCH ({$this->alias}.message) AGAINST ($escapedQuery)");
			}
		}
		return array();
	}
	
	/**
	* Return all the unique types
	*/
	function getTypes(){
		$cache_key = 'database_log_types';
		if($retval = Cache::read($cache_key)){
			return $retval;
		}
		$retval = $this->find('all', array(
			'fields' => array('DISTINCT Log.type'),
			'order' => array('Log.type ASC')
		));
		$retval = Hash::extract($retval,'{n}.Log.type');
		Cache::write($cache_key, $retval);
		return $retval;
	}
	
	function search($params = array(), $options = array()){
		$conditions = parent::search($params);
		if(isset($params['start_date']) && !empty($params['start_date'])){
			$params['start_date'] = str_replace('-','/',$params['start_date']);
			$conditions['AND']["Log.created >="] = $this->str2datetime($params['start_date']);
		}
		if(isset($params['end_date']) && !empty($params['end_date'])){
			$params['end_date'] = str_replace('-','/',$params['end_date']);
			$conditions['AND']["Log.created <="] = $this->str2datetime($params['end_date'] . " 23:59:59");
		}

		return $conditions;
	}
}
