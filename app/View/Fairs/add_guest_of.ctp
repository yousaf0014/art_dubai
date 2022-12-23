<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="pull-left">Add Guest Of</h4>
		<a class="pull-right btn btn-default" href="<?php echo $this->request->referer(); ?>"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Go Back</a>
		<a href="javascript:;" onclick="$('#addGuestofForm').submit();" class="btn btn-default pull-right mr10">Save</a>	
		<div class="clearfix"></div>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" id="addGuestofForm" role="form" method="post" action="<?php echo $this->base ?>/Fairs/addGuestOf" enctype="multipart/form-data">
		
			 <div class="form-group">
                	<label class="control-label col-lg-2">Fair</label>
                    <div class="col-lg-3">
                    	<select name="data[guestOf][fair_id]" class="form-control input-sm">
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
                	<label class="control-label col-lg-2">Select Category</label>
                    <div class="col-lg-3">
					
                    	<select name="data[guestOf][invite_category_id]" class="form-control input-sm">
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
				<label for="inputName" class="col-lg-2 control-label">Name:</label>
				<div class="col-lg-3">
					<input class="form-control input-sm" id="inputName" placeholder="Name" name="data[guestOf][inputName]" value="">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label">No of Invites:</label>
				<div class="col-lg-3">
					<input type="text" id="invites" class="form-control input-sm" name="data[guestOf][invites]" placeholder="Invites" value="">
				</div>
			</div>
			<div class="form-group">
				<label for="inputName" class="col-lg-2 control-label">Guest Of:</label>
				<div class="col-lg-3">
					<input class="form-control input-sm" id="guest_of" placeholder="Guest Of" name="data[guestOf][guest_of]" value="">
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-offset-4 col-lg-5">
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</div>
			<input type="hidden" name="company_ids" value="<?=$_REQUEST['companyIds']?>" />
		</form>
	</div>
</div>
<?php
echo $this->Html->scriptStart(array('inline' => false,'block' => 'bottomScript'));

echo '$(document).ready(function() {
		validate_add_guestof_form();
	});';
echo $this->Html->scriptEnd();

?>
