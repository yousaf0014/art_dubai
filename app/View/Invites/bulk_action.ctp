<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="pull-left"><?php echo ucwords(str_replace('_', ' ', $action)); ?></h4>
		<div class="pull-right">
			<a href="javascript:;" onclick="jQuery('#myModal').modal('hide')" class="glyphicon glyphicon-remove-circle f20"></a>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" method="post" action="<?php echo $this->base ?>/invites/bulkAction/<?php echo $action ?>/1" id="accept_reject_registration" enctype="multipart/form-data">
			<div class="form-group">
				<label class="control-label col-lg-3">Template:</label>
				<?php
				echo $this->Form->input('Template.uuid',array(
					'class' => 'form-control input-sm',
					'div' => 'col-lg-3',
					'label' => false,
					'type' => 'select',
					'options' => $templates,
					'empty' => '--Select--',
					'onchange' => 'getTemplate(this)'
				));
				?>
			</div>
			<div class="form-group">
				<label class="control-label col-lg-3">Subject:</label>
				<?php
				echo $this->Form->input('Template.subject',array(
					'class' => 'form-control input-sm',
					'div' => 'col-lg-6',
					'label' => false,
					'type' => 'text',
					'id' => 'template_subject'
				));
				?>
			</div>
			<div class="form-group">
				<label class="control-label col-lg-3">Template Header:</label>
				<?php
				echo $this->Form->input('Template.contents',array(
					'class' => 'form-control input-sm',
					'div' => 'col-lg-6',
					'label' => false,
					'type' => 'textarea',
					'id' => 'template_contents'
				));
				?>
			</div>
			<div class="form-group">
				<label class="control-label col-lg-3">Template Footer:</label>
				<?php
				echo $this->Form->input('Template.footer',array(
					'class' => 'form-control input-sm',
					'div' => 'col-lg-6',
					'label' => false,
					'type' => 'textarea',
					'id' => 'template_footer'
				));
				?>
			</div>
			<div class="form-group">
				<div class="col-lg-offset-8">
					<button class="btn btn-primary btn-sm" type="submit"><?php echo ucwords(str_replace('_', ' ', $action)); ?></button>
				</div>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('#template_contents,#template_footer').ckeditor({
			allowedContent : true
		});
		contact_uuids = jQuery(".contact_checkbox:checked").map(function() {
			return this.value;
		}).get();
		jQuery("#accept_reject_registration").ajaxForm({
			data : {contact_uuids:contact_uuids},
			success : function(responseText, statusText, xhr, $form){
				jQuery("#myModal").modal('hide');
				jQuery("#search_contacts_form").submit();
			}
		});
	});
	getTemplate = function(elem){
		jQuery.ajax({
			url : basePath + "/template/getTemplate",
			data : {template_id:jQuery(elem).find(':selected').val()},
			dataType : 'json'
		}).done(function(data){
			if(typeof data.Template != 'undefined'){
				CKEDITOR.instances['template_contents'].setData(data.Template.comments);
				CKEDITOR.instances['template_footer'].setData(data.Template.footer);
				jQuery("#template_subject").val(data.Template.title);
			}else{
				jQuery("#template_subject").val('');
				CKEDITOR.instances['template_contents'].setData('');
				CKEDITOR.instances['template_footer'].setData('');
			}
		});
	}
</script>