<?php //echo $this->Html->css('/database_logger/css/style'); ?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h4><?php echo __('Logs');?></h4>
	</div>
	<div class="panel-body">
		<div>
			<?php 
			//echo $this->element('admin_filter', array('plugin' => 'database_logger', 'model' => 'Log')); 
			//echo $this->Html->tag('div','',array('class' => 'clearfix'));
			?>
			<div class="logs index">
				<table cellpadding="0" cellspacing="0" class="table table-hover table-striped">
				<tr>
					<th width="4%">#</th>
					<th width="10%"><?php echo $this->Paginator->sort('created');?></th>
					<th width="12%"><?php echo $this->Paginator->sort('created_by'); ?></th>
					<th width="2%"><?php echo $this->Paginator->sort('type');?></th>
					<th width="2%"><?php echo $this->Paginator->sort('message');?></th>
					<th width="15%"><?php echo $this->Paginator->sort('model'); ?></th>
					<th><?php echo __('Caption'); ?></th>
					<th width="7%" class="text-center"><?php echo __('Actions');?></th>
				</tr>
				<?php
				$page = $this->Paginator->param('page');
				$limit = $this->Paginator->param('limit');
				$pages = $this->Paginator->param('pageCount');
				$i = 0;
				$counter = ($page - 1) * $limit;
				foreach ($logs as $log):
					$class = null;
					if ($i++ % 2 == 0) {
						$class = ' class="altrow"';
					}
				?>
				<tr<?php echo $class;?>>
					<td><?php echo ++$counter; ?></td>
					<td><?php echo $this->Time->niceShort($log['Log']['created']); ?>&nbsp;</td>
					<td><?php echo ucwords($log['User']['first_name'].' '.$log['User']['last_name']); ?></td>
					<td><?php echo ucfirst($log['Log']['type']); ?>&nbsp;</td>
					<td><?php echo ucfirst($log['Log']['message']); ?>&nbsp;</td>
					<td><?php echo $log['Log']['model']; ?></td>
					<td>
					<?php
					if(!empty($log['Log']['model']) && !empty($log['Log']['foreign_key']) && !empty($log['Log']['type'])) {
						echo 'The recod for model <strong>'.$log['Log']['model'].'</strong> having primary key <strong>'.$log['Log']['foreign_key'].'</strong> '.$log['Log']['type'].'d';
					}else{
						echo '&nbsp;';
					}
					?>
					</td>
					<td class="text-center">
						<?php echo $this->Html->link(__('View Details'), array('action' => 'view', $log['Log']['id'])); ?>
						<?php //echo $this->Html->link(__('Delete'), array('action' => 'delete', $log['Log']['id']), null, sprintf(__('Are you sure you want to delete this log # %s?'), $log['Log']['id'])); ?>
					</td>
				</tr>
			<?php endforeach; ?>
				</table>
				<?php echo $this->element('pagination_links'); ?>
			</div>
		</div>
	</div>
</div>