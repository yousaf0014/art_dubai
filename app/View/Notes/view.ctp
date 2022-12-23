<?php 
if(!$this->request->data){
	$this->request->data = $notes;
}
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="pull-left">Notes</h4>
		<?php
		echo $this->Html->link(
			'',
			'javascript:;',
			array(
				'class' => 'glyphicon glyphicon-remove-circle pull-right text-primary f20',
				'onclick' => 'jQuery("#myNotes").modal("hide");'
			)
		);
		?>
		<div class="clearfix"></div>
	</div>
  	<div class="panel-body">
  		<div class="hgt">
			<table class="table table-hover table-striped">
				<thead>
					<tr>
						<th width="5%">No</th>
						<th width="20%">Title</th>
						<th width="40%">Description</th>
						<th width="15%">Added by</th>
						<th width="15%">Date</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$page = $this->Paginator->param('page');
					$limit = $this->Paginator->param('limit');
					$pages = $this->Paginator->param('pages');
					if(!empty($notes)) {
						$counter = ($page - 1) * $limit;
						foreach ($notes as $index => $e) {
							$e_uuid = $e['Notes']['uuid'];
							echo $this->Html->tableCells(array(
						    array(
						    		++$counter, 
						    		$e['Notes']['title'],
						    		$e['Notes']['description'],
									$e['User']['first_name'].' '.$e['User']['last_name'],
									date("F j, Y",strtotime($e['Notes']['created'])),
						    		$this->Html->link('', 'javascript:void(0)', array(
						    				'title' => 'Edit',
											'onclick' => 'editFun("'.$e_uuid.'",'.$contact_id.')',
						    				'class' => 'glyphicon glyphicon-pencil mr10'
						    			)
						    		).$this->Html->link('', '/notes/deleteNotes?NID='.$e_uuid, array(
						    				'title' => 'Delete',
						    				'class' => 'glyphicon glyphicon-remove',
						    				'onclick' => "return confirm('Are you sure?')"
						    			)
						    		)
						    	),
						));
						}
					}else{
					?>
					<tr>
						<td colspan="6">No record found.</td>
					</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
		<?php if($pages > 1) { ?>
		<div class="col-lg-6">
			<ul class="pagination">
				<?php echo $this->Paginator->numbers(array('tag' => 'li','separator' => '','currentClass' => 'active','currentTag' => 'a' )); ?>
			</ul>
		</div>
		<?php } ?>
	</div>
	<div class="panel-body" id="AddNotes">
		<div class="panel panel-primary">
		<div class="panel-heading">
		
			<?php
			echo $this->Html->tag('h4','Add Notes',array(
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
						'action' => 'addNotes',
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
				<input type="hidden" class="form-control" name="data[Notes][contact_id]" value="<?=$_REQUEST['contact_id']?>" />
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
<script>
function editFun(id,contact_id) {
	$.post('<?=$this->base?>/Notes/addNotes?contact_id='+contact_id+'&NID='+id,function(data){
		$('#AddNotes').html(data);
	});
}
</script>