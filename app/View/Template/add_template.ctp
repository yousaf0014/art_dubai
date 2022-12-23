<?php 
if(!$this->request->data){
	$this->request->data = $TemplateData;
}
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<?php
		echo $this->Html->tag('h4',(isset($TemplateData) && !empty($TemplateData))?'Edit Template':'Add Template',array(
				'class' => 'pull-left'
			));
		?>

		<a href="<?php echo $this->base ?>//template/view" class="btn btn-default btn-sm pull-right mt5">
			<span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Go Back
		</a>
		<?php
		echo $this->Html->tag('div','',array('class' => 'clearfix'))
		?>
	</div>
	<div class="panel-body">
		<div class="col-lg-7 col-lg-offset-1">
			<form action="<?php echo $this->base ?>/template/addTemplate?UID=<?php echo $uuid; ?>" method="post" class="form-horizontal" role="form" id="addForm" enctype="multipart/form-data">
				<div class="form-group">
					<?php
					echo $this->Html->tag('label','Title:',array('class' => 'control-label col-lg-3'));
					echo $this->Form->input('Template.title',array(
							'div' => 'col-lg-8',
							'class' => 'form-control input-sm',
							'label' => false
						));
					?>
				</div>
		
				<div class="form-group">
					<label class="col-lg-3 control-label">Type:</label>
					<div class="col-lg-8">
						<select name="data[Template][type]" class="form-control input-sm">
							<option value="">Please Select</option>
		            		<option value="1" <?=(isset($TemplateData['Template']['type']) && ($TemplateData['Template']['type']==1)?'selected="selected"':'')?>>SMS</option>
							<option value="2" <?=(isset($TemplateData['Template']['type']) && ($TemplateData['Template']['type']==2)?'selected="selected"':'')?>>Email</option>
						</select>
					</div>
				</div>
		
				<div class="form-group">
					<label class="col-lg-3 control-label">Template Header:</label>
					<div class="col-lg-9">
						<textarea class="form-control input-sm" rows="5" name="data[Template][comments]" id="template_header"><?php echo !empty($TemplateData['Template']['comments']) ? $TemplateData['Template']['comments'] : ''; ?></textarea>
					</div>
				</div>

				<div class="form-group">
					<label class="col-lg-3 control-label">Template Footer:</label>
					<div class="col-lg-9">
						<textarea class="form-control input-sm" rows="5" name="data[Template][footer]" id="template_footer"><?php echo !empty($TemplateData['Template']['footer']) ? $TemplateData['Template']['footer'] : ''; ?></textarea>
					</div>
				</div>

				<div class="form-group">
					<div class="col-lg-offset-10">
						<?php
						echo $this->Form->button('Save',array(
								'type' => 'submit',
								'class' => 'btn btn-primary btn-sm'
							));
						?>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<?php
echo $this->Html->script(array('jquery.validate.min','ckeditor/ckeditor','ckeditor/adapters/jquery','jquery-ui-1.10.3.custom.min','fairs'), array('block' => 'script'));

echo $this->Html->scriptStart(array('inline' => false,'block' => 'bottomScript'));

echo '$(document).ready(function() {
		validate_add_Template();
		jQuery("#template_header,#template_footer").ckeditor({
			allowedContent : true
		});
	});';
echo $this->Html->scriptEnd();
?>