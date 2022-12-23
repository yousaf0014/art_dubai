<div class="panel panel-primary">
	<div class="panel-heading">
    	<h4 class="pull-left">Flags</h4>
        <a class="btn btn-default pull-right" href="<?php echo $this->base ?>/flag/addFlag"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp;Add</a>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th width="5%">No</th>
					<th width="30%">Color</th>
					<th width="60%">Title</th>
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
								<?php echo $this->Html->tag('div',$key+1,array(
									'class' => 'pull-left'
								));?>
							</td>
							
							<td>
								<?php echo $this->Html->tag('div','',array(
									'class' => 'pull-left',
									'style' => 'height:20px;width:50px;background-color:'.$color
								));?>
							</td>
							
							<td>
								<?php echo $this->Html->tag('span',$title,array(
									'class' => 'pull-left'
								));
								echo $this->Html->link('','/Flag/deleteFlag?FID='.$r_uuid,array(
									'class' => 'pull-right glyphicon glyphicon-remove',
									'onclick' => "return confirm('Are you sure?');"
								));
								echo $this->Html->link('','/Flag/addFlag?FID='.$r_uuid,array(
									'class' => 'pull-right glyphicon glyphicon-pencil mr10'
								));
								?>
							</td>
						</tr>
						<?php
					}
				}else{ ?>
					<tr>
						<?php echo $this->Html->tag('td','No record found',array('colspan' => '3'));?>
					</tr>
				<?php }
				?>
			</tbody>
		</table>
    	
    </div>
</div>