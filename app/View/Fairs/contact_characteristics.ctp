<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="pull-left">Contact Characteristics</h4>
		<a class="pull-right btn btn-default btn-sm mt5" href="<?php echo $this->base ?>/Fairs/contactCategories">
			<span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Go Back
		</a>
		<a class="pull-right btn btn-default btn-sm mt5 mr10" href="<?php echo $this->base ?>/Fairs/addContactCharacteristic?CID=<?php echo $cID; ?>">
			<span class="glyphicon glyphicon-plus-sign"></span>&nbsp;Add
		</a>
		<div class="clearfix"></div>
	</div>
	<div class="panel-body">
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th width="5%">No</th>
					<th width="20%">Name</th>
					<th width="20%">Fair Category</th>
					<th>Description</th>
					<th width="5%">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if( !empty($contactCharacteristics) ){
					foreach ($contactCharacteristics as $key => $contactCharacteristic) {
				?>
				<tr>
					<td><?php echo $counter++ ?></td>
					<td><?php echo $contactCharacteristic['ContactCharacteristic']['name']; ?></td>
					<td><?php echo $contactCharacteristic['FairCategory']['name']; ?></td>
					<td><?php echo $contactCharacteristic['ContactCharacteristic']['description']; ?></td>
					<td>
						<a href="<?php echo $this->base ?>/Fairs/addContactCharacteristic?CID=<?php echo $cID; ?>&CCID=<?php echo $contactCharacteristic['ContactCharacteristic']['uuid']; ?>" class="glyphicon glyphicon-pencil mr5"></a>
						<a href="<?php echo $this->base ?>/Fairs/deleteContactCharacteristic?CCID=<?php echo $contactCharacteristic['ContactCharacteristic']['uuid']; ?>&CID=<?php echo $cID; ?>" class="glyphicon glyphicon-remove" onclick="return confirm('Are you sure?')"></a>
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