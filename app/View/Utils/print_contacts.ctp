<div class="panel panel-primary">
	<div class="panel-heading"><h5>Contacts List</h5></div>
  	<div class="panel-body">
		<table class="table table-hover table-striped table-condensed">
			<thead>
				<tr>
					<th width="4%">No</th>
					<th width="15%">Name</th>
					<th>Address</th>
					<th width="5%">City</th>
					<th width="10%">Country</th>
					<th width="8%">Mobile</th>
					<th width="8%">Phone</th>
					<th width="5%">Email</th>
					<th width="10%">Fair</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$page = $this->Paginator->param('page');
				$limit = $this->Paginator->param('limit');
				$pages = $this->Paginator->param('pages');
				if( !empty( $contacts) ) {
					$counter = ($page - 1) * $limit;
					foreach ($contacts as $index => $contact) {
				?>
				<tr>
					<td><?php echo ++$counter; ?></td>
					<td><?php echo ucwords($contact['Contact']['first_name'].' '.$contact['Contact']['last_name']); ?></td>
					<td><?php echo $contact['Contact']['address']; ?></td>
					<td><?php echo $contact['Contact']['city']; ?></td>
					<td><?php echo $contact['Country']['nicename']; ?></td>
					<td><?php echo $contact['Contact']['mobile']; ?></td>
					<td><?php echo $contact['Contact']['phone']; ?></td>
					<td><?php echo $contact['Contact']['email']; ?></td>
					<td><?php echo isset($contact['Fair'][0]['name']) ? $contact['Fair'][0]['name'] : ''; ?></td>
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
	</div>
</div>
<?php
$code = '$(document).ready(function(){
	window.print();
});';
echo $this->Html->scriptBlock($code,array('block' => 'bottomScript'));
?>