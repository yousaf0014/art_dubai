<?php 
if(!$this->request->data){
	$this->request->data = $employee;
}
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<?php
		echo $this->Html->tag('h4','Add Employee',array(
				'class' => 'pull-left'
			));
		?>
		<a class="pull-right btn btn-default btn-sm mt5" href="<?php echo $this->base ?>/users/employees">
			<span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Go Back
		</a>
		<?php
		echo $this->Html->tag('div','',array('class' => 'clearfix'));
		?>
	</div>
	<div class="panel-body">
		<div class="col-lg-7 col-lg-offset-1">
			<form class="form-horizontal" role="form" id="addEmployee" method="post" action="<?php echo $this->base ?>/users/addEmployee?UID=<?php echo $uuid; ?>">
			<div class="form-group">
			<?php
				echo $this->Html->tag('label','Fair Category:',array(
						'class' => 'control-label col-lg-4'
					));
				
				echo $this->Html->useTag('tagstart','div',array(
						'class' => 'col-lg-6'
					));
				echo $this->Form->input('User.fair_category_id',array(
						'class' => 'form-control input-sm',
						'div' => false,
						'label' => false,
						'type' => 'select',
						'empty' => true,
						'options' => $fair_categories
					)); 
				echo $this->Html->useTag('tagend','div');
			?>
			</div>
			<div class="form-group">
			<?php
				echo $this->Html->tag('label','Department:',array(
						'class' => 'control-label col-lg-4'
					));
				
				echo $this->Html->useTag('tagstart','div',array(
						'class' => 'col-lg-6'
					));
				echo $this->Form->input('User.department_id',array(
						'class' => 'form-control input-sm',
						'div' => false,
						'label' => false,
						'type' => 'select',
						'empty' => true,
						'options' => $departments
					)); 
				echo $this->Html->useTag('tagend','div');
			?>
			</div>
			<div class="form-group">
			<?php
				echo $this->Html->tag('label','First Name:',array(
						'class' => 'control-label col-lg-4'
					));
				
				echo $this->Html->useTag('tagstart','div',array(
						'class' => 'col-lg-6'
					));
				echo $this->Form->input('User.first_name',array(
						'class' => 'form-control input-sm',
						'div' => false,
						'label' => false,
					));
				echo $this->Html->useTag('tagend','div');
			?>
			</div>
			<div class="form-group">
			<?php
				echo $this->Html->tag('label','Last Name:',array(
						'class' => 'control-label col-lg-4'
					));
				
				echo $this->Html->useTag('tagstart','div',array(
						'class' => 'col-lg-6'
					));
				echo $this->Form->input('User.last_name',array(
						'class' => 'form-control input-sm',
						'div' => false,
						'label' => false,
					));
				echo $this->Html->useTag('tagend','div');
			?>
			</div>
			<div class="form-group">
			<?php
				echo $this->Html->tag('label','Email:',array(
						'class' => 'control-label col-lg-4'
					));
				
				echo $this->Html->useTag('tagstart','div',array(
						'class' => 'col-lg-6'
					));
				echo $this->Form->input('User.email',array(
						'class' => 'form-control input-sm',
						'div' => false,
						'label' => false,
					));
				echo $this->Html->useTag('tagend','div');
			?>
			</div>
			<div class="form-group">
			<?php
				echo $this->Html->tag('label','Password:',array(
						'class' => 'control-label col-lg-4'
					));
				
				echo $this->Html->useTag('tagstart','div',array(
						'class' => 'col-lg-6'
					));
				echo $this->Form->input('User.password',array(
						'class' => 'form-control input-sm',
						'type' => 'password',
						'value' => '',
						'div' => false,
						'label' => false,
						'id' => 'password'
					));
				echo $this->Html->useTag('tagend','div');
				if(!empty($employee['User']['id'])) {
					echo $this->Html->tag('div','Leave blank if you don&#8216;t want to change',array('class' => ''));
				}
			?>
			</div>
			<div class="form-group">
			<?php
				echo $this->Html->tag('label','Confirm Password:',array(
						'class' => 'control-label col-lg-4'
					));
				
				echo $this->Html->useTag('tagstart','div',array(
						'class' => 'col-lg-6'
					));
				echo $this->Form->input('User.confirm_password',array(
						'class' => 'form-control input-sm',
						'type' => 'password',
						'value' => '',
						'div' => false,
						'label' => false,
						'id' => 'confirm_password'
					));
				echo $this->Html->useTag('tagend','div');
			?>
			</div>
			<div class="form-group">
			<?php
				echo $this->Html->tag('label','Mobile:',array(
						'class' => 'control-label col-lg-4'
					));
				
				echo $this->Html->useTag('tagstart','div',array(
						'class' => 'col-lg-6'
					));
				echo $this->Form->input('User.mobile_phone',array(
						'class' => 'form-control input-sm',
						'type' => 'text',
						'div' => false,
						'label' => false,
						'empty' => true
					));
				echo $this->Html->useTag('tagend','div');
			?>
			</div>
			<div class="form-group">
			<?php
				echo $this->Html->tag('label','Role:',array(
						'class' => 'control-label col-lg-4'
					));
				
				echo $this->Html->useTag('tagstart','div',array(
						'class' => 'col-lg-6'
					));
				echo $this->Form->input('User.role_id',array(
						'class' => 'form-control input-sm',
						'type' => 'select',
						'options' => $roles,
						'div' => false,
						'label' => false,
						'empty' => true
					));
				echo $this->Html->useTag('tagend','div');
			?>
			</div>
			<div class="form-group">
				<?php
				echo $this->Html->useTag('tagstart','div',array(
						'class' => 'col-lg-offset-9'
					));
				echo $this->Form->button('Save',array('type' => 'submit','class' => 'btn btn-primary btn-sm'));
				echo $this->Html->useTag('tagend','div');
				?>
			</div>
		</form>
		</div>
	</div>
</div>
<?php

echo $this->Html->script(array('jquery.validate.min','fairs'),array('block' => 'bottomScript'));

$code = '$(document).ready(function(){
	validate_add_employee("'.$uuid.'");
});';

echo $this->Html->scriptBlock($code,array('block' => 'bottomScript'));

?>