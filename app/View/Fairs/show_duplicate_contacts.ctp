<?php
echo $this->Html->script('fairs',array('block' => 'bottomScript'));
$query = $this->request->query;
$query_string = http_build_query($query);
?>
<div class="panel panel-primary">
	<div class="panel-heading">
			<h4 class="pull-left">Duplicate Record(s) Found</h4>
			<div class="clearfix"></div>
		</div>
  	<div class="panel-body">
    	<p class="text-warning">The information you enterted match with the following record(s) in the system. You can overwrite the existing record or make changes by clicking back link but you can stil add new record.</p>
  		<form method="post" action="<?php echo $this->base ?>/fairs/addContact?<?php echo $query_string; ?>&OW=1" id="companyForm">
			<table class="table table-hover table-striped">
				<thead>
					<tr>
                    	<th width="2%">&nbsp;</th>
						<th width="10%">First Name</th>
                        <th width="10%">Last Name</th>
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
						foreach ($duplicateRecords as $index => $contact) {
					?>
					<tr>
						<td>
          					<input id="chk_<?php echo $contact['Contact']['uuid']; ?>" type="checkbox" name="data[Contact][uuid][]" value="<?php echo $contact['Contact']['uuid']; ?>" onclick="toggle_btn()" class="chk-co" >
						</td>
                        <td class="<?php echo strtolower($contact_data['first_name']) == strtolower($contact['Contact']['first_name']) ? 'danger' : ''; ?>"><label for="chk_<?php echo $contact['Contact']['uuid']; ?>"><?php echo ucwords($contact['Contact']['first_name']); ?></label></td>
                        <td class="<?php echo strtolower($contact_data['last_name']) == strtolower($contact['Contact']['last_name']) ? 'danger' : ''; ?>"><label for="chk_<?php echo $contact['Contact']['uuid']; ?>"><?php echo ucwords($contact['Contact']['last_name']); ?></label></td>
						<td class="<?php echo $contact_data['phone'] == $contact['Contact']['phone'] ? 'danger' : ''; ?>"><?php echo $contact['Contact']['phone']; ?></td>
						<td class="<?php echo $contact_data['email'] == $contact['Contact']['email'] ? 'danger' : ''; ?>"><?php echo $contact['Contact']['email']; ?></td>
						<td class="<?php echo !empty($contact_data['mobile']) && $contact_data['mobile'] == $contact['Contact']['mobile'] ? 'danger' : ''; ?>"><?php echo $contact['Contact']['mobile']?></td>
						<td class="<?php echo !empty($contact_data['fax']) && $contact_data['fax'] == $contact['Contact']['fax'] ? 'danger' : ''; ?>"><?php echo $contact['Contact']['fax']; ?></td>
						<td class="<?php echo !empty($contact_data['website']) && $contact_data['website'] == $contact['Contact']['website'] ? 'danger' : ''; ?>"><?php echo $contact['Contact']['website']; ?></td>
					</tr>
					<?php
						}
					}
					?>
				</tbody>
			</table>
            <a href="<?php echo $this->base ?>/fairs/addContact?<?php echo $query_string; ?>&EDIT=1" class="btn btn-primary pull-left">Go Back &amp; Edit Info</a>
			<div class="pull-right">
				<button type="button" class="btn btn-defautl" id="write_default">Overwrite</button>
				<a class="btn btn-primary" href="javascript:;" onclick="$('#companyForm').submit();" style="display:none;" id="write_primary">Overwrite Selected</a>
				<a class="btn btn-primary" href="<?php echo $this->base ?>/fairs/addContact?<?php echo $query_string; ?>&NEW=1">Continue With Add/Edit Record</a>
			</div>
			<div class="clearfix"></div>
		</form>
	</div>
</div>