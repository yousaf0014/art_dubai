<?php
App::uses('Component', 'Controller');
class TreesManagementComponent extends Component {
	function startup(Controller $controller){
		$this->controller = $controller;
	}

	function getFlatArrOfChilds($parameters = array())
	{
		$parent_id = isset($parameters['parent_id']) ? $parameters['parent_id'] : 0; // default parent_id is 0
		$include_parent = isset($parameters['include_parent']) ? $parameters['include_parent'] : true; // by default include parent too
		$conditions = isset($parameters['conditions']) ? $parameters['conditions'] : null; // default conditions are null
		$ModelName = isset($parameters['model_name']) ? $parameters['model_name'] : 'Category'; // default Model Name is Category
		$fields = isset($parameters['fields']) ? $parameters['fields'] : null; // default fields are ALL
		$order = isset($parameters['order']) ? $parameters['order'] : $ModelName.'.lft ASC'; // by default will be sorted on the basis of lft field
		$limit = isset($parameters['limit']) ? $parameters['limit'] : getConfigValByKey('RECORDS_PER_PAGE'); 
		$page = isset($parameters['page']) ? $parameters['page'] : null; // by default all pages will be returned
		$pagination = isset($parameters['paginate']) ? $parameters['paginate'] : false; // by default no pagination will be applied
		$recursive = isset($parameters['recursive']) ? $parameters['recursive'] : null; // by default not get recursive records
		$contains = isset($parameters['contains']) ? $parameters['contains'] : false; // by default nothing contains


		$ModelInstance = ClassRegistry::init($ModelName);
		$ModelInstance->recursive = $recursive;
		if($contains){
			$ModelInstance->Behaviors->attach('Containable');
		}



		if(empty($parent_id))
		{
			if($pagination){

				if($contains){
					$this->controller->paginate[$ModelName] = array('contain' => $contains, 'limit' => $limit, 'order' => $order, 'fields' => $fields);
				}

				$its_childs = $this->controller->paginate($ModelName, $conditions, $fields, $order);
			}else{

				if($contains){
					$ModelInstance->contain($contains);
				}

				$its_childs = $ModelInstance->find('all', array('conditions' => $conditions, 'fields' => $fields, 'order' => $order, 'limit' => $limit, 'page' => $page));
			}

			return $its_childs;

		}else{

			$member_info = $ModelInstance->find("$ModelName.id = $parent_id", array($ModelName.'.lft',$ModelName.'.rght'));
			$left = $member_info[$ModelName]['lft'];
			$right = $member_info[$ModelName]['rght'];

			if(empty($conditions)){

				if($include_parent){
					$conditions = "$ModelName.lft >= $left AND $ModelName.rght <= $right";
				}else{
					$conditions = "$ModelName.lft > $left AND $ModelName.rght < $right";
				}


			}else{

				if($include_parent){
					$conditions .= " AND $ModelName.lft >= $left AND $ModelName.rght <= $right";
				}else{
					$conditions .= " AND $ModelName.lft > $left AND $ModelName.rght < $right";
				}
			}


			if($pagination){

				if($contains){
					$this->controller->paginate[$ModelName] = array('contain' => $contains, 'limit' => $limit, 'order' => $order, 'fields' => $fields);
				}

				$its_childs = $this->controller->paginate($ModelName, $conditions, $fields);
			}else{

				if($contains){
					$ModelInstance->contain($contains);
				}
				$its_childs = $ModelInstance->find('all', array('conditions' => $conditions, 'fields' => $fields, 'order' => $order, 'limit' => $limit, 'page' => $page));
			}

			return $its_childs;
			/*$childsArr = array();
			if(empty($its_childs))
			{
				return array();

			}else{

				foreach($its_childs as $this_child)
				{
					$parents = $ModelInstance->getPath($this_child[$ModelName]['id']);

					foreach($parents as $this_parent)
					{
						if($this_parent[$ModelName]['id'] == $parent_id)
						{
							$childsArr[] = $this_child;
							break;
						}
					}
				}
				return $childsArr;
			}*/
		}
	}

	function getChildsCount($parameters = array())
	{
		$parent_id = isset($parameters['parent_id']) ? $parameters['parent_id'] : 0; // default parent_id is 0
		$conditions = isset($parameters['conditions']) ? $parameters['conditions'] : null; // default conditions are null
		$ModelName = isset($parameters['model_name']) ? $parameters['model_name'] : 'Category'; // default Model Name is Category
		$recursive = isset($parameters['recursive']) ? $parameters['recursive'] : null; // by default not get recursive records

		$ModelInstance = ClassRegistry::init($ModelName);
		$ModelInstance->recursive = $recursive;

		if(empty($parent_id))
		{
			$childsCount = $ModelInstance->find('count', array('conditions' => $conditions));
			return $childsCount;

		}else{

			$member_info = $ModelInstance->find("$ModelName.id = $parent_id", array($ModelName.'.lft',$ModelName.'.rght'));
			$left = $member_info[$ModelName]['lft'];
			$right = $member_info[$ModelName]['rght'];

			if(empty($conditions)){
				$conditions = "$ModelName.lft >= $left AND $ModelName.rght <= $right";
			}else{
				$conditions .= " AND $ModelName.lft >= $left AND $ModelName.rght <= $right";
			}

			$childsCount = $ModelInstance->find('count', array('conditions' => $conditions));
			return $childsCount;
		}
	}

