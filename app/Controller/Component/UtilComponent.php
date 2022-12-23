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

class UtilComponent extends Component{

	public function readFile($filePath) {
		
		App::import('Vendor', 'PHPExcel/PHPExcel');
		$inputFileType = PHPExcel_IOFactory::identify($filePath);
		$readerObj = PHPExcel_IOFactory::createReader($inputFileType);
		$readerObj->setReadDataOnly(true);
		$objPHPExcel = $readerObj->load($filePath);
		$records = $objPHPExcel->getActiveSheet()->toArray();
		return $records;
	}

	public function identifyFields($record) {
		$fields = $this->getFieldsOrder();
		$temp = array();

		foreach($fields as $index => $key) {
			$temp[$key] = isset($record[$index]) ? $record[$index] : '';
		}
		return $temp;
	}

	public function getFieldsOrder() {
		return array(
				'0' => 'salutation',
				'1' => 'first_name',
				'2' => 'last_name',
				'3' => 'city',
				'4' => 'country',
				'5' => 'country_code',
				'6' => 'address',
				'7' => 'phone',
				'8' => 'mobile',
				'9' => 'fax',
				'10' => 'zip',
				'11' => 'pobox',
				'12' => 'email',
				'13' => 'website',
				'14' => 'guest_off',
				'15' => 'source',
				'16' => 'facebook',
				'17' => 'twitter',
				'18' => 'linkedin',
				'19' => 'instagram'
			);
	}
}