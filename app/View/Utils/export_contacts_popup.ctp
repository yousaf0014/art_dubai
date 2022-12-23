 <div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="pull-left">Export Contacts</h4>
		<a href="javascript:;" onclick="hideModal()" class="glyphicon glyphicon-remove-circle pull-right text-primary f20"></a>
		<div class="clearfix"></div>
	</div>
	<div class="panel-body">
		<form method="post" action="<?php echo $this->base ?>/utils/exportContacts">
		<div class="col-lg-12">
			<p class="text-info">Select fields which you want to export</p>
			<?php foreach ($columns as $key => $value) {
				if($key == 'id' || $key == 'uuid' || $key == 'photo' || $key == 'active' || $key == 'fair_category_id'){
					continue;
				}
			?>
			<div class="col-lg-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" checked="checked" value="<?php echo $key ?>" name="data[Fields][]">
						<?php echo ucwords(str_replace('_', ' ', $key)) ?>
					</label>
				</div>
			</div>
			<?php
			}?>
		</div>
		<div class="clearfix"></div>
		<div class="col-lg-offset-9">
			<button class="btn btn-primary btn-sm" onclick="hideModal()">Export</button>
		</div>
		</form>
	</div>
</div>
<?php

$script = 'hideModal = function(){
	jQuery("#myModal").modal("hide");
}';

echo $this->Html->scriptBlock($script,array('block' => 'bottomScript'));

?>