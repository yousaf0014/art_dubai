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

class ItemCategoriesController extends AppController{


	public $name = 'ItemCategories'; //controller name

	public $components = array('FairManagement');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->set('title_for_layout','Art Dubai');
	}

	public function index() {
	
		//This function list all the categories
		$ItemCategories = $this->FairManagement->getRecords('ItemCategory');
		$this->set(compact('ItemCategories'));
	}

	public function addItemCategory(){
	
		//This function is used for add and edit categories
		$ID = isset($this->request->query['ID']) ? $this->request->query['ID'] : null;
				
		//saving the data		
		if( $this->request->is('post') && !empty($this->request->data['ItemCategory']) ) {			
		
			$options['uuid'] = isset($this->request->query['ID']) ? $this->request->query['ID'] : null;
			if($this->FairManagement->save( 'ItemCategory',$this->request->data['ItemCategory'],$options )) {
				$this->redirect('/ItemCategories/index');
			}
		}		
		
		if( !empty($ID) ){
			$options['uuid'] = $ID;
			$item = $this->FairManagement->getRecords('ItemCategory',$options);
		}
		$this->set(compact('item','ID'));
	}
	
	public function deleteItemCategory() {
		$this->layout = null;
		$catUUID = $this->request->query['ID'];
		$options['uuid'] = $catUUID;
		$this->FairManagement->makeInactive('ItemCategory',$options);

		$this->redirect($this->referer());
		exit;
	}

}