<div class="panel panel-primary">
	<div class="panel-heading">
			<h4 class="pull-left">Duplicate Record(s) Found</h4>
			<div class="clearfix"></div>
		</div>
  	<div class="panel-body">
  		<p class="text-warning">The information you enterted match with the following record(s) in the system. You can overwrite the existing record or make changes by clicking back link but you can stil add new record.</p>
  		<form method="post" action="<?php echo $this->base ?>/Fairs/addCompany?CID=<?php echo $catID; ?>&COID=<?php echo $coID; ?>&OW=1" id="companyForm">
  			<div class="table-responsive">
				<table class="table table-hover table-striped">
					<thead>
						<tr>
	                    	<th width="2%">&nbsp;</th>
							<th>Name</th>
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
							foreach ($duplicateRecords as $index => $company) {
						?>
						<tr>
							<td>
	          					<input id="chk_<?php echo $company['Company']['uuid']; ?>" type="checkbox" name="data[Company][uuid][]" value="<?php echo $company['Company']['uuid']; ?>" onclick="toggle_btn()" class="chk-co" >
							</td>
	                        <td class="<?php echo $company['Company']['name'] == $company_data['name'] ? 'danger' : ''; ?>"><label for="chk_<?php echo $company['Company']['uuid']; ?>"><?php echo ucwords($company['Company']['name']); ?></label></td>
							<td class="<?php echo $company['Company']['phone'] == $company_data['phone'] ? 'danger' : ''; ?>"><?php echo $company['Company']['phone']; ?></td>
							<td class="<?php echo $company['Company']['email'] == $company_data['email'] ? 'danger' : ''; ?>"><?php echo $company['Company']['email']; ?></td>
							<td class="<?php echo $company['Company']['mobile'] == $company_data['mobile'] ? 'danger' : ''; ?>"><?php echo $company['Company']['mobile']?></td>
							<td class="<?php echo $company['Company']['fax'] == $company_data['fax'] ? 'danger' : ''; ?>"><?php echo $company['Company']['fax']; ?></td>
							<td class="<?php echo $company['Company']['website'] == $company_data['website'] ? 'danger' : ''; ?>"><?php echo $company['Company']['website']; ?></td>
						</tr>
						<?php
							}
						}
						?>
					</tbody>
				</table>
			</div>
			<a href="<?php echo $this->base ?>/Fairs/addCompany?CID=<?php echo $catID; ?>&COID=<?php echo $coID; ?>&EDIT=1" class="btn btn-primary pull-left btn btn-sm" id="go_back_url">Go Back &amp; Edit Info</a>
			<div class="pull-right">
				<button type="button" class="btn btn-defautl" id="write_default">Overwrite</button>
				<a class="btn btn-primary btn-sm" href="javascript:;" onclick="$('#companyForm').submit();" style="display:none;" id="write_primary">Overwrite Selected</a>
				<a class="btn btn-primary btn-sm" href="<?php echo $this->base ?>/Fairs/addCompany?CID=<?php echo $catID; ?>&COID=<?php echo $coID; ?>&NEW=1" id="go_next_url">Continue To Add New Record</a>
			</div>
			<div class="clearfix"></div>
		</form>
	</div>
</div>
<?php
if($is_ajax) {
	$code = '$(document).ready(function(){
		$("#companyForm").ajaxForm({
			dataType : "json",
			success : function(responseText,xhr,elm) {
				addContact(responseText);
				jQuery("#myModal").modal("hide");

			}
		});
		$("#go_back_url").click(function(e){
			e.preventDefault();
			jQuery.ajax({
				type : "get",
				url : $("#go_back_url").attr("href")
			}).done(function(data){
				jQuery("#myModal").html(data);
			});
		});
		$("#go_next_url").click(function(e){
			e.preventDefault();
			jQuery.ajax({
				type : "get",
				dataType : "json",
				url : jQuery("#go_next_url").attr("href")
			}).done(function(data){
				addContact(data);
				jQuery(\'#myModal\').modal(\'hide\');
			});
		});
	});';
	echo $this->Html->scriptBlock($code,array('block' => 'bottomScript'));
}
?>