<div class="panel panel-primary">
	<div class="panel-heading">
    	<h4 class="pull-left">Templates</h4>
		<a href="<?php echo $this->base; ?>/template/addTemplate" class="pull-right btn btn-default btn-sm mt5"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp;Add</a>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
		<table class="table table-hover table-striped">
		<?php 
			if( !empty($Template) ){?>
			<thead>
				<tr>
					<th width="5%" class="text-center">No</th>
					<th width="20%">Title</th>
					<th width="45%">Description</th>
					<th width="30%">Type</th>					
				</tr>
			</thead>
			<tbody>
				<?php
				
				$page = $this->Paginator->param('page');
				$limit = $this->Paginator->param('limit');
				$pages = $this->Paginator->param('pageCount');
				$counter = ($page - 1) * $limit;

				foreach($Template as $key=>$res){ 
					
					$title = $res['Template']['title'];
					$description = substr($res['Template']['comments'], 0,300);
					$type = $res['Template']['type'];
						
					$r_uuid = $res['Template']['uuid'];
						
				?>
						<tr>
							<td class="text-center">
							<?php echo ++$counter ?>
							</td>
							
							<td>
								<?php echo $title ?>
							</td>
							
							<td>
								<?php echo $description ?>
							</td>
							<td>
								<?php 
								if($type == 1) {
									echo 'SMS';
								}elseif($type == 2) {
									echo 'Email';
								}else{
									echo 'e-Invite';
								}

								echo $this->Html->link('','/template/deleteTemplate?UID='.$r_uuid,array(
									'class' => 'pull-right glyphicon glyphicon-remove',
									'onclick' => "return confirm('Are you sure?');"
								));
								echo $this->Html->link('','/template/addTemplate?UID='.$r_uuid,array(
									'class' => 'pull-right glyphicon glyphicon-pencil mr10'
								));
								?>
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
			</tbody>
		</table>
    	<?php if($pages > 1) { ?>
		<div class="col-lg-6">
			<?php
			$this->Paginator->options(array(
				'url' => $request_data
			));
			echo $this->element('pagination_links',array('class' => 'ajx_pagination'));
			?>
		</div>
		<?php } ?>
    </div>
</div>