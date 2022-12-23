<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="pull-left"><?php echo empty($coID) ? 'Add' : 'Edit'; ?> Company</h4>
		<?php if($is_ajax) { ?>
		<a class="pull-right glyphicon glyphicon-remove-circle f20 mt5" href="javascript:;" onclick="hideModel('#myModal');"></a>
		<?php }else{ ?>
		<a class="pull-right btn btn-default btn-sm mt5" href="<?php echo $this->base ?>/Fairs/viewCompanies?CID=<?php echo $catID; ?>">
			<span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Go Back</a>
		<?php } ?>
		<a href="javascript:;" onclick="$('#addCompanyForm').submit();" class="btn btn-default pull-right btn-sm mt5 mr10">Save</a>	
		<div class="clearfix"></div>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" id="addCompanyForm" role="form" method="post" action="<?php echo $this->base ?>/Fairs/addCompany?CID=<?php echo $catID; ?>&COID=<?php echo $coID; ?>" enctype="multipart/form-data">
			<?php if(empty($catID)) { ?>
			<div class="form-group">
				<label for="inputName" class="col-lg-2 control-label">Select Category:</label>
				<div class="col-lg-3">
					
					<select name="data[Company][corporate_category_id]" class="form-control input-sm">
						<option value="">--Select Category--</option>
						<?php
						foreach ($corporateCategories as $key => $corporateCategory) {
							$selected = '';
							if( !empty($company) && $company['Company']['corporate_category_id'] == $corporateCategory['CorporateCategory']['id'] ){
								$selected = 'selected="selected"';
							}
						?>
						<option <?php echo $selected; ?> value="<?php echo $corporateCategory['CorporateCategory']['id']; ?>"><?php echo $corporateCategory['CorporateCategory']['name']?></option>
						<?php
						}
						?>
					</select>
				</div>
			</div>
			<?php } ?>
			<div class="form-group">
				<label for="inputName" class="col-lg-2 control-label">Name:</label>
				<div class="col-lg-3">
					<input class="form-control input-sm" id="inputName" placeholder="Name" name="data[Company][name]" value="<?php echo !empty($company['Company']['name']) ? $company['Company']['name'] : ''; ?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label">City:</label>
				<div class="col-lg-3">
					<input type="text" id="start_date" class="form-control input-sm" name="data[Company][city]" placeholder="City" value=<?php echo !empty($company['Company']['city']) ? $company['Company']['city'] : ''; ?>>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label">Country:</label>
				<div class="col-lg-3">
					<select class="form-control input-sm" name="data[Company][country]">
					<?php foreach($countries as $index => $country ) { ?>
						<option <?php echo !empty($company) && $country['Country']['iso'] == $company['Company']['country'] ? 'selected="selected"' : ''; ?> value="<?php echo $country['Country']['iso']; ?>"><?php echo $country['Country']['nicename']; ?></option>
					<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label">Address:</label>
				<div class="col-lg-3">
					<input class="form-control input-sm" type="text" name="data[Company][address]" placeholder="Address" value="<?php echo !empty($company['Company']['address']) ? $company['Company']['address'] : ''; ?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label">Phone:</label>
				<div class="col-lg-3">
					<input class="form-control input-sm" type="text" name="data[Company][phone]" value="<?php echo !empty($company['Company']['phone']) ? $company['Company']['phone'] : ''; ?>" placeholder="Phone">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label">Mobile:</label>
				<div class="col-lg-3">
					<input type="text" class="form-control input-sm" name="data[Company][mobile]" value="<?php echo !empty($company['Company']['mobile']) ? $company['Company']['mobile'] : ''; ?>" placeholder="Mobile">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label">Fax:</label>
				<div class="col-lg-3">
					<input type="text" class="form-control input-sm" name="data[Company][fax]" value="<?php echo !empty($company['Company']['fax']) ? $company['Company']['fax'] : ''; ?>" placeholder="Fax">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label">Email:</label>
				<div class="col-lg-3">
					<input type="text" class="form-control input-sm" name="data[Company][email]" value="<?php echo !empty($company['Company']['email']) ? $company['Company']['email'] : ''; ?>" placeholder="Email">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label">Website:</label>
				<div class="col-lg-3">
					<input type="text" class="form-control input-sm" name="data[Company][website]" value="<?php echo !empty($company['Company']['website']) ? $company['Company']['website'] : ''; ?>" placeholder="Website">
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-offset-4 col-lg-5">
					<button type="submit" class="btn btn-primary btn-sm">Save</button>
				</div>
			</div>
		</form>
	</div>
</div>
<?php

echo $this->Html->scriptStart(array('inline' => false,'block' => 'bottomScript'));

echo '$(document).ready(function(){
		validate_add_comany_form();';
		if($is_ajax == 1) {
			echo '$("#addCompanyForm").ajaxForm({
				success : function(responseText,status,xhr,elm) {
					if(typeof responseText.company == "object") {
						addContact(responseText);
						jQuery("#myModal").modal("hide");
					}else{
						$("#myModal").html(responseText);
					}
				}
			});';
		}
echo '});';

echo 'hideModel = function(selector) {
	jQuery(selector).modal("hide");
};';

echo $this->Html->scriptEnd();

?>