<div class="panel panel-primary">
	<div class="panel-heading">
		<?php
		echo $this->Html->tag('h4','Create Invite List',array('class' => 'pull-left'));
		echo $this->Html->link(
			'',
			'javascript:;',
			array(
				'class' => 'glyphicon glyphicon-remove-circle pull-right text-primary f20',
				'onclick' => 'jQuery("#myModal").modal("hide");'
			)
		);
		echo $this->Html->tag('div','',array('class' => 'clearfix'));
		?>
	</div>
	<div class="panel-body">
		<?php
		echo $this->Form->create(
			'InviteList',
			array(
				'class' => 'form-horizontal',
				'role' => 'form', 
				'id' => 'form_creat_list'
			)
		);
		?>
		<?php if(!empty($invite_categories) && !empty($fairs)) { ?>
		<div class="form-group">
		<?php
			echo $this->Html->tag('label','Select Invitation Type:',array('class' => 'col-lg-2 control-label'));
			echo $this->Form->input('InviteList.invite_category_id',array(
				'label' => false,
				'class' => 'form-control input-sm',
				'div' => 'col-lg-4',
				'type' => 'select',
				'empty' => '--Select--',
				'options' => $invite_categories
			));
		?>
		</div>
		<div class="form-group">
		<?php
			echo $this->Html->tag('label','Fair:',array('class' => 'col-lg-2 control-label'));
			echo $this->Form->input('InviteList.fair_id',array(
				'label' => false,
				'class' => 'form-control input-sm',
				'div' => 'col-lg-4',
				'type' => 'select',
				'empty' => '--Select--',
				'options' => $fairs,
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
		<div class="form-group">
		<?php
			echo $this->Html->tag('label','Name:',array('class' => 'col-lg-2 control-label'));
			echo $this->Form->input('InviteList.name',array(
				'label' => false,
				'class' => 'form-control input-sm',
				'div' => 'col-lg-4',
				'type' => 'text'
			));
			echo $this->Html->tag('div','OR',array('class' => 'col-lg-1 mt10'))
		?>
		</div>
		<div class="form-group">
		<?php
			echo $this->Html->tag('label','Select from predefined List',array('class' => 'col-lg-2 control-label'));
			echo $this->Form->input('InviteList.id',array(
				'label' => false,
				'class' => 'form-control input-sm',
				'div' => 'col-lg-4',
				'type' => 'select',
				'empty' => '--Select--',
				'onchange' => 'reset_form(this)',
				'options' => $optGroups
			));
		?>
		</div>
		<?php } ?>
		<div class="form-group">
			<div class="col-lg-offset-5">
			<?php
			echo $this->Form->button('Save',array(
					'type' => 'submit',
					'class' => 'btn btn-primary btn-sm'
				)
			);
			?>
			</div>
		</div>
		<?php
		echo $this->Form->end();
		?>
	</div>
</div>

<?php

$script = 'jQuery(document).ready(function(){
	jQuery("#form_creat_list").ajaxForm({
		beforeSubmit: function(arr, $form, options) {
			if(jQuery("#InviteListId").val() == "") {
				validate_form();
				if(jQuery("#form_creat_list").valid()) {
					return true;
				}
			}else if(jQuery("#InviteListId").val() != ""){
				jQuery("#form_creat_list").validate().resetForm();
				return true;
			}
			return false;
			// return false to cancel submit
		},
		dataType : "json",
		success : function(responseText,xhr,elm) {
			jQuery("#myModal").modal("hide");
		}
	});
});';

$script .= 'var validate_form = function(){
	jQuery("#form_creat_list").validate({
		debug: true,
		errorClass : "error",
		rules : {
			"data[InviteList][name]" : {required:true},
			"data[InviteList][invite_category_id]" : {required:true},
			"data[InviteList][fair_id]" : {required:true},
			"data[InviteList][fair_event_id]" : {required:true}
		},
		messages : {
			"data[InviteList][name]" : {required:"Please enter name"},
			"data[InviteList][fair_id]" : {required:"Please select a fair"},
			"data[InviteList][invite_category_id]" : {required:"Please select category"},
			"data[InviteList][fair_event_id]" : {required:"Please select event"}
		},
		showErrors: function(errorMap, errorList) {
			show_errors(this,errorMap,errorList,"right");
		}
	});
};';

$script .= 'var reset_form = function(elem){
	if(jQuery(elem).val() != ""){
		jQuery(".popover").hide();
	}
};';

$script .= 'fetchEvents = function(elem) {
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

echo $this->Html->scriptBlock($script,array('block' => 'bottomScript'));

?>