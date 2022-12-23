<div class="panel panel-primary">
	<div class="panel-heading">
		<h4>Select Fair</h4>
	</div>
	<div class="panel-body">
		<form method="post" action="<?php echo $this->base ?>/Fairs/importContacts?FCID=<?php echo $fcuuid; ?>&FID=<?php echo $fid; ?>">
			<div class="col-lg-offset-2 col-lg-6">
				<strong class="col-lg-6">Name</strong>
				<strong class="col-lg-6">Year</strong>
				<div class="clearfix"></div>
				<?php foreach ($fairs as $index => $fair) {
				?>
				<div class="checkbox">
					<label class="col-lg-6">
						<input type="checkbox" name="data[Fair][]" value="<?php echo $fair['Fair']['id']; ?>" /> <?php echo $fair['Fair']['name'] ?>
					</label>
					<span class="col-lg-6"><?php echo $fair['Fair']['year']; ?></span>
				</div>
				<?php
				}?>
				<div class="col-lg-offset-6">
					<button class="btn btn-primary">Import</button>
				</div>
			</div>
		</form>
	</div>
</div>