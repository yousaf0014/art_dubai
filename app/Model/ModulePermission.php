<?php
App::uses('AppModel', 'Model');
/**
 * AcosGroupsPermission Model
 *
 */
class ModulePermission extends AppModel {
	var $virtualFields = array(
		'unique_id' => "CONCAT(ModulePermission.foreign_key, '_', ModulePermission.module_id)"
	);
}
