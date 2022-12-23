<?php
echo $this->element('design/header');
echo $this->element('Aros/links');
?>
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<th>Module Name:</th>
			<?php
			$colspan = 1;
			foreach ($roles as $key => $value) {
			?>
			<th><?php echo $value; ?></th>
			<?php
				$colspan++;
			}
			?>
		</thead>
		<tbody>
			<?php 
			if(!empty($modules)) {
				foreach($modules as $module) {
			?>
			<tr>
				<td>
					<?php
					echo $module['Aro']['alias'];
					echo $this->Html->link('Manage','/admin/acl/utilities/add_actions_to_group/'.$module['Aro']['id'],array('class' => 'ml5'));
					echo $this->Html->link('Edit Name','/admin/acl/utilities/add_group/'.$module['Aro']['id'],array('class' => 'ml5'));
					?>
				</td>
				<?php
				
				foreach ($roles as $key => $value) {
				?>
				<td>
					<?php
					$tick_style = '';
					$cross_style = '';
					if(isset($modulePermissions[$key.'_'.$module['Aro']['id']])){
						$cross_style = 'display:none;';
					}else{
						$tick_style = "display:none;";
					}
					?>
					<a href="javascript:;" id="permission_tick_<?php echo $key ?>" style="<?php echo $tick_style; ?>" onclick="manage_module_permissions('deny','<?php echo $key ?>','<?php echo $module['Aro']['id']?>')" class="glyphicon glyphicon-ok text-success" title="deny access"></a>
					<a href="javascript:;" id="permission_cross_<?php echo $key ?>" style="<?php echo $cross_style; ?>" onclick="manage_module_permissions('allow','<?php echo $key ?>','<?php echo $module['Aro']['id']?>')" class="glyphicon glyphicon-remove text-danger" title="grant access"></a>
					<img class="ml5" src="<?php echo $this->base ?>/img/loading.gif" id="module_permission_loader_<?php echo $key ?>" style="display:none;">
				</td>
				<?php
				}
				?>
			</tr>
			<?php 
				}
			}else{
			?>
			<tr>
				<td colspan="<?php echo $colspan; ?>">No module defined:</td>
			</tr>
			<?php
			}
			?>
		</tbody>
	</table>
</div>

<?php
$code = "var app_root_url = '{$this->base}';";
echo $this->Html->scriptBlock($code,array('block' => 'bottomScript'));
echo $this->Html->script('/acl/js/acl_plugin',array('block' => 'bottomScript'));
echo $this->element('design/footer');
?>