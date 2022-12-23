<?php
echo $this->Html->script(array('jquery.validate.min','fairs'), array('block' => 'script'));
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="pull-left"><?php echo empty($contactCat) ? 'Add' : 'Edit'; ?> Contact Type</h4>
		<a class="pull-right btn btn-default" href="<?php echo $this->base ?>/Fairs/contactCategories">
			<span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Go Back
		</a>
		<div class="clearfix"></div>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" action="<?php echo $this->base ?>/Fairs/addContactCategory?CCID=<?php echo !empty($contactCat['ContactCategory']['uuid']) ? $contactCat['ContactCategory']['uuid'] : ''; ?>" role="form" method="post" id="addCatForm" enctype="multipart/form-data">
			<div class="form-group">
				<label class="col-lg-2 control-label">Name</label>
				<div class="col-lg-4">
					<input type="text" class="form-control input-sm" name="data[ContactCategory][name]" placeholder="Name" value="<?php echo !empty($contactCat['ContactCategory']['name']) ? $contactCat['ContactCategory']['name'] : ''; ?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label">Description</label>
				<div class="col-lg-4">
					<textarea class="form-control input-sm" rows="5" name="data[ContactCategory][description]"><?php echo !empty($contactCat['ContactCategory']['description']) ? $contactCat['ContactCategory']['description'] : ''; ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-offset-5 col-lg-7">
					<button type="submit" class="btn btn-primary btn-sm">Save</button>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		validate_contact_cat_form();
	});
</script>