	// returns threaded data, generated on the bases of provided information
	function getTree( $parameters = array() )
	{
		$parent_id = isset($parameters['parent_id']) ? $parameters['parent_id'] : 0; // default parent_id is 0
		$conditions = isset($parameters['conditions']) ? $parameters['conditions'] : null; // default conditions are null
		$ModelName = isset($parameters['model_name']) ? $parameters['model_name'] : 'Category'; // default Model Name is Category
		$fields = isset($parameters['fields']) ? $parameters['fields'] : null; // default fields are ALL
		$order = isset($parameters['order']) ? $parameters['order'] : $ModelName.'.lft ASC'; // by default will be sorted on the basis of lft field
		$recursive = isset($parameters['recursive']) ? $parameters['recursive'] : null; // by default not get recursive records
		$generate_name_with_fields = isset($parameters['generate_name_with_fields']) ? $parameters['generate_name_with_fields'] : 'name'; // by default generate category name with 'name' field
		$fields_separator = isset($parameters['fields_separator']) ? $parameters['fields_separator'] : ' '; // by default fields separator is space (' ')
		$return = isset($parameters['return']) ? $parameters['return'] : 'data'; // by default data will be returned. Possible values are treeview, tabular and graphical and data
		$contains = isset($parameters['contains']) ? $parameters['contains'] : false; // by default nothing contains


		$ModelInstance = ClassRegistry::init($ModelName);
		$ModelInstance->recursive = $recursive;

		if(!empty($parent_id))
		{
			$member_info = $ModelInstance->find("$ModelName.id = $parent_id", array($ModelName.'.lft',$ModelName.'.rght'));
			$left = $member_info[$ModelName]['lft'];
			$right = $member_info[$ModelName]['rght'];

			if(empty($conditions))
			{
				$conditions = "$ModelName.lft >= $left AND $ModelName.rght <= $right";

			}else{

				$conditions .= " AND $ModelName.lft >= $left AND $ModelName.rght <= $right";
			}
		}

		if($contains){
			$ModelInstance->Behaviors->attach('Containable');
			$ModelInstance->contain($contains);
		}


		$allNodes = $ModelInstance->find('threaded', array('conditions' => $conditions, 'fields' => $fields, 'order' => $order));
		//debug($allNodes); exit;
		//$formatted_data = $this->formatTreeData($allNodes, $ModelName);
		$return = strtolower($return); // convert to lowercase

		if($return == 'treeview')
		{
			$params['data'] = $allNodes;
			$params['model_name'] = $ModelName;
			$params['generate_name_with_fields'] = $generate_name_with_fields;
			$params['fields_separator'] = $fields_separator;
			return $this->getTreeViewHtml($params);

		}/*elseif($return == 'tabular'){

		}elseif($return == 'graphical'){

		}*/

		return $allNodes;
	}


	// excludes Model Name from the threaded data and returns formatted array of parents and childs
	function formatTreeData( &$node, $ModelName )
	{
		$modifiedNode = array();
		foreach($node as $item)
		{
			$item[$ModelName]['children'] = $this->formatTreeData($item['children'], $ModelName);
			$modifiedNode[] = $item;//$item[$ModelName];
		}
		return $modifiedNode;
	}


	function getTreeViewHtml( $parameters = array() )
	{
		$node = isset($parameters['data']) ? $parameters['data'] : array();
		$ModelName = isset($parameters['model_name']) ? $parameters['model_name'] : 'Category';
		$generate_name_with_fields = isset($parameters['generate_name_with_fields']) ? $parameters['generate_name_with_fields'] : $ModelName.'.name';
		$fields_separator = isset($parameters['fields_separator']) ? $parameters['fields_separator'] : ' '; // by default fields separator is space (' ')


		$nodeHtml = '';
		foreach($node as $n)
		{
			if(is_array($generate_name_with_fields))
			{
				$name = '&nbsp;'.$this->generateName($n, $generate_name_with_fields, $ModelName, $fields_separator);
			}else{

				if(strpos($generate_name_with_fields, '.') !== FALSE)
				{
					list($ModelName, $field_name) = split('[.]', $generate_name_with_fields);
					if(isset($n[$ModelName][$field_name]))
					{
						$name = '&nbsp;'.ucwords(strtolower($n[$ModelName][$field_name]));
					}else{
						$name = '&nbsp;'.ucwords(strtolower($n[$field_name]));
					}

				}else{
					$name = '&nbsp;'.ucwords(strtolower($n[$generate_name_with_fields]));
				}
			}

			if(!empty($n['children']))
			{
				// regenerate parameters to pass them again to this function
				$new_parameters['data'] = $n['children'];
				$new_parameters['model_name'] = $ModelName;
				$new_parameters['generate_name_with_fields'] = $generate_name_with_fields;
				$new_parameters['fields_separator'] = $fields_separator;

				$nodeHtml .= "<li id=\"{$n[$ModelName]['id']}\" class=\"list-group-item\"><span class=\"folder\">$name</span>".$this->getTreeViewHtml( $new_parameters )."</li>";
			}else{
				$nodeHtml .= "<li id=\"{$n[$ModelName]['id']}\" class=\"list-group-item\"><span class=\"file\">$name</span></li>";
			}
		}

		return "<ul class=\"list-group\">".$nodeHtml."</ul>";
	}

