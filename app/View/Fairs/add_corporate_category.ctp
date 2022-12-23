<?php
echo $this->Html->css(array('redmond/jquery-ui-1.10.3.custom.min','nyroModal'),array('block'=>'css'));
echo $this->Html->script(array('jquery.validate.min','jquery-ui-1.10.3.custom.min','jquery.nyroModal.custom.min','fairs'), array('block' => 'script'));
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="pull-left"><?php echo empty($cID) ? 'Add' : 'Edit'; ?> Corporate Category</h4>
		<a class="pull-right btn btn-default btn-sm mt5" href="<?php echo $this->base ?>/Fairs/corporateCategories">
			<span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Go Back
		</a>
		<div class="clearfix"></div>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" id="addCorpCateg" role="form" method="post" action="<?php echo $this->base ?>/Fairs/addCorporateCategory?CID=<?php echo $cID; ?>" enctype="multipart/form-data">
			<div class="form-group">
				<label for="inputName" class="col-lg-2 control-label">Name:</label>
				<div class="col-lg-4">
					<input class="form-control input-sm" id="inputName" placeholder="Name" name="data[CorporateCategory][name]" value="<?php echo !empty($corporateCategory['CorporateCategory']['name']) ? $corporateCategory['CorporateCategory']['name'] : ''; ?>">
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-2 control-label">Description:</label>
				<div class="col-lg-4">
					<textarea class="form-control input-sm" rows="5" name="data[CorporateCategory][description]"><?php echo !empty($corporateCategory['CorporateCategory']['description']) ? $corporateCategory['CorporateCategory']['description'] : ''; ?></textarea>
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-lg-offset-5 col-lg-6">
					<button type="submit" class="btn btn-primary btn-sm">Save</button>
				</div>
			</div>
		</form>
	</div>
</div>
<?php

echo $this->Html->scriptStart(array('inline' => false,'block' => 'bottomScript'));

echo '$(document).ready(function(){
		validate_corp_cat_form();
	});';

echo $this->Html->scriptEnd();

?>