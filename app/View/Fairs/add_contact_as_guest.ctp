<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="pull-left">Add Contact as Guest Of</h4>
		<a class="glyphicon glyphicon-remove-circle pull-right text-primary f20" href="javascript:;" onclick="hideModal('#myModal');"></a>
		<div class="clearfix"></div>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" id="addGuestofContactForm" role="form" method="post" action="<?php echo $this->base ?>/fairs/addContactAsGuest" enctype="multipart/form-data">
			<div class="form-group">
            	<?php
            	echo $this->Html->tag('label','Guest Of',array('class' => 'control-label col-lg-2'));
            	echo $this->Form->input('GuestOf.guest_of',array(
            		'label' => false,
            		'div' => 'col-lg-3',
            		'class' => 'form-control input-sm',
            		'type' => 'text',
            		'value' => $contact_name['Contact']['first_name'].' '.$contact_name['Contact']['last_name']
            	));
            	?>
            </div>
			<div class="form-group">
				<label class="control-label col-lg-2">Fair</label>
				<div class="col-lg-3">
					<select name="data[GuestOf][fair_id]" class="form-control input-sm" onchange="fetchEvents(this);">
	            		<option value="">Select Fair</option>
						<?php
	                	foreach($fairs as $index => $fairCategory) {
	            		?>
	                	<option value="<?php echo $fairCategory['Fair']['id']; ?>"><?php echo $fairCategory['Fair']['name']; ?></option>
	            		<?php
	                	}
	            		?>
	            	</select>
	        	</div>
            </div>
            <div class="form-group">
            	<?php
            	echo $this->Html->tag('label','Event',array('class' => 'control-label col-lg-2'));
            	echo $this->Form->input('GuestOf.event_id',array(
            		'label' => false,
            		'div' => 'col-lg-3',
            		'class' => 'form-control input-sm',
            		'type' => 'select',
            		'empty' => 'Select Event',
            		'id' => 'fair_events'
            	));
            	?>
            </div>
            <div class="form-group">
                	<label class="control-label col-lg-2">Select Category</label>
                    <div class="col-lg-3">
					
                    	<select name="data[GuestOf][invite_category_id]" class="form-control input-sm">
                    		<option value="">Select Category</option>
							<?php
                        	foreach($inviteCategories as $index => $inviteCategory) {
                    		?>
                        	<option value="<?php echo $inviteCategory['InviteCategory']['id']; ?>"><?php echo $inviteCategory['InviteCategory']['name']; ?></option>
                    		<?php
                        	}
                    		?>
                    	</select>
		             </div>
             </div>  
			<div class="form-group">
				<label for="inputName" class="col-lg-2 control-label">Invite List name:</label>
				<div class="col-lg-3">
					<input class="form-control input-sm" id="inputName" placeholder="Name" name="data[GuestOf][list_name]" value="">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label">No of Invites:</label>
				<div class="col-lg-3">
					<input type="text" id="invites" class="form-control input-sm" name="data[GuestOf][invites]" placeholder="Invites" value="">
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-offset-4 col-lg-5">
					<button type="submit" class="btn btn-primary btn-sm">Save</button>
				</div>
			</div>
			<input type="hidden" name="data[GuestOf][contact_uuid]" value="<?php echo $con_id; ?>" />
		</form>
	</div>
</div>
<?php

echo $this->Html->scriptStart(array('inline' => false,'block' => 'bottomScript'));

echo '$(document).ready(function() {
		validate_add_contact_as_form();
		jQuery("#addGuestofContactForm").ajaxForm({
			success : function(responseText,status,xhr,elm) {
				hideModal("#myModal");
			}
		});
	});';

echo 'fetchEvents = function(elem) {
	var sel_fair = jQuery(elem).find(":selected").val();
	jQuery.ajax({
		 dataType : "json",
		url : basePath + "/fairs/fetchEvents",
		data : {fair_id:sel_fair}
	}).done(function(data){
		var html = \'<option value="">Select Event</option>\';
        $(data).each(function(index,element){
            html += \'<option value="\'+element.key+\'">\'+element.value+\'</option>\';
        });
        jQuery("#fair_events").html(html);
	});
}';

echo $this->Html->scriptEnd();

?>
