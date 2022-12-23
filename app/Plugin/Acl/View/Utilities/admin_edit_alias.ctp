<?php
echo $this->element('design/header');
?>
<div class="col-lg-offset-1 col-lg-6">
	<?php
	echo $this->Html->tag('h4','Define Alias:',array('class' => 'col-lg-offset-1'));
	?>
	<form action="<?php echo $this->base ?>/admin/acl/utilities/edit_alias" method="post" class="form-horizontal">
		<?php 
		echo $this->Form->input('Aco.id',array(
				'label' => false,
				'div' => false,
				'type' => 'hidden',
				'value' => $aco['Aco']['id']
			)); 
		?>
		<div class="form-group">
			<?php
			echo $this->Html->tag('label','Name:',array('class' => 'col-lg-2 control-label'));
			echo $this->Form->input('Aco.name',array(
					'label' => false,
					'div' => 'col-lg-6',
					'class' => 'form-control input-sm',
					'value' => $aco['Aco']['name']
				));
			?>
		</div>
		<div class="form-group">
			<div class="col-lg-offset-6">
				<button class="btn btn-primary btn-sm">Save</button>
				<a class="btn btn-link btn-sm" href="<?php echo $this->base ?>/admin/acl/utilities/action_names">Cancel</a>
			</div>
		</div>
	</form>
</div>
<?php
echo $this->element('design/footer');
?>