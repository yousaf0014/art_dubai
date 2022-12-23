<?php
echo $this->Html->script(array('jquery.validate.min','fairs'), array('block' => 'script'));
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="pull-left"><?php echo empty($fairCat) ? 'Add' : 'Edit'; ?> Fair Category</h4>
		<a class="pull-right btn btn-default btn-sm mt5" href="<?php echo $this->base ?>/Fairs">
			<span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Go Back
		</a>
		<div class="clearfix"></div>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" action="<?php echo $this->base ?>/Fairs/addCategory?FCID=<?php echo !empty($fairCat['FairCategory']['uuid']) ? $fairCat['FairCategory']['uuid'] : ''; ?>" role="form" method="post" id="addCatForm" enctype="multipart/form-data">
			<div class="form-group">
				<label class="col-lg-2 control-label">Name:</label>
				<div class="col-lg-4">
					<input type="text" class="form-control input-sm" name="data[FairCategory][name]" placeholder="Name" value="<?php echo !empty($fairCat['FairCategory']['name']) ? $fairCat['FairCategory']['name'] : ''; ?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label">Description:</label>
				<div class="col-lg-4">
					<textarea class="form-control input-sm" rows="5" name="data[FairCategory][description]"><?php echo !empty($fairCat['FairCategory']['description']) ? $fairCat['FairCategory']['description'] : ''; ?></textarea>
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
<?php

$code = '$(document).ready(function(){
		validate_fair_cat_form();
	});';

echo $this->Html->scriptBlock($code,array('block' => 'bottomScript'));

?>