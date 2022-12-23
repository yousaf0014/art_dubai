<div class="panel panel-primary">
	<div class="panel-heading">
			<h4 class="pull-left"><?php echo $fair['Fair']['name']; ?> Contacts List</h4>
			<a href="<?php echo $this->base ?>/Fairs/viewFairs?FCID=<?php echo $catID; ?>" class="pull-right btn btn-default btn-sm mt5"><span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Go Back</a>
			<a class="pull-right btn btn-default btn-sm mt5 mr10" href="<?php echo $this->base ?>/Fairs/addContact?CID=<?php echo $catID; ?>&FID=<?php echo $fair['Fair']['uuid']; ?>"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp;Add</a>
			<div class="clearfix"></div>
		</div>
  	<div class="panel-body">
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th width="5%">No</th>
					<th width="20%">Name</th>
					<th>Address</th>
					<th width="10%">Mobile</th>
					<th width="10%">Phone</th>
					<th width="5%">Email</th>
					<th width="13%" class="text-center">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$page = $this->Paginator->param('page');
				$limit = $this->Paginator->param('limit');
				$pages = $this->Paginator->param('pageCount');
				if( !empty( $contacts) ) {
					$counter = ($page - 1) * $limit;
					foreach ($contacts as $index => $contact) {
				?>
				<tr>
					<td><?php echo ++$counter; ?></td>
					<td><?php echo ucwords($contact['Contact']['first_name'].' '.$contact['Contact']['last_name']); ?></td>
					<td><?php echo $contact['Contact']['address']; ?></td>
					<td><?php echo $contact['Contact']['mobile']; ?></td>
					<td><?php echo $contact['Contact']['phone']; ?></td>
					<td><?php echo $contact['Contact']['email']; ?></td>
					<td class="text-center">
						<a href="<?php echo $this->base ?>/Fairs/tagCharacteristics?CONID=<?php echo $contact['Contact']['uuid']; ?>&CID=<?php echo $catID ?>&FID=<?php echo $fair['Fair']['uuid']; ?>">Characteristics</a>
						<a href="<?php echo $this->base ?>/Fairs/addContact?CONID=<?php echo $contact['Contact']['uuid']; ?>&CID=<?php echo $catID ?>&FID=<?php echo $fair['Fair']['uuid']; ?>" class="glyphicon glyphicon-pencil mr5"></a>
						<a href="<?php echo $this->base ?>/Fairs/deleteContact?CID=<?php echo $catID; ?>&COID=<?php echo $contact['Contact']['uuid']; ?>" class="glyphicon glyphicon-remove mr5" onclick="return confirm('Are you sure?')"></a>
						<a href="<?php echo $this->base ?>/Fairs/addContactDocuments?CID=<?php echo $catID; ?>&contact_uuid=<?php echo $contact['Contact']['uuid']; ?>&FID=<?php echo $fair['Fair']['uuid']; ?>" class="glyphicon glyphicon-upload"></a>
					</td>
				</tr>
				<?php
					}
				}else{
				?>
				<tr>
					<td colspan="7">No record found.</td>
				</tr>
				<?php
				}
				?>
			</tbody>
		</table>
		<?php if($pages > 1) { ?>
		<div class="col-lg-6">
			<ul class="pagination">
				<?php echo $this->Paginator->numbers(array('tag' => 'li','separator' => '','currentClass' => 'active','currentTag' => 'a' )); ?>
			</ul>
		</div>
		<?php } ?>
	</div>
</div>