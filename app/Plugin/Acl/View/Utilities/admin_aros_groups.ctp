<?php
echo $this->element('design/header');
?>
<hr/>
<div class="table-responsive col-lg-offset-3 col-lg-6">
	<h4 class="pull-left">Modules</h4>
	<a href="<?php echo $this->base ?>/admin/acl/utilities/add_group" class="btn btn-primary btn-sm pull-right">Add</a>
	<div class="clearfix"></div>
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th width="6%" class="text-center">No</th>
				<th>Name</th>
				<th width="18%" class="text-center">Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$counter = 1;
			if(!empty($aros_groups)) {
				foreach($aros_groups as $aros_group) {
					$aroID = $aros_group['Aro']['id'];
			?>
			<tr>
				<td class="text-center"><?php echo $counter++; ?></td>
				<td><?php echo $aros_group['Aro']['alias']; ?></td>
				<td class="text-center">
					<a href="<?php echo $this->base ?>/admin/acl/utilities/add_group/<?php echo $aroID; ?>" class="glyphicon glyphicon-pencil mr5"></a>
					<a href="<?php echo $this->base ?>/admin/acl/utilities/add_actions_to_group/<?php echo $aroID; ?>" class="">Manage</a>
				</td>
			</tr>
			<?php
				}
			}else{
			?>
			<tr>
				<td colspan="3">No module defined.</td>
			</tr>
			<?php
			}
			?>
		</tbody>
	</table>
</div>
<?php
echo $this->element('design/footer');
?>