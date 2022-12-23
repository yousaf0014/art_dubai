<div class="panel panel-primary">
	<div class="panel-heading">
		<h4>Select Fields For</h4>
	</div>
	<div class="panel-body">
		<?php if(empty($model)) { ?>
		<p class="text-danger col-lg-offset-1">Please select fields to be viewed for</p>
		<div class="col-lg-2 col-lg-offset-1">
			<ul class="list-group">
				<li class="list-group-item">
					<a href="<?php echo $this->base ?>/utils/selectViewFields/Contact">Contact</a>
				</li>
				<li class="list-group-item">
					<a href="<?php echo $this->base ?>/utils/selectViewFields/Company">Company</a>
				</li>
			</ul>
		</div>
		<?php 
		}else{
		?>
		<p class="text-danger">Please select fields to be viewed</p>
		<form action="<?php echo $this->base ?>/utils/selectViewFields/<?php echo $model; ?>" method="post">
		<?php
			foreach ($columns as $key => $value) {
				if($key == 'id' || $key == 'uuid' || $key == 'photo' || $key == 'active' || $key == 'fair_category_id' || $key == 'corporate_category_id' || $key == 'fair_id') {
					continue;
				}
			?>
			<div class="col-lg-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" <?php echo isset($selected[$key]) ? 'checked="checked"' : ''; ?> value="<?php echo $key ?>" name="data[Fields][]">
						<?php echo ucwords(str_replace('_', ' ', $key)) ?>
					</label>
				</div>
			</div>
			<?php
			}
			?>
		<div class="clearfix"></div>
		<button type="submit" class="btn btn-primary btn-sm col-lg-offset-10">Save</button>
		</form>
		<?php
		} 
		?>
	</div>
</div>