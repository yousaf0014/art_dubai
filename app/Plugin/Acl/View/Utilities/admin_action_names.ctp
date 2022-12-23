<?php
echo $this->element('design/header');
?>
<hr/>
<div class="col-lg-8 col-lg-offset-1">
	<h2 class="pull-left">Actions Alias</h2>
	<div class="pull-right">
		<a href="<?php echo $this->base ?>/admin/acl/utilities/aros_groups" class="mt20 btn btn-primary btn-sm">Modules</a>
	</div>
	<div class="clearfix"></div>
	<div class="table-responsive">
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th width="3%">No:</th>
					<th width="30%">Method Name</th>
					<th width="30%">Alias</th>
					<th width="20%">Controller Name</th>
					<th width="10%" class="text-center">Path</th>
					<th class="text-center">Edit</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$counter = 1;
				foreach($methods['app'] as $con => $actions) {
					foreach($actions as $action) {
				?>
				<tr>
					<td><?php echo $counter++ ?></td>
					<td><?php echo $action['name']; ?></td>
					<td><?php echo isset($action['alias']) ? $action['alias'] : ''; ?></td>
					<td><?php echo ucfirst($con); ?></td>
					<td class="text-center"><?php echo 'App/Controller'; ?></td>
					<td class="text-center">
						<?php
						echo $this->Html->link('','/admin/acl/utilities/edit_alias/'.$con.'/'.$action['name'],array('class' => 'glyphicon glyphicon-pencil'));
						?>
					</td>
				</tr>
				<?php 
					}
				}
				if(isset($methods['plugin'])){
					foreach($methods['plugin'] as $pluginName => $plugin) {
						foreach($plugin as $cntrl_name => $actions) {
							foreach ($actions as $contrl => $action) {
				?>
				<tr>
					<td><?php echo $counter++ ?></td>
					<td><?php echo $action['name']; ?></td>
					<td><?php echo isset($action['alias']) ? $action['alias'] : ''; ?></td>
					<td><?php echo ucfirst($cntrl_name); ?></td>
					<td class="text-center"><?php echo $pluginName.' Plugin'; ?></td>
					<td class="text-center">
					<?php
						echo $this->Html->link('','/admin/acl/utilities/edit_alias/'.$cntrl_name.'/'.$action['name'],array('class' => 'glyphicon glyphicon-pencil'));
					?>
					</td>
				</tr>
				<?php
							}
						}
					}
				}
				?>
			</tbody>
		</table>
	</div>
</div>
<?php
echo $this->element('design/footer');
?>