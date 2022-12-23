<div class="panel panel-primary">
	<div class="panel-heading">
			<h4 class="pull-left">Duplicate(s) Record Found</h4>
			<div class="clearfix"></div>
		</div>
  	<div class="panel-body">
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th width="5%">&nbsp;</th>
					<th width="20%">Name</th>
					<th>Address</th>
					<th width="10%">Phone</th>
					<th width="5%">Email</th>
					<th width="5%">Mobile</th>
					<th width="5%">Fax</th>
					<th width="10%">Website</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if( !empty( $duplicateRecords) ){
					$counter = 1;
					foreach ($duplicateRecords as $index => $company) {
				?>
				<tr>
					<td>
						<span class="input-group-addon">
   	 						<input type="checkbox">
  						</span>
					</td>
					<td><?php echo ucwords($company['Company']['name']); ?></td>
					<td><?php echo $company['Company']['address']; ?></td>
					<td><?php echo $company['Company']['phone']; ?></td>
					<td><?php echo $company['Company']['email']; ?></td>
					<td><?php echo $company['Company']['mobile']?></td>
					<td><?php echo $company['Company']['fax']; ?></td>
					<td><?php echo $company['Company']['website']; ?></td>
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