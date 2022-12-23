<?php
echo $this->element('design/header');
?>
<hr/>
<div class="col-lg-offset-1 col-lg-11">
	<form method="post" class="form-horizontal" role="form" action="<?php echo $this->base ?>/admin/acl/utilities/add_actions_to_group/<?php echo $groupID; ?>?redirect=<?php echo $this->request->referer(); ?>">
		<div class="form-group">
			<div class="col-lg-offset-10">
				<a href="<?php echo $this->request->referer(); ?>" class="btn btn-link btn-sm">Cancel</a>
				<button type="submit" class="btn btn-primary btn-sm">Save</button>
			</div>
		</div>
		<div class="form-group">
			<?php
			$counter = 1;
			foreach($acos as $parent) {
				echo $this->Html->tag('div','',array('class' => 'clearfix'));
				echo $this->Html->tag('h4',$parent['Aco']['alias']);
				echo $this->Html->tag('div','',array('class' => 'clearfix'));
				foreach($parent['children'] as $child) {
					$checked = isset($selected[$child['Aco']['id']]) ? true : false
			?>
			<div class="checkbox col-lg-3">
				<label>
					<?php
					echo $this->Form->input('AcoGroup.',array(
						'type' => 'checkbox',
						'div' => false,
						'label' => false,
						'id' => 'aco_'.$child['Aco']['id'],
						'hiddenField' => false,
						'value' => $child['Aco']['id'].'_'.$parent['Aco']['alias'].'_'.$child['Aco']['alias'],
						'checked' => $checked
					));
					echo !empty($child['Aco']['name']) ? $child['Aco']['name'] : $child['Aco']['alias'];
					?>
				</label>
			</div>
			<?php
				echo $counter++ % 4 == 0 ? '<div class="clearfix"></div>' : '';
				}
			}
			?>
		</div>
		<div class="form-group">
			<div class="col-lg-offset-10">
				<a href="<?php echo $this->request->referer(); ?>" class="btn btn-link btn-sm">Cancel</a>
				<button type="submit" class="btn btn-primary btn-sm">Save</button>
			</div>
		</div>
	</form>
</div>
<?php

echo $this->element('design/footer');

?>