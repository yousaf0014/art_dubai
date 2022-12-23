<?php
echo $this->Html->script(array('jquery.validate.min','fairs'), array('block' => 'script'));
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="pull-left"><?php echo empty($contactChar) ? 'Add' : 'Edit'; ?> Contact Characteristic</h4>
		<a class="pull-right btn btn-default btn-sm mt5" href="<?php echo $this->base ?>/Fairs/contactCharacteristics?CID=<?php echo $catID; ?>">
			<span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Go Back
		</a>
		<div class="clearfix"></div>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" action="<?php echo $this->base ?>/Fairs/addContactCharacteristic?CID=<?php echo $catID; ?>&CCID=<?php echo !empty($contactChar['ContactCharacteristic']['uuid']) ? $contactChar['ContactCharacteristic']['uuid'] : ''; ?>" role="form" method="post" id="addCatForm" enctype="multipart/form-data">
			<div class="form-group">
				<label class="col-lg-2 control-label">Name</label>
				<div class="col-lg-5">
					<input type="text" class="form-control input-sm" name="data[ContactCharacteristic][name]" placeholder="Name" value="<?php echo !empty($contactChar['ContactCharacteristic']['name']) ? $contactChar['ContactCharacteristic']['name'] : ''; ?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label">Select Category</label>
				<div class="col-lg-5">
					<select name="data[ContactCharacteristic][contact_category_id]" class="form-control input-sm">
						<?php 

						foreach ($contactCats as $key => $contactCat) { 
							$selected = '';
							if($contactChar['ContactCharacteristic']['contact_category_id'] == $contactCat['ContactCategory']['id']) {
								$selected = 'selected="selected"';
							}

						?>
						<option <?php echo $selected; ?> value="<?php echo $contactCat['ContactCategory']['id']?>"><?php echo $contactCat['ContactCategory']['name']; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label">Fair Category:</label>
				<?php

				echo $this->Form->input('ContactCharacteristic.fair_category_id',array(
					'type' => 'select',
					'options' => $fairs,
					'empty' => '--Select Fair--',
					'div' => 'col-lg-5',
					'label' => false,
					'class' => 'form-control input-sm',
					'value' => isset($contactChar['ContactCharacteristic']['fair_id']) ? $contactChar['ContactCharacteristic']['fair_id'] : ''
				));
				
				?>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label">Description</label>
				<div class="col-lg-5">
					<textarea class="form-control input-sm" rows="5" name="data[ContactCharacteristic][description]"><?php echo !empty($contactChar['ContactCharacteristic']['description']) ? $contactChar['ContactCharacteristic']['description'] : ''; ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-offset-6 col-lg-7">
					<button type="submit" class="btn btn-primary btn-sm">Save</button>
				</div>
			</div>
		</form>
	</div>
</div>
<?php

$code = '$(document).ready(function(){
		validate_contact_characteristics_form();
	});';
echo $this->Html->scriptBlock($code,array('inline' => 'false','block' => 'bottomScript'));

?>