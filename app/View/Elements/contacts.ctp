<table class="table table-hover table-striped">
	<thead>
		<tr>
			<th width="3%" class="text-center">#</th>
			<th width="8%">Bar Code</th>
			<th>Contact Name</th>
			<th width="15%">Address</th>
			<th width="10%">Email</th>
			<th width="8%">City</th>
			<th width="10%">Phone</th>
			<th width="10%">Guest of</th>
			<th width="7%">Webiste</th>
			<th width="7%">Source</th>
			<th width="2%" class="text-center">Shared</th>
			<th width="6%" class="text-center">Add to List</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$page = $this->Paginator->param('page');
		$count = $this->Paginator->param('count');
		$limit = $this->Paginator->param('limit');
		$pages = $this->Paginator->param('pageCount');
		$counter = ($page - 1) * $limit;
		if($contacts) {
			foreach($contacts as $contact) {
				$contact_uuid = $contact['Contact']['uuid'];
		?>
		<tr>
			<td class="text-center"><?php echo ++$counter; ?></td>
			<td><?php echo $contact['Contact']['bar_code']; ?></td>
			<td><?php echo $contact['Contact']['first_name'].' '.$contact['Contact']['last_name']; ?></td>
			<td><?php echo $contact['Contact']['address']; ?></td>
			<td><?php echo $contact['Contact']['email']; ?></td>
			<td><?php echo $contact['Contact']['city']; ?></td>
			<td><?php echo $contact['Contact']['phone']; ?></td>
			<td><?php echo $contact['Contact']['guest_off']; ?></td>
			<td><?php echo $contact['Contact']['website']; ?></td>
			<td><?php echo $contact['Contact']['source']; ?></td>
			<td class="text-center"><?php echo $contact['Contact']['shared'] == 1 ? 'Yes' : 'No'; ?></td>
			<td class="text-center">
				<a href="javascript:;" class="glyphicon glyphicon-plus-sign" onclick="addToInviteList('<?php echo $request_data['list_id']?>','<?php echo $contact_uuid; ?>',this)"></a>
				<img src="<?php echo $this->base ?>/img/loading.gif" id="loader_<?php echo $contact_uuid; ?>" style="display:none;" />
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
<?php

$script = 'var addToInviteList = function(list_id,contact_id,elem){
	jQuery(elem).css("display","none");
	jQuery("#loader_"+contact_id).css("display","");
	jQuery.ajax({
		type : "get",
		url : basePath + "/invites/addContactToInviteList",
		data : {list_uuid:list_id,contact_uuid:contact_id}
	}).done(function(data){
		jQuery(elem).removeClass("glyphicon-plus-sign").addClass("glyphicon-ok text-success fs14");
		jQuery(elem).css("display","");
		jQuery("#loader_"+contact_id).css("display","none");
	});
};';

echo $this->Html->scriptBlock($script,array('block' => 'bottomScript'));

?>