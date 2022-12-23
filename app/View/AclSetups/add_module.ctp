<div class="panel panel-primary">
	<div class="panel-heading">
		<?php
		echo $this->Html->tag('h4','Add  Module',array('class' => 'pull-left'));
		echo $this->Html->link('Go Back','/acl_setups/',array('class' => 'pull-right btn btn-default'));
		echo $this->Html->tag('div','',array('class' => 'clearfix'));
		?>
	</div>
	<div class="panel-body">
		<div class="col-lg-6 col-lg-offset-1">
			<form name="add_module_form" class="form-horizontal" role="form" id="AddModuleForm" method="post" action="<?=$this->base?>/acl_setups/addModule">
				<?php echo $this->Form->hidden('Aco.id'); ?>
				<div class="form-group">
					<?php
					echo $this->Html->tag('label','Parent module',array('class' => 'col-lg-4 control-label'));
					echo $this->Html->useTag('tagstart','div',array('class' => 'col-lg-8'));
					echo $this->Form->input('Aco.parent_id', array ( 
							'label' => false,
							'type'  => 'select',
							'options' => $allModules, 
							'empty' => '--Choose Parent--',
							'class' => 'form-control',
							'div' => false
						)
					);
					echo $this->Html->useTag('tagend','div');
					?>
				</div>
				<div class="form-group">
					<?php
					echo $this->Html->tag('label','Module Name',array('class' => 'col-lg-4 control-label'));
					echo $this->Html->useTag('tagstart','div',array('class' => 'col-lg-8'));
					echo $this->Form->input('Aco.alias', array(
							'label' => false, 
							'type' => 'text',
							'div' => false,
							'class' => 'form-control'
						)
					);
					echo $this->Html->useTag('tagend','div');
					?>
				</div>
				<div class="form-group">
					<div class="col-lg-offset-9">
						<a href="javascript:{}" onclick="$('#AddModuleForm').submit();" class="btn btn-primary">Save</a>
						<a href="<?=$this->base?>/AclSetups" class="btn btn-link">Cancel</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>