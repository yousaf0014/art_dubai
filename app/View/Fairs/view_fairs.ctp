<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="pull-left"><?php echo $fairCat['FairCategory']['name']; ?></h4>
		<a href="<?php echo $this->base ?>/Fairs" class="pull-right btn btn-default btn-sm mt5"><span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Go Back</a>
		<a class="pull-right btn btn-default btn-sm mt5 mr10" href="<?php echo $this->base ?>/Fairs/add?FCID=<?php echo $fairCat['FairCategory']['uuid']; ?>"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp;Add</a>
		<div class="clearfix"></div>
	</div>
  	<div class="panel-body">
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th width="5%">No</th>
					<th width="20%">Name</th>
					<th>Location</th>
					<th width="5%">Duration</th>
					<th width="6%">Start Date</th>
					<th width="5%">Year</th>
					<th width="12%" class="text-center">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if( !empty( $fairs) ){
					foreach ($fairs as $key => $fair) {
				?>
				<tr>
					<td><?php echo $counter++; ?></td>
					<td><?php echo ucwords($fair['Fair']['name']); ?></td>
					<td><?php echo $fair['Fair']['location']; ?></td>
					<td><?php echo $fair['Fair']['duration'].' '.$fair['Fair']['duration_unit']; ?>(s)</td>
					<td><?php echo YMD2MDY($fair['Fair']['start_date'],'/'); ?></td>
					<td><?php echo $fair['Fair']['year']; ?></td>
					<td>
						<a class="mr5" href="<?php echo $this->base ?>/Fairs/contacts?CID=<?php echo $fairCat['FairCategory']['uuid']; ?>&FID=<?php echo $fair['Fair']['uuid']; ?>">Contacts</a>
						<a class="mr5" href="<?php echo $this->base ?>/Fairs/events?FID=<?php echo $fair['Fair']['uuid']; ?>&FCID=<?php echo $fairCat['FairCategory']['uuid']?>">Events</a>
						<a href="<?php echo $this->base ?>/Fairs/add?FID=<?php echo $fair['Fair']['uuid']; ?>&FCID=<?php echo $fairCat['FairCategory']['uuid']; ?>" class="glyphicon glyphicon-pencil mr5"></a>
						<a href="<?php echo $this->base ?>/Fairs/delete?FID=<?php echo $fair['Fair']['uuid']; ?>" class="glyphicon glyphicon-remove" onclick="return confirm('Are you sure?')"></a>
					</td>
				</tr>
				<?php
					}
				}else{
				?>
				<tr>
					<td colspan="8">No record found.</td>
				</tr>
				<?php
				}
				?>
			</tbody>
		</table>
		<?php echo $this->element('pagination_links'); ?>
	</div>
</div>