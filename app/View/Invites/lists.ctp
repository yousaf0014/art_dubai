<?php
$request = $this->request->query;
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<?php
		echo $this->Html->tag('h4','Invite Lists',array('class' => 'pull-left'));
		?>

		<a class="pull-right btn btn-default btn-sm mt5" href="<?php echo $this->base ?>/invites/addList?CATID=<?php echo $cat_uuid ?>">
			<span class="glyphicon glyphicon-plus-sign"></span>&nbsp;Add
		</a>
		<?php
		echo $this->Html->tag('div','',array('class' => 'clearfix'));
		?>
	</div>
	<div class="panel-body">
		<div>
			<?php
			echo $this->Form->create('InviteList',array(
					'class' => 'form-horizontal form-search',
					'type' => 'get',
					'id' => 'list_search_form'
				)
			);
			?>
			<div class="col-lg-7">
				<div class="form-group">
					<div class="col-lg-6">
					<?php
					echo $this->Html->tag('label','Fair Category',array(
						'class' => 'control-label col-lg-4'
					));
					echo $this->Form->input(null,array(
						'name' => 'fair_category_id',
						'id' => 'fair_category_id',
						'label' => false,
						'div' => 'col-lg-8',
						'class' => 'form-control input-sm',
						'type' => 'select',
						'multiple' => 'multiple',
						'options' => $fair_cats,
						'value' => isset($request['fair_category_id']) ? $request['fair_category_id'] : ''
					));
					?>
					</div>
					<div class="col-lg-6">
						<?php
						echo $this->Html->tag('label','Fair:',array(
							'class' => 'col-lg-4 control-label'
						));
						echo $this->Form->input(null,array(
							'name' => 'fair_id',
							'id' => 'fair_id',
							'label' => false,
							'div' => 'col-lg-8',
							'class' => 'form-control input-sm',
							'type' => 'select',
							'multiple' => 'multiple',
							'options' => $fairs,
							'value' => isset($request['fair_id']) ? $request['fair_id'] : ''
						));
						?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-6">
						<?php
						echo $this->Html->tag('label','Name:',array(
							'class' => 'control-label col-lg-4'
						));
						echo $this->Form->input(null,array(
							'name' => 'name',
							'label' => false,
							'div' => 'col-lg-8',
							'class' => 'form-control input-sm',
							'type' => 'text',
							'value' => isset($request['name']) ? $request['name'] : ''
						));
						?>
					</div>
					<div class="col-lg-6">
						<div class="col-lg-offset-8">
							<?php
							echo $this->Html->link('Clear','/invites/lists',array(
									'class' => 'btn btn-link',
									'id' => 'clear_form'
								)
							);
							echo $this->Form->button('Search',array(
									'class' => 'btn btn-success btn-sm'
								)
							);
							?>
						</div>
					</div>
				</div>
			</div>
			<?php
			echo $this->Form->end();
			?>
		</div>
		<div class="clearfix"></div>
		<hr>
		<div class="table-responsive" id="list_container">
			<div>
				<div class="pull-right">
  					<label>
	  				<?php
			  		echo $this->Paginator->counter(
			  			'Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}'
			  		);
			  		?>
		  			</label>
		  		</div>
  				<div class="clearfix"></div>
  			</div>
			<table class="table table-striped table-hover">
				<thead>
					<th width="5%">#</th>
					<th>Name</th>
					<th width="12%">Invite Type</th>
					<th width="15%">Fair</th>
					<th width="7%" class="text-center">Created Date</th>
					<th width="12%">Created By</th>
					<th width="10%" class="text-center">Actions</th>
				</thead>
				<tbody>
					<?php
					$page = $this->Paginator->param('page');
					$limit = $this->Paginator->param('limit');
					$pages = $this->Paginator->param('pageCount');
					if(!empty($lists)) {
						$counter = ($page - 1) * $limit;
						foreach($lists as $list) {
							$uuid = $list['InviteList']['uuid'];
					?>
					<tr>
						<td><?php echo ++$counter; ?></td>
						<td><strong><?php echo $list['InviteList']['name']; ?></strong>&nbsp;<?php echo '('.$list['contactsCount'].')'; ?></td>
						<td><?php echo $list['InviteCategory']['name']; ?></td>
						<td><?php echo $list['Fair']['name']; ?></td>
						<td class="text-center"><?php echo YMD2MDY($list['InviteList']['created'],'/'); ?></td>
						<td><?php echo $list['User']['first_name'].' '.$list['User']['last_name']; ?></td>
						<td class="text-center">
						<?php
						echo $this->Html->link('Contacts','/invites/index?list_id='.$uuid,array('class' => 'mr5'));
						echo $this->Html->link('', '/invites/printInviteList?list_id='.$uuid,array(
							'class' => 'glyphicon glyphicon-print mr5',
							'data-toggle' => 'modal',
							'data-keyboard' => 'false',
							'data-backdrop' => 'static',
							'data-target' => '#myModal',
						));
						echo $this->Html->link('','/invites/editList?ID='.$uuid,array('class' => 'glyphicon glyphicon-pencil'));
						echo $this->Html->link('','/invites/deleteList?ID='.$uuid,array('class' => 'glyphicon glyphicon-remove ml10','onclick' => 'return confirm(\'Are you sure?\')'));
						?>
						</td>
					</tr>
					<?php 
						}
					}else{
					?>
					<tr>
						<td colspan="6">No record found.</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<?php
		if($pages > 1){
			echo $this->element('pagination_links');
		}
		?>
	</div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

<?php

echo $this->Html->css(array('bootstrap-multiselect'),array('bottomScript'));
echo $this->Html->script(array('bootstrap-multiselect'),array('bottomScript'));

$script = 'jQuery(document).on("submit","#list_search_form",function(event){
	event.preventDefault();
	search_list();
});
jQuery(document).on("click","#clear_form",function(event){
	event.preventDefault();
	clear_search();
});
';

