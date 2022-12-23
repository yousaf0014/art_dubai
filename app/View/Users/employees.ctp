<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="pull-left">Employees</h4>
		<a class="pull-right btn btn-default btn-sm mt5 mr10" href="<?php echo $this->base ?>/users/addEmployee"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp;Add</a>
		<div class="clearfix"></div>
	</div>
  	<div class="panel-body">
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th width="4%">No</th>
					<th>Name</th>
					<th width="15%">Mobile</th>
					<th width="15%">Email</th>
					<th width="5%">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$page = $this->Paginator->param('page');
				$limit = $this->Paginator->param('limit');
				$pages = $this->Paginator->param('pages');
				if(!empty($employees)) {
					$counter = ($page - 1) * $limit;
					foreach ($employees as $index => $e) {
						$e_uuid = $e['User']['uuid'];
					echo $this->Html->tableCells(array(
					    array(
					    		++$counter, 
					    		ucwords($e['User']['first_name'].' '.$e['User']['last_name']),
					    		$e['User']['mobile_phone'],
					    		$e['User']['email'],
					    		$this->Html->link('', '/users/addEmployee?UID='.$e_uuid, array(
					    				'title' => 'Edit',
					    				'class' => 'glyphicon glyphicon-pencil mr10'
					    			)
					    		).$this->Html->link('', '/users/deleteEmployee?UID='.$e_uuid, array(
					    				'title' => 'Delete',
					    				'class' => 'glyphicon glyphicon-remove',
					    				'onclick' => "return confirm('Are you sure?')"
					    			)
					    		)
					    	),
					));
					}
				}else{
				?>
				<tr>
					<td colspan="6">No record found.</td>
				</tr>
				<?php
				}
				?>
			</tbody>
		</table>
		<?php if($pages > 1) { ?>
		<div class="col-lg-6">
			<ul class="pagination">
				<?php echo $this->Paginator->numbers(array('tag' => 'li','separator' => '','currentClass' => 'active','currentTag' => 'a' )); ?>
			</ul>
		</div>
		<?php } ?>
	</div>
</div>