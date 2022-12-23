<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="pull-left"><?php echo empty($this->request->data['InviteList']) ? 'Add' : 'Edit'; ?> Invite List</h4>
		<a class="pull-right btn btn-default btn-sm mt5" href="<?php echo $this->request->referer(); ?>"><span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Go Back</a>
		<div class="clearfix"></div>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" action="<?php echo $this->base ?>/invites/addList?ID=<?php echo isset($this->request->data['InviteList']['uuid']) ? $this->request->data['InviteList']['uuid'] : ''; ?>" role="form" method="post" id="addListForm" enctype="multipart/form-data">
			<?php if(!empty($invite_categories)) { ?>
			<div class="form-group">
				<?php
				echo $this->Html->tag('label','Invite Category:',array('class' => 'col-lg-2 control-label'));
				echo $this->Form->input('InviteList.invite_category_id',array(
					'class' => 'form-control input-sm',
					'div' => 'col-lg-4',
					'placeholder' => 'Select Category',
					'label' => false,
					'type' => 'select',
					'options' => $invite_categories,
					'selected' => $catID,
					'empty' => true
				));
				?>
			</div>
			<?php }
			if(!empty($fairs)) { ?>
			<div class="form-group">
				<?php
				echo $this->Html->tag('label','Fair:',array('class' => 'col-lg-2 control-label'));
				echo $this->Form->input('InviteList.fair_id',array(
					'class' => 'form-control input-sm',
					'div' => 'col-lg-4',
					'placeholder' => 'Select fair',
					'label' => false,
					'type' => 'select',
					'options' => $fairs,
					'empty' => 'Select Fair',
					'onchange' => 'fetchEvents(this)'
				));
				?>
			</div>
			<div class="form-group">
				<?php
				echo $this->Html->tag('label','Event:',array('class' => 'col-lg-2 control-label'));
				echo $this->Form->input('InviteList.fair_event_id',array(
					'class' => 'form-control input-sm',
					'div' => 'col-lg-4',
					'label' => false,
					'type' => 'select',
					'empty' => 'Select Event',
					'id' => 'fair_events'
				));
				?>
			</div>
			<?php } ?>
			<div class="form-group">
				<?php
				echo $this->Form->input('redirect',array(
					'type' => 'hidden',
					'div' => false,
					'label' => false,
					'value' => $this->request->referer()
				));
				echo $this->Html->tag('label','Name:',array('class' => 'col-lg-2 control-label'));
				echo $this->Form->input('InviteList.name',array(
					'class' => 'form-control input-sm',
					'div' => 'col-lg-4',
					'placeholder' => 'Name',
					'label' => false,
					'type' => 'text'
				));
				?>
			</div>
			<div class="form-group">
				<?php
				echo $this->Html->tag('label','Description:',array('class' => 'col-lg-2 control-label'));
				echo $this->Form->input('InviteList.description',array(
					'class' => 'form-control input-sm',
					'div' => 'col-lg-4',
					'placeholder' => 'Name',
					'label' => false,
					'type' => 'textarea'
				));
				?>
			</div>
			<div class="form-group">
				<div class="col-lg-offset-5 col-lg-7">
					<button type="submit" class="btn btn-primary btn-sm">Save</button>
				</div>
			</div>
		</form>
	</div>
</div>
<?php

$code = '$(document).ready(function(){
		validate_list_add_form();
	});';

$code .= 'fetchEvents = function(elem) {
	var sel_fair = jQuery(elem).find(":selected").val();
	jQuery.ajax({
		 dataType : "json",
		url : basePath + "/fairs/fetchEvents",
		data : {fair_id:sel_fair}
	}).done(function(data){
		var html = \'<option value="">Select Event</option>\';
        $(data).each(function(index,element){
            html += \'<option value="\'+element.key+\'">\'+element.value+\'</option>\';
        });
        jQuery("#fair_events").html(html);
	});
}';

echo $this->Html->scriptBlock($code,array('block' => 'bottomScript'));

?>