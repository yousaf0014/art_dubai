<?php 
if(!$this->request->data){
	$this->request->data = $notes;
}
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<?php
		echo $this->Html->tag('h4','Edit Notes',array(
				'class' => 'pull-left'
			));
		echo $this->Html->tag('div','',array('class' => 'clearfix'))
		?>
	</div>
	<div class="panel-body">
		<div class="col-lg-6 col-lg-offset-1">
		<?php
			echo $this->Form->create(null,array(
					'method' => 'post',
					
					'role' => 'form',
					'class' => 'form-horizontal',
					'id' => 'addForm'
				));
		?>
		<div class="form-group">
			<?php
			echo $this->Html->tag('label','Title:',array('class' => 'control-label col-lg-3'));
			echo $this->Form->input('Notes.title',array(
					'div' => 'col-lg-8',
					'class' => 'form-control input-sm',
					'label' => false
				));
			?>
		</div>
		<div class="form-group">
			<?php
			echo $this->Html->tag('label','Description:',array('class' => 'control-label col-lg-3'));
			echo $this->Form->input('Notes.description',array(
					'class' => 'form-control input-sm',
					'label' => false,
					'div' => 'col-lg-8',
					'type' => 'textarea'
				));
			?>
		</div>
		<div class="form-group">
			<div class="col-lg-offset-9">
				<?php
				echo $this->Form->button('Save',array(
					'type' => 'submit',
					'class' => 'btn btn-primary btn-sm',
					'id' => 'save_note_btn'
				));
				echo $this->Html->image('/img/loading.gif',array(
					'style' => 'display:none;',
					'id' => 'save_note_loader'
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
echo $this->Html->script(array('fairs','jquery.validate.min','jquery.form'),array('block' => 'bottomScript'));
echo $this->Html->scriptStart(array('inline' => false,'block' => 'bottomScript'));
echo '$(document).ready(function() {
		validate_add_notes();
		jQuery("#addForm").ajaxForm({
			beforeSubmit: function(arr, $form, options) {
				jQuery("#save_note_btn").css("display","none");
				jQuery("#save_note_loader").css("display","");
				return true;
			},
			success : function(responseText,status,xhr,elm) {
				jQuery.ajax({
					url : basePath + "/notes/view?contact_id='.$contact_id.'",
				}).done(function(data){
					jQuery("#myNotes").html(data);
				});
			}
		});
	});';
echo $this->Html->scriptEnd();
?>