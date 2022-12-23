<?php 
echo $this->Html->script('colpick');
echo $this->Html->css('colpick');

if(!$this->request->data){
	$this->request->data = $flag;
}
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<?php
		echo $this->Html->tag('h4',(isset($flag) && !empty($flag)) ? 'Edit Flag':'Add Flag',array(
				'class' => 'pull-left'
			));
		?>
		<a href="<?php echo $this->base ?>/Flag/flags" class="btn btn-default pull-right"><span class="glyphicon glyphicon-circle-arrow-left"></span>Go Back</a>
		<?php
		echo $this->Html->tag('div','',array('class' => 'clearfix'))
		?>
	</div>
	<div class="panel-body">
		<div class="col-lg-4 col-lg-offset-1">
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
			echo $this->Html->tag('label','Color:',array('class' => 'control-label col-lg-2'));
			echo $this->Form->input('Flag.color',array(
					'div' => 'col-lg-8',
					'class' => 'form-control input-sm',
					'label' => false
				));
			?>
		</div>
		<div class="form-group">
			<?php
			echo $this->Html->tag('label','Title:',array('class' => 'control-label col-lg-2'));
			echo $this->Form->input('Flag.title',array(
					'div' => 'col-lg-8',
					'class' => 'form-control input-sm',
					'label' => false
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
echo $this->Html->script(array('jquery.validate.min','jquery-ui-1.10.3.custom.min','fairs'), array('block' => 'script'));

echo $this->Html->scriptStart(array('inline' => false,'block' => 'bottomScript'));

echo '$(document).ready(function() {
		validate_add_flag();
	});';
echo $this->Html->scriptEnd();

?>
<script>
$('#FlagColor').colpick({
	layout:'rgbhex',
	submit:0,
	colorScheme:'dark',
	submit : true,
	onChange:function(hsb,hex,rgb,fromSetColor) {
		if(!fromSetColor) $('#picker3').val(hex).css('border-color','#'+hex);
	},
	onSubmit:function(hsb,hex,rgb,el) {
		$(el).val(hex);
		$(el).colpickHide();
	}
});
$('.colpick_color').keyup(function(){
	$(this).colpickSetColor(this.value);
});

</script>