	function generateName($node, $fields, $ModelName, $separator = ' ')
	{
		$result = '';

		if(!empty($fields))
		{
			foreach($fields as $this_field)
			{
				if(strpos($this_field, '.') !== FALSE)
				{
					list($ModelName, $field_name) = split('[.]', $this_field);
					if(isset($node[$ModelName][$field_name]))
					{
						$result .= ucwords(strtolower($node[$ModelName][$field_name])).$separator;
					}else{
						$result .= ucwords(strtolower($node[$field_name])).$separator;
					}

				}else{

					$result .= ucwords(strtolower($node[$ModelName][$this_field])).$separator;
				}

			}
		}

		return trim($result,$separator);
	}

	function getChildren($parameters = array())
	{
		$parent_id = isset($parameters['parent_id']) ? $parameters['parent_id'] : 0; // default parent_id is 0
		$original_conditions = isset($parameters['conditions']) ? $parameters['conditions'] : null; // default conditions are null
		$ModelName = isset($parameters['model_name']) ? $parameters['model_name'] : 'Category'; // default Model Name is Category
		$fields = isset($parameters['fields']) ? $parameters['fields'] : null; // default fields are ALL
		$order = isset($parameters['order']) ? $parameters['order'] : $ModelName.'.lft ASC'; // by default will be sorted on the basis of lft field
		$recursive = isset($parameters['recursive']) ? $parameters['recursive'] : null; // by default not get recursive records
		$generate_name_with_fields = isset($parameters['generate_name_with_fields']) ? $parameters['generate_name_with_fields'] : 'name'; // by default generate category name with 'name' field
		$fields_separator = isset($parameters['fields_separator']) ? $parameters['fields_separator'] : ' '; // by default fields separator is space (' ')
		$return = isset($parameters['return']) ? $parameters['return'] : 'data'; // by default data will be returned. Possible values are json and data

		$ModelInstance = ClassRegistry::init($ModelName);
		$ModelInstance->recursive = $recursive;

		$conditions = $original_conditions;
		if(empty($conditions))
		{
			$conditions = " $ModelName.parent_id = $parent_id";

		}else{

			$conditions .= " AND $ModelName.parent_id = $parent_id";
		}

		$childs = $ModelInstance->find('all', array('conditions' => $conditions, 'fields' => $fields, 'order' => $order));
		if(strtolower($return) == 'data')
		{
			return $childs;

		}else{

			$finalArr = array();
			foreach($childs as $index => $child)
			{
				$itsChilds = $ModelInstance->findCount("$original_conditions AND $ModelName.parent_id = {$child[$ModelName]['id']}");
				$finalArr[$index]['text'] = $this->generateName($child, $generate_name_with_fields, $ModelName, $fields_separator);
				$finalArr[$index]['id'] = $child[$ModelName]['id'];
				$finalArr[$index]['hasChildren'] = ($itsChilds > 0) ? true : false;
			}

			return array2json($finalArr);
		}
	}

	function getSearchConditions($data)
	{
		$conditions = '1';
		if(isset($data['Conditions']['filter']) && !empty($data['Conditions']['filter']))
		{
			if($data['Conditions']['filter'] == 'member_name' && !empty($data['Conditions']['name'])){
				$conditions .= " AND (Member.first_name LIKE '%{$data['Conditions']['name']}%' OR Member.last_name LIKE '%{$data['Conditions']['name']}%') ";
			}elseif($data['Conditions']['filter'] == 'rank'){
				$conditions .= " AND Member.rank_id = {$data['Conditions']['rank']} ";
			}elseif($data['Conditions']['filter'] == 'member_id' && !empty($data['Conditions']['id'])){
				$conditions .= " AND Member.id = {$data['Conditions']['id']} ";
			}elseif($data['Conditions']['filter'] == 'status' && !empty($data['Conditions']['status'])){
				$conditions .= " AND Member.status LIKE '{$data['Conditions']['status']}' ";
			}elseif($data['Conditions']['filter'] == 'member_type' && !empty($data['Conditions']['member_type_id'])){
				$conditions .= " AND Member.member_type_id = {$data['Conditions']['member_type_id']} ";
			}
		}

		$result = array('conditions' => $conditions,'filters' => $data);
		return $result;
	}


}// end of class
?>