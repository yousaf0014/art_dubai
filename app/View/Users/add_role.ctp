<?php 
if(!$this->request->data){
	$this->request->data = $role;
}
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<?php
		echo $this->Html->tag('h4','Add Role',array(
				'class' => 'pull-left'
			));
		?>
		<a href="<?php echo $this->base ?>/users/roles" class="btn btn-default pull-right btn-sm mt5">
			<span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Go Back
		</a>
		<?php
		echo $this->Html->tag('div','',array('class' => 'clearfix'))
		?>
	</div>
	<div class="panel-body">
		<div class="col-lg-6 col-lg-offset-1">
		<?php
			echo $this->Form->create(null,array(
					'method' => 'post',
					'controller' => 'users',
					'action' => 'addRole?RID='.$uuid,
					'role' => 'form',
					'class' => 'form-horizontal',
					'id' => 'addForm'
				));
		?>
		<div class="form-group">
			<?php
			echo $this->Html->tag('label','Name:',array('class' => 'control-label col-lg-2'));
			echo $this->Form->input('Role.name',array(
					'div' => 'col-lg-8',
					'class' => 'form-control input-sm',
					'label' => false
				));
			?>
		</div>
		<div class="form-group">
			<?php
			echo $this->Html->tag('label','Description:',array('class' => 'control-label col-lg-2'));
			echo $this->Form->input('Role.description',array(
					'class' => 'form-control input-sm',
					'label' => false,
					'div' => 'col-lg-8',
					'type' => 'textarea'
				));
			?>
		</div>
		<div class="form-group">
			<div class="col-lg-offset-8">
				<?php
				echo $this->Form->button('Save',array(
						'type' => 'submit',
						'class' => 'btn btn-primary btn-sm'
					));
				?>
			</div>
		</div>
		<?php
			echo $this->Form->end();
		?>
		</div>
	</div>
</div>
<?php

echo $this->Html->script(array('jquery.validate.min','fairs'),array('block' => 'bottomScript'));

$code = '$(document).ready(function(){
	validate_add_role();
});';

echo $this->Html->scriptBlock($code,array('block' => 'bottomScript'));

?>