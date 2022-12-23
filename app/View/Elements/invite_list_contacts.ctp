<div>
	<hr>
	<div class="pull-left">
		<a href="javascript:;" class="text-primary" onclick="bulkAction('sms');">SMS</a>&nbsp;|&nbsp;
		<a class="text-muted" onclick="bulkAction('send_invitation');" href="javascript:;">Send Invitation</a>
	</div>
	<div class="pull-right">
		<label>
		<?php
	  	
	  	echo $this->Paginator->counter(
	  			'Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}'
	  		);
	  		
	  	?>
	  	</label>
	</div>
	<div class="clearfix"></div>
</div>
<table class="table table-hover table-striped">
	<thead>
		<tr>
			<th width="2%" class="text-center">
				<input type="checkbox" onclick="checkboxStatus(this);">
			</th>
			<th width="5%" class="text-center">
				<a class="glyphicon glyphicon-remove-circle text-danger fs14" id="delete_all_a" title="remove from list" href="javascript:;" onclick="bulkDelete('delete')">&nbsp;</a>
			</th>
			<th width="3%" class="text-center">#</th>
			<th width="10%">Bar Code</th>
			<th><?php echo $this->Paginator->sort('Contact.first_name','First Name'); ?></th>
			<th><?php echo $this->Paginator->sort('Contact.last_name','Last Name'); ?></th>
			<th width="8%"><?php echo $this->Paginator->sort('Contact.email','Email')?></th>
			<th width="8%"><?php echo $this->Paginator->sort('Contact.city','City')?></th>
			<th width="8%"><?php echo $this->Paginator->sort('Contact.phone','Phone')?></th>
			<th width="8%"><?php echo $this->Paginator->sort('Contact.guest_off','Guest of')?></th>
			<th width="12%">Invite List</th>	
			<?php if(!empty($request_data['view']) && $request_data['view'] == 'full') { ?>
			<th width="7%">Webiste</th>
			<th width="7%">Source</th>
			<th width="7%">Facebook</th>
			<th width="7%">Twitter</th>
			<th width="7%">Linkedin</th>
			<th width="7%">Instagram</th>
			<th width="2%">Shared</th>
			<?php } ?>
			<th width="2%" class="text-center">
				<img src="<?php echo $this->base ?>/img/loading.gif" id="invited_all_loading" style="display:none;" />
				<a href="javascript:;" onclick="toggle_actions('invited');" id="invited_all_a" class="glyphicon glyphicon-remove-circle text-danger fs14"></a>&nbsp;Invited
			</th>
			<th width="2%" class="text-center">
				<img src="<?php echo $this->base ?>/img/loading.gif" id="printed_all_loading" style="display:none;" />
				<a href="javascript:;" id="printed_all_a" class="glyphicon glyphicon-remove-circle text-danger fs14"></a>&nbsp;Printed
			</th>
			<th width="2%" class="text-center">
				<img src="<?php echo $this->base ?>/img/loading.gif" id="attended_all_loading" style="display:none;" />
				<a href="javascript:;" onclick="toggle_actions('attended');" id="attended_all_a" class="glyphicon glyphicon-remove-circle text-danger fs14"></a>&nbsp;Attended&nbsp;
			</th>
			<th width="2%" class="text-center">
				<img src="<?php echo $this->base ?>/img/loading.gif" id="sms_list_all_loading" style="display:none;" />
				<a href="javascript:;" <?php /*onclick="toggle_actions('sms_list');" id="sms_list_all_a" */?> class="glyphicon glyphicon-remove-circle text-danger fs14"></a>&nbsp;SMS
			</th>
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
				$ci_id = $contact['ContactsInviteList']['id'];
		?>
		<tr>
			<td class="text-center">
				<input type="checkbox" class="contact_checkbox" value="<?php echo $contact['Contact']['uuid']; ?>">
			</td>
			<td class="text-center">
				<a href="<?php echo $this->base ?>/invites/removeContact?ID=<?php echo $ci_id; ?>" onclick="return confirm('Are you sure?');" title="remove from list" class="glyphicon glyphicon-remove-circle text-danger fs14"></a>
				<a title="Edit contact" class="glyphicon glyphicon-pencil ml5 fs14" href="<?php echo $this->base ?>/fairs/addContact?CONID=<?php echo $contact['Contact']['uuid']?>&FROM=invites&list_id=<?php echo $request_data['list_id']; ?>"></a>
				<input type="hidden" value="<?php echo $contact['ContactsInviteList']['id']; ?>" class="contact_list_id">
			</td>
			<td class="text-center"><?php echo ++$counter; ?></td>
			<td><?php echo $contact['Contact']['bar_code']; ?></td>
			<td><?php echo $contact['Contact']['first_name']; ?></td>
			<td><?php echo $contact['Contact']['last_name']; ?></td>
			<td><?php echo $contact['Contact']['email']; ?></td>
			<td><?php echo $contact['Contact']['city']; ?></td>
			<td><?php echo $contact['Contact']['phone']; ?></td>
			<td><?php echo $contact['Contact']['guest_off']; ?></td>
			<td><?php echo $contact['InviteList']['name']; ?></td>
			<?php if(!empty($request_data['view']) && $request_data['view'] == 'full') { ?>
			<td><?php echo $contact['Contact']['website']; ?></td>
			<td><?php echo $contact['Contact']['source']; ?></td>
			<td><?php echo $contact['Contact']['facebook']; ?></td>
			<td><?php echo $contact['Contact']['twitter']; ?></td>
			<td><?php echo $contact['Contact']['linkedin']; ?></td>
			<td><?php echo $contact['Contact']['instagram']; ?></td>
			<td><?php echo $contact['Contact']['shared'] == 1 ? 'Yes' : 'No'; ?></td>
			<?php } ?>
			<td class="text-center">
				<?php
				$invited_class = $contact['ContactsInviteList']['invited'] == 1 ? 'glyphicon-ok text-success' : 'glyphicon-remove-circle text-danger';
				?>
				<a href="javascript:;" onclick="toggle_action('invited','<?php echo $ci_id; ?>',this);" class="glyphicon <?php echo $invited_class; ?> fs14 invited"></a>
				<img src="<?php echo $this->base ?>/img/loading.gif" id="invited_<?php echo $ci_id; ?>" style="display:none;" />
			</td>
			<td class="text-center">
				<?php
				$printed_class = $contact['ContactsInviteList']['printed'] == 1 ? 'glyphicon-ok text-success' : 'glyphicon-remove-circle text-danger';
				?>
				<a href="<?php echo $this->base ?>/invites/printListContact?CONID=<?php echo $contact['Contact']['uuid']; ?>&clist_id=<?php echo $ci_id; ?>" class="glyphicon <?php echo $printed_class; ?> fs14 printed" data-toggle="modal" data-keyboard="false" data-backdrop="static" data-target="#myModal"></a>
				<img src="<?php echo $this->base ?>/img/loading.gif" id="printed_<?php echo $ci_id; ?>" style="display:none;" />
			</td>
			<td class="text-center" id="attended_<?php echo $contact['ContactsInviteList']['id']; ?>">
				<?php
				$attended_class = $contact['ContactsInviteList']['attended'] == 1 ? 'glyphicon-ok text-success' : 'glyphicon-remove-circle text-danger';
				if($contact['ContactsInviteList']['attended']) {
				?>
				<span  class="glyphicon glyphicon-ok text-success fs14"></span>
				<?php
				}else{
				?>
				<a href="javascript:;" onclick="toggle_action('attended','<?php echo $ci_id; ?>',this);" class="glyphicon <?php echo $attended_class; ?> fs14 attended"></a>
				<img src="<?php echo $this->base ?>/img/loading.gif" id="attended_<?php echo $ci_id; ?>" style="display:none;" />
				<?php 
				}
				?>
			</td>
			<td class="text-center">
				<?php
				$sms_class = $contact['ContactsInviteList']['sms'] == 1 ? 'glyphicon-ok text-success' : 'glyphicon-remove-circle text-danger';
				?>
				<a href="<?php echo $this->base ?>/invites/sendSms?cil_id=<?php echo $ci_id; ?>"  class="glyphicon <?php echo $sms_class; ?> fs14 sms_list" data-toggle="modal" data-keyboard="false" data-backdrop="static" data-target="#myModal"></a>
				<img src="<?php echo $this->base ?>/img/loading.gif" id="sms_<?php echo $ci_id; ?>" style="display:none;" />
			</td>
		</tr>
		<?php 
			}
		}else{
		?>
		<tr>
			<td colspan="13">
				<?php
				if(!empty($request_data['is_search_init'])) {
					echo 'No record found in list.';
					echo $this->Html->link('Search in Contacts','/invites/index?'.http_build_query($search_in_contacts),array(
						'class' => 'ml10'
					));
				}else{
					echo 'No record found.';
				}
				?>
			</td>
		</tr>
		<?php
		}
		?>
	</tbody>
</table>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>

<?php

$script = '$(document).ready(function(){
	$("body").on("hidden.bs.modal", ".modal", function () {
    	$(this).removeData("bs.modal");
    });
});';

echo $this->Html->scriptBlock($script,array('block' => 'bottomScript'));

?>