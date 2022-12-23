<?php
echo $this->element('design/header');
?>
<hr/>
<div class="col-lg-offset-3 col-lg-6">
	<?php
	echo $this->Html->tag('h4','Define Module:',array('class' => 'col-lg-offset-1'));
	?>
	
	<form method="post" action="<?php echo $this->base ?>/admin/acl/utilities/add_group?redirect=<?php echo $this->request->referer(); ?>" method="post" class="form-horizontal">
		<?php 
		echo $this->Form->input('Aro.id',array(
				'label' => false,
				'div' => false,
				'type' => 'hidden',
				'value' => isset($aro['Aro']['id']) ? $aro['Aro']['id'] : ''
			)); 
		?>
		<div class="form-group">
			<?php
			echo $this->Html->tag('label','Name:',array('class' => 'col-lg-2 control-label'));
			echo $this->Form->input('Aro.alias',array(
					'label' => false,
					'div' => 'col-lg-6',
					'class' => 'form-control input-sm',
					'value' => isset($aro['Aro']['alias']) ? $aro['Aro']['alias'] : ''
				));
			?>
		</div>
		<div class="form-group">
			<div class="col-lg-offset-6">
				<button class="btn btn-primary btn-sm">Save</button>
				<a class="btn btn-link btn-sm" href="<?php echo $this->request->referer();?> ">Cancel</a>
			</div>
		</div>
	</form>
</div>
<?php
echo $this->element('design/footer');
?>