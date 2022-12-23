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

class InventoryOutItemsController extends AppController{


	public $name = 'InventoryOutItems'; //controller name

	public $components = array('FairManagement');

	public function beforeFilter() {
		$this->set('title_for_layout','Art Dubai');
	}

	public function index() {
	
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
		
		$chk_type = empty( $this->request->data['InventoryOut']['type'] ) ? '' : $this->request->data['InventoryOut']['type'];
		$fair_id = empty( $this->request->data['InventoryOut']['fair'] ) ? '' : $this->request->data['InventoryOut']['fair'];
		$event_id = empty( $this->request->data['InventoryOut']['event'] ) ? '' : $this->request->data['InventoryOut']['event'];
		$assign_to_id = empty( $this->request->data['InventoryOutItem']['assign_to_id'] ) ? '' : $this->request->data['InventoryOutItem']['assign_to_id'];
		$item_less = empty( $this->request->data['item_less'] ) ? '' : $this->request->data['item_less'];
		
		
				
		if( !empty( $item_category_id ))
		{
			$category = array("InventoryOutItem.item_category_id" => $item_category_id );
			$conditions = array_merge($conditions,$category);
		}

		if( !empty( $chk_type ))
		{			
			$type = '';
			if( $chk_type == 'Fair' )
			{
				$type = array(
								"InventoryOut.type" => $chk_type,
								"InventoryOut.fair_or_event_id" => $fair_id
							  );
			}
			elseif( $chk_type == 'Event' )
			{
				$type = array(
								"InventoryOut.type" => $chk_type,
								"InventoryOut.fair_or_event_id" => $event_id 
							  );
			}			
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
				$qty = array("InventoryOutItem.qty_in < " => 'InventoryOutItem.qty_out' );
				$conditions = array_merge($conditions,$qty);
			}
			else
			{
				$qty = array("InventoryOutItem.qty_in > " => 'InventoryOutItem.qty_out' );
				$conditions = array_merge($conditions,$qty);
			}
		}	
				
		//end setting conditions		
		//debug($conditions);
		$this->loadModel('InventoryOutItem');
		$Items = $this->InventoryOutItem->find('all',array(
														'conditions'=>$conditions,
														'recursive'=>'2'
															)
														);
				