$script .= 'search_list = function(){
	jQuery.ajax({
		url : basePath + "/invites/lists?"+jQuery("#list_search_form").serialize()
	}).done(function(data){
		jQuery("#list_container").html(jQuery(data).find("#list_container").html());
	});
};
clear_search = function(){
	jQuery.ajax({
		url : basePath + "/invites/lists"
	}).done(function(data){
		jQuery("#list_container").html(jQuery(data).find("#list_container").html());
		jQuery("#list_search_form")[0].reset();
		multiselect_deselectAll(jQuery("#fair_category_id"));
		multiselect_deselectAll(jQuery("#fair_id"));
	});
};
function multiselect_deselectAll($el) {
		$("option", $el).each(function(element) {
		$el.multiselect("deselect", $(this).val());
	});
};
';

$script .= 'jQuery(document).ready(function(){
	jQuery("#fair_category_id").multiselect({
		buttonClass : "btn btn-default btn-sm",
		buttonWidth : "100%",
		buttonContainer : "<div class=\'btn-group w100p\'>",
		maxHeight : 200,
		buttonText : function(options, select){
			if(options.length == 0) {
				return "<span class=\'text-muted\'>Select Fair Category</span>"
			}
			else if (options.length > 3) {
				return options.length + \' selected  <b class="caret"></b>\';
			}
			else {
				var selected = \'\';
				options.each(function() {
					selected += $(this).text() + \', \';
					});
					return selected.substr(0, selected.length -2) + \' <b class="caret"></b>\';
			}
		}
	});

	jQuery("#fair_id").multiselect({
		buttonClass : "btn btn-default btn-sm",
		buttonWidth : "100%",
		buttonContainer : "<div class=\'btn-group w100p\'>",
		maxHeight : 200,
		buttonText : function(options, select){
			if(options.length == 0) {
				return "<span class=\'text-muted\'>Select Fair</span>"
			}
			else if (options.length > 3) {
				return options.length + \' selected  <b class="caret"></b>\';
			}
			else {
				var selected = \'\';
				options.each(function() {
					selected += $(this).text() + \', \';
					});
					return selected.substr(0, selected.length -2) + \' <b class="caret"></b>\';
			}
		}
	});

});';

echo $this->Html->scriptBlock($script,array('block' => 'bottomScript'));

?>