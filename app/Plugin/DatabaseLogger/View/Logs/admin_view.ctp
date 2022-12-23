<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="pull-left"><?php echo __('Log');?></h4>
		<a href="<?php echo $this->request->referer(); ?>" class="btn btn-default pull-right"><span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Back</a>
		<div class="clearfix"></div>
	</div>
	<div class="panel-body">
		<ul class="list-group">
			<div class="col-lg-1 list-group-item"><?php echo __('CRUD Type'); ?></div>
			<div class="col-lg-11 list-group-item">
				<?php echo ucfirst($log['Log']['type']); ?>
				&nbsp;
			</div>
			<div class="col-lg-1 list-group-item"><?php echo __('Message'); ?></div>
			<div class="col-lg-11 list-group-item">
				<?php echo $log['Log']['message']; ?>
				&nbsp;
			</div>
			<div class="col-lg-1 list-group-item"><?php echo __('SQL Data'); ?></div>
			<div class="col-lg-11 list-group-item">
				<?php 
				if(!empty($log['Log']['data'])) {
					echo '<pre>'.print_r(unserialize($log['Log']['data']),true).'</pre>'; 
				}
				?>
				&nbsp;
			</div>
			<div class="col-lg-1 list-group-item"><?php echo __('Uri'); ?></div>
			<div class="col-lg-11 list-group-item">
				<?php echo $log['Log']['uri']; ?>
				&nbsp;
			</div>
			<div class="col-lg-1 list-group-item"><?php echo __('Referrer'); ?></div>
			<div class="col-lg-11 list-group-item">
				<?php echo $log['Log']['refer']; ?>
				&nbsp;
			</div>
			<div class="col-lg-1 list-group-item"><?php echo __('Hostname'); ?></div>
			<div class="col-lg-11 list-group-item">
				<?php echo $log['Log']['hostname']; ?>
				&nbsp;
			</div>
			<div class="col-lg-1 list-group-item"><?php echo __('IP'); ?></div>
			<div class="col-lg-11 list-group-item">
				<?php echo $log['Log']['ip']; ?>
				&nbsp;
			</div>
			<div class="col-lg-1 list-group-item"><?php echo __('Created'); ?></div>
			<div class="col-lg-11 list-group-item">
				<?php echo $log['Log']['created']; ?>
				&nbsp;
			</div>
		</ul>
	</div>
</div>