		$this->set(compact('Items','item_category_id','chk_type','fair_id','event_id','assign_to_id','item_less'));				
	}	

	public function ItemOut(){
	
		//This function is used for add and edit outbound items
		$ID = isset($this->request->query['ID']) ? $this->request->query['ID'] : null;
				
		//saving the data		
		if( $this->request->is('post') && !empty($this->request->data['InventoryOutItem']) ) {														

			//saving in inventory out table..
			$options['id'] = isset($this->request->query['invout_id']) ? $this->request->query['invout_id'] : null;			
			
			if( $this->request->data['InventoryOut']['type'] == 'Fair' )			
				$this->request->data['InventoryOut']['fair_or_event_id'] = $this->request->data['InventoryOut']['fair'];
			else
				$this->request->data['InventoryOut']['fair_or_event_id'] = $this->request->data['InventoryOut']['event'];
				
			if( $id = $this->FairManagement->save( 'InventoryOut',$this->request->data['InventoryOut'],$options )) {
			
				//saving in inventory item out table
				$options['uuid'] = isset($this->request->query['ID']) ? $this->request->query['ID'] : null;	
				$this->request->data['InventoryOutItem']['inventory_out_id'] = !empty($options['id']) ? $options['id'] : $id;
				$this->request->data['InventoryOutItem']['assigned_date'] = date('Y-m-d H:i:s');
				
				$this->FairManagement->save( 'InventoryOutItem',$this->request->data['InventoryOutItem'],$options);
				$this->redirect('/InventoryOutItems/index');
			}
		}		
		
		//populating the recored when editing..
		if( !empty($ID) ){
			$options['uuid'] = $ID;
			$item = $this->FairManagement->getRecords('InventoryOutItem',$options);
			
			if( !empty($item) )
			{
				$id = $item['InventoryOutItem']['inventory_out_id'];
				$this->loadModel( 'InventoryOut' );
				
				$inventory_out = $this->InventoryOut->find('first',array( 'conditions'=>array('id'=>$id,'active'=>'1') ));
			}
			
		}
								
		//Get list of categories, fairs, events and employees...
		$itemCategories = $this->FairManagement->getRecords('ItemCategory');
		$Fairs = $this->FairManagement->getRecords('Fair');
		$Events = $this->FairManagement->getRecords('FairEvent');
		$Employees = $this->FairManagement->getRecords('Employee');		
		
		$this->set( compact( 'item','ID','itemCategories','Fairs','Events','Employees','inventory_out') );
		
	}
	
	public function deleteItemOut() {
		$this->layout = null;
		$uuid = $this->request->query['ID'];
				
		//get parent record for this item from inventory out table..		
		$inventory_out = $this->FairManagement->getRecords('InventoryOutItem');
		if( !empty($inventory_out) )
		{
			$options['id'] = $inventory_out['InventoryOutItem']['inventory_out_id'];
			$this->FairManagement->makeInactive('InventoryOut',$options);
		}
		
		$options['uuid'] = $uuid;
		$this->FairManagement->makeInactive('InventoryOutItem',$options);

		$this->redirect($this->referer());
		exit;
	}
	
	public function ItemIn(){
			
		//This function is used for add and edit inbound items
		$ID = isset($this->request->query['ID']) ? $this->request->query['ID'] : null;
				
		//saving the data		
		if( $this->request->is('post') && !empty($this->request->data['InventoryOutItem']) ) {														

			//saving data for inventory inbound..
			//$options['id'] = isset($this->request->query['invout_id']) ? $this->request->query['invout_id'] : null;
			
			/*
			if( $this->request->data['InventoryOut']['type'] == 'Fair' )			
				$this->request->data['InventoryOut']['fair_or_event_id'] = $this->request->data['InventoryOut']['fair'];
			else
				$this->request->data['InventoryOut']['fair_or_event_id'] = $this->request->data['InventoryOut']['event'];
			*/	
			
			//if( $id = $this->FairManagement->save( 'InventoryOut',$this->request->data['InventoryOut'],$options )) {
			
				//saving in inventory item out table
				if( !empty($this->request->query['ID']) )
				{									
					$options['id'] = isset($this->request->query['ID']) ? $this->request->query['ID'] : null;
				}
				else
				{											
					$item_id = $this->request->data['InventoryOutItem']['item_category_id'];					
					$row_id = split("_",$item_id);
					$options['id'] = $row_id[0];
				}
				
				$temp['InventoryOutItem']['received_date'] = date('Y-m-d H:i:s');
				$temp['InventoryOutItem']['qty_in'] = $this->request->data['InventoryOutItem']['qty_in'];
				$temp['InventoryOutItem']['received_by'] = $this->request->data['InventoryOutItem']['received_by'];
				
				$this->loadModel('InventoryOutItem');
				
				$this->InventoryOutItem->id = !empty($options['id']) ? $options['id'] : '';
				/*
				if( !empty($options['id']) )
					$this->InventoryOutItem->id = $options['id'];
				else	
					$this->InventoryOutItem->id = $this->FairManagement->getIDByUUID( 'InventoryOutItem',$options['uuid']);
				*/

				$this->InventoryOutItem->save($temp);
				
				$this->redirect('/InventoryOutItems/index');
			//}
		}		
		
		//populating the recored when editing..
		if( !empty($ID) ){
			$options['InventoryOutItem.id'] = $ID;
			$item = $this->FairManagement->getRecords('InventoryOutItem',$options);
			
			if( !empty($item) )
			{				
				$id = $item[0]['InventoryOutItem']['inventory_out_id'];
				$this->loadModel( 'InventoryOut' );				
				$inventory_out = $this->InventoryOut->find('first',array( 'conditions'=>array('id'=>$id,'active'=>'1') ));								
			}
			
		}
								
		//Get list of categories, fairs, events and employees...
		$itemCategories = $this->FairManagement->getRecords('ItemCategory');
		$Fairs = $this->FairManagement->getRecords('Fair');
		$Events = $this->FairManagement->getRecords('FairEvent');
		$Employees = $this->FairManagement->getRecords('Employee');		
		
		$this->set( compact( 'item','ID','itemCategories','Fairs','Events','Employees','inventory_out') );
		
	}
	
	public function EventItems()
	{
		//This function gets the categories which are related to specific fair or event.
		$this->layout = null;
		$fair_or_event_id = $this->request->query['fair_or_event_id'];
		
		$options['fair_or_event_id'] = $fair_or_event_id;
		$this->loadModel( 'InventoryOut' );
		//$this->InventoryOut->contain( array('InventoryOutItem') );
		$inventory_out = $this->InventoryOut->find('all',array( 
													'conditions'=>array('fair_or_event_id'=>$fair_or_event_id,'active'=>'1'),
													'recursive'=>'2',
													'contain'=> array('InventoryOutItem'=>array('fields'=>'InventoryOutItem.id'),
																	  'ItemCategory'=>array('fields'=>'ItemCategory.name'),
																	  ),
																)
													);
		
		//Making associative array having item out table id and category name.
		if( !empty($inventory_out) )
		{
			$item_out = '';
			foreach($inventory_out as $item)
			{
				if( $item_out == '')				
					$item_out = $item['InventoryOutItem'][0]['id']."_". $item['InventoryOutItem'][0]['qty_out'] . "~" . $item['InventoryOutItem'][0]['ItemCategory']['name'];
				else
					$item_out = $item_out . "^" . $item['InventoryOutItem'][0]['id'] ."_". $item['InventoryOutItem'][0]['qty_out'] . "~" . $item['InventoryOutItem'][0]['ItemCategory']['name'];
				
			}
		}		
		print_r( $item_out );
		exit;
		
	}

}