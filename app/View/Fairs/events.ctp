<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="pull-left">Events</h4>
		<a class="pull-right btn btn-default btn-sm mt5" href="<?php echo $this->base ?>/Fairs/viewFairs?FCID=<?php echo $fcID; ?>"><span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Go Back</a>
		<a class="pull-right btn btn-default mr10 btn-sm mt5" href="<?php echo $this->base ?>/Fairs/addEvent?FCID=<?php echo $fcID; ?>&FID=<?php echo $fID; ?>"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp;Add</a>
		<div class="clearfix"></div>
	</div>
	<div class="panel-body">
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th width="5%">No</th>
					<th width="20%">Name</th>
					<th>Location</th>
					<th width="8%">Duration</th>
					<th width="10%">Start Date</th>
					<th width="5%">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if( !empty($events) ){
					foreach ($events as $key => $event) {
				?>
				<tr>
					<td><?php echo $counter++ ?></td>
					<td><?php echo $event['FairEvent']['name']; ?></td>
					<td><?php echo $event['FairEvent']['location']; ?></td>
					<td><?php echo $event['FairEvent']['duration'].' '.$event['FairEvent']['duration_unit'].'(s)'; ?></td>
					<td><?php echo YMD2MDY($event['FairEvent']['start_date'],'/'); ?></td>
					<td>
						<a href="<?php echo $this->base ?>/Fairs/addEvent?FID=<?php echo $fID; ?>&FCID=<?php echo $fcID; ?>&FEID=<?php echo $event['FairEvent']['uuid']; ?>" class="glyphicon glyphicon-pencil mr5"></a>
						<a href="<?php echo $this->base ?>/Fairs/deleteEvent?FID=<?php echo $event['FairEvent']['uuid']; ?>&FCID=<?php echo $fcID; ?>&FEID=<?php echo $event['FairEvent']['uuid']; ?>" class="glyphicon glyphicon-remove" onclick="return confirm('Are you sure?')"></a>
					</td>
				</tr>
				<?php
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
</div>