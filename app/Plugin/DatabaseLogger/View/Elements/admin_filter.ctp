<?php echo $this->Html->script('/database_logger/js/clear_default'); ?>
<div id="admin_filter" class="mb10">
<?php
$model = isset($model) ? $model : false;

if($model){
	echo $this->Form->create($model, 
		array(
			'inputDefaults' => array('label' => false,'div' => false),
			'class' =>'form-horizontal',
			'role' => 'form'
		)
	);
?>
	<div class="form-group">
	<?php
		echo $this->Form->input('filter', array('label' => false, 'value' => "$model Search", 'class' => 'clear_default form-control input-sm','div' => 'col-lg-2'));
		echo $this->Form->button('Search', array('class' => 'btn btn-success btn-sm'));
	?>
	</div>
	<?php
		echo $this->Form->end();
	}
	?>
</div>