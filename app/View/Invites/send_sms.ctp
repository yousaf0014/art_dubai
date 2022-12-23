<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="pull-left">Send SMS</h4>
		<?php
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
		<form method="post" action="<?php echo $this->base ?>/invites/sendSms?cil_id=<?php echo $cil_id; ?>" class="form-horizontal" role="form" id="sendSmsForm">
			<div class="form-group">
				<?php
				echo $this->Html->tag('label','Title:',array('class' => 'col-lg-2 control-label'));
				echo $this->Form->input('Template.title',array(
					'label' => false,
					'div' => 'col-lg-3',
					'class' => 'form-control input-sm',
					'type' => 'select',
					'options' => $templates,
					'empty' => 'Select Template',
					'onchange' => 'getTemplate(this)'
				));
				?>
			</div>
			<div class="form-group">
				<?php
				echo $this->Html->tag('label','Body:',array('class' => 'col-lg-2 control-label'));
				echo $this->Form->input('Template.body',array(
					'label' => false,
					'div' => 'col-lg-3',
					'class' => 'form-control input-sm',
					'type' => 'textarea',
					'id' => 'template_body'
				));
				?>
			</div>
			<div class="form-group">
				<div class="col-lg-offset-4">
				<?php
				echo $this->Form->button('Send',array(
					'type' => 'submit',
					'class' => 'btn btn-primary btn-sm',
				));
				?>
				</div>
			</div>
		</form>
	</div>
</div>

<?php

$script = 'jQuery(document).ready(function(){
	jQuery("#sendSmsForm").ajaxForm({
		beforeSubmit: function(arr, $form, options) {
			validate_form();
			if(jQuery("#sendSmsForm").valid()) {
				return true;
			}
			return false;
			// return false to cancel submit
		},
		success : function(responseText,xhr,elm) {
			jQuery("#myModal").modal("hide");
		}
	});
	
});';

$script .= 'validate_form = function(){
	jQuery("#sendSmsForm").validate({
		errorClass : "error",
		rules : {
			"data[Template][title]" : {required:true},
			"data[Template][body]" : {required:true},
		},
		messages : {
			"data[Template][title]" : {required:"Please select title"},
		},
		showErrors: function(errorMap, errorList) {
			show_errors(this,errorMap,errorList,"right");
		}
	});
};';

$script .= 'getTemplate = function(elem){
	var tmpl_id = jQuery(elem).find(":selected").val();
	jQuery.ajax({
		url : basePath + "/invites/getTemplate",
		dataType : "json",
		data : {tmpl_id:tmpl_id}
	}).done(function(data){
		jQuery("#template_body").html(data.Template.comments);
	});
}';

echo $this->Html->scriptBlock($script,array('block' => 'bottomScript'));

?>