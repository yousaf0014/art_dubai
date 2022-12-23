<?php 
$flagChecked = '';
?>
<div class="panel panel-primary" id="mainFlagView">
	<div class="panel-heading">
    	<h4 class="pull-left">Flag</h4>
		<?php
		echo $this->Html->link(
			'',
			'javascript:;',
			array(
				'class' => 'glyphicon glyphicon-remove-circle pull-right text-primary f20',
				'onclick' => 'jQuery("#myFlag").modal("hide");'
			)
		);
		echo $this->Html->tag('div','',array('class' => 'clearfix'));
		?>
    </div>
    <div class="panel-body">
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th width="5%">No</th>
					<th width="20%">Color</th>
					<th width="25%">Title</th>
					<th width="25%">Added By</th>
					<th width="25%">Add Date</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if( !empty($contactFlag) ) {
					foreach($contactFlag as $key => $res){ 
						$color = '#'.$res['Flag']['color'];
						$title = $res['Flag']['title'];
						$flagChecked = $res['ContactFlag']['flag_id'];
						$addedById = $res['User']['first_name'].' '.$res['User']['last_name'];
						//$r_uuid = $res['Flag']['uuid'];
					?>
						<tr>
							<td>
								<?php echo $this->Html->tag('div',$key+1,array(
									'class' => 'pull-left'
								));?>
							</td>
							
							<td>
								<?php echo $this->Html->tag('div','',array(
									'class' => 'pull-left',
									'style' => 'height:20px;width:20px;background-color:'.$color
								));
								?>
							</td>
							
							<td>
								<?php echo $this->Html->tag('span',$title,array(
									'class' => 'pull-left'
								));
								?>
							</td>
							<td>
								<?php echo $this->Html->tag('span',$addedById,array(
									'class' => 'pull-left'
								));
								?>
							</td>
							<td><?php echo date("F j, Y",strtotime($res['ContactFlag']['created']));?></td>
						</tr>
						<?php
					}
				}else{
				?>
					<tr>
						<td colspan="4">No record found</td>
					</tr>
				<?php
				}
				?>
				<input type="hidden" id="contact_id" value="<?=$_REQUEST['contact_id']?>" />
			</tbody>
		</table>
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
			<table class="table table-hover table-striped">
			<thead>
				<tr>
				<th width="30%">Color</th>
					<th width="40%">Title</th>
					<th width="25%">Active</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if( !empty($flag) ){ 
					foreach($flag as $key=>$res){ 
						$color = '#'.$res['Flag']['color'];
						$title = $res['Flag']['title'];
						
						$r_uuid = $res['Flag']['uuid'];
						
						?>
						<tr>
							
							<td>
								<?php 
									echo $this->Html->tag('div','',array(
									'class' => 'pull-left',
									'style' => 'height:20px;width:20px;background-color:'.$color
								));
								?>
							</td>
							
							<td>
								<?php echo $this->Html->tag('span',$title,array(
									'class' => 'pull-left'
								));
								?>
							</td>
							<td>
								<input type="radio" <?php echo ($flagChecked!='' && $flagChecked==$res['Flag']['id'])?'checked':''?> name="data[Flag][setFlag]" value="<?=$res['Flag']['id']?>" />
							</td>
						</tr>
						<?php
					}
				}else{
				?>
					<tr>
						<td colspan="4">No record found</td>
					</tr>
				<?php
				}
				?>
				<input type="hidden" id="contact_id" value="<?=$_REQUEST['contact_id']?>" />
			</tbody>
		</table>
		</div>
	</div>
	</div>
</div>
<script>
$( document ).ready(function() {
	$("input:radio" ).click(function() {
		flag_id = $(this).val();
		contact_id = $('#contact_id').val();		
		$.post('<?=$this->base?>/flag/addContactFlag/'+flag_id+'/'+contact_id,function(data){
				$.post('<?=$this->base?>/flag/view?contact_id='+contact_id,function(data){
					$('#mainFlagView').html(data);
				});
		});
	});
});


</script>