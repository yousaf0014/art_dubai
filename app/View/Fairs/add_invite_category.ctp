<?php
echo $this->Html->script(array('jquery.validate.min','fairs'), array('block' => 'script'));
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="pull-left"><?php echo empty($inviteCat) ? 'Add' : 'Edit'; ?> Invitation Type</h4>
		<a class="pull-right btn btn-default btn-sm mt5" href="<?php echo $this->base ?>/Fairs/inviteCategories">
			<span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Go Back
		</a>
		<div class="clearfix"></div>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" action="<?php echo $this->base ?>/Fairs/addInviteCategory?CID=<?php echo $catID; ?>" role="form" method="post" id="addCatForm" enctype="multipart/form-data">

			<div class="form-group">
				<?php
				echo $this->Html->tag('label','Fair Category',array('class' => 'col-lg-2 control-label'));
				echo $this->Form->input('InviteCategory.fair_category_id',array(
					'div' => 'col-lg-5',
					'label' => false,
					'type' => 'select',
					'empty' => '--Select--',
					'class' => 'form-control input-sm',
					'options' => $fair_cats,
					'value' => isset($inviteCat['InviteCategory']['fair_category_id']) ? $inviteCat['InviteCategory']['fair_category_id'] : ''
				));
				?>
			</div>
			
			<div class="form-group">
				<label class="col-lg-2 control-label">Name</label>
				<div class="col-lg-5">
					<input type="text" class="form-control input-sm" name="data[InviteCategory][name]" placeholder="Name" value="<?php echo !empty($inviteCat['InviteCategory']['name']) ? $inviteCat['InviteCategory']['name'] : ''; ?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label">Description</label>
				<div class="col-lg-5">
					<textarea class="form-control input-sm" rows="5" name="data[InviteCategory][description]"><?php echo !empty($inviteCat['InviteCategory']['description']) ? $inviteCat['InviteCategory']['description'] : ''; ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-offset-6 col-lg-7">
					<button type="submit" class="btn btn-primary btn-sm">Save</button>
				</div>
			</div>
		</form>
	</div>
</div>
<?php
$code = '$(document).ready(function(){
		validate_invite_category_form();
	});';
 echo $this->Html->scriptBlock($code,array('inline' => false,'block' => 'bottomScript'));
?>