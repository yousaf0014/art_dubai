<div class="panel panel-primary">
	<div class="panel-heading">
		<h4>Inactive Contacts</h4>
	</div>
	<div class="panel-body">
		<form method="get" action="<?php echo $this->base ?>/utils/showInactiveContacts" class="form-horizontal form-search" id="search_contacts_form">
	  		<div class="col-lg-10">
  				<div class="form-group">
  					<div class="col-lg-4">
  					<?php
  					echo $this->Form->input('',array(
  							'type' => 'hidden',
  							'div' => false,
  							'label' => false,
  							'name' => 'view',
  							'value' => isset($request_data['view']) ? $request_data['view'] : ''
  						)
  					);
  					echo $this->Form->input('',array(
  						'type' => 'hidden',
  						'div' => false,
  						'label' => false,
  						'name' => 'limit',
  						'id' => 'records_per_page',
  						'value' => isset($request_data['limit']) ? $request_data['limit'] : '20'
  					));
  					echo $this->Html->tag('label','Fair Category',array('class' => 'col-lg-4 control-label'));
  					echo $this->Form->input('',array(
  								'class'=>'form-control',
  								'empty' => false,
  								'label' => false,
  								'div' => 'col-lg-8',
  								'type' => 'select',
  								'multiple' => 'multiple',
  								'options' => $fairCategories,
  								'name' => 'fair_category_id',
  								'id' => 'fair_category_id',
  								'value' => isset($request_data['fair_category_id']) ? $request_data['fair_category_id'] : ''
  							)
  						)
  					?>
  					</div>
  					<div class="col-lg-4">
  					<?php
  					echo $this->Html->tag('label','Select Fair:',array('class' => 'col-lg-4 control-label'));
  					echo $this->Form->input('',array(
  								'class'=>'form-control',
  								'empty' => false,
  								'label' => false,
  								'div' => 'col-lg-8',
  								'type' => 'select',
  								'multiple' => 'multiple',
  								'options' => $fairsByYear,
  								'name' => 'fair_id',
  								'id' => 'fair_id',
  								'value' => isset($request_data['fair_id']) ? $request_data['fair_id'] : ''
  							)
  						)
  					?>
  					</div>
  					<div class="col-lg-4">
	  				<?php
	  				echo $this->Html->tag('label','First Name',array('class' => 'col-lg-3 control-label'));
  					echo $this->Form->input('',array(
  								'class'=>'form-control input-sm',
  								'empty' => true,
  								'label' => false,
  								'div' => 'col-lg-8',
  								'type' => 'text',
  								'name' => 'first_name',
  								'value' => isset($request_data['first_name']) ? $request_data['first_name'] : ''
  							)
  						)
  					?>
  					</div>
	  			</div>
	  			<div class="form-group">
	  				<div class="col-lg-4">
	  				<?php
	  				echo $this->Html->tag('label','Last Name',array('class' => 'col-lg-4 control-label'));
  					echo $this->Form->input('',array(
  								'class'=>'form-control input-sm',
  								'empty' => true,
  								'label' => false,
  								'div' => 'col-lg-8',
  								'type' => 'text',
  								'name' => 'last_name',
  								'value' => isset($request_data['last_name']) ? $request_data['last_name'] : ''
  							)
  						)
  					?>
  					</div>
  					<div class="col-lg-4">
  						<?php 
	  					echo $this->Html->tag('label','Phone/Mobile:',array('class' => 'col-lg-4 control-label'));
	  					echo $this->Form->input('',array(
	  								'class'=>'form-control input-sm',
	  								'empty' => true,
	  								'label' => false,
	  								'div' => 'col-lg-8',
	  								'type' => 'text',
	  								'name' => 'mobile',
	  								'value' => isset($request_data['mobile']) ? $request_data['mobile'] : ''
	  							)
	  						)
	  					?>
  					</div>
  					<div class="col-lg-4">
	  					<?php
		  				echo $this->Html->tag('label','City',array('class' => 'col-lg-3 control-label'));
	  					echo $this->Form->input('',array(
	  								'class'=>'form-control input-sm',
	  								'empty' => true,
	  								'label' => false,
	  								'div' => 'col-lg-8',
	  								'type' => 'text',
	  								'name' => 'city',
	  								'value' => isset($request_data['city']) ? $request_data['city'] : ''
	  							)
	  						)
	  					?>
	  				</div>
	  			</div>
	  			<div class="form-group">
	  				<div class="col-lg-4">
	  					<?php
		  				echo $this->Html->tag('label','Country',array('class' => 'col-lg-4 control-label'));
		  				echo $this->Form->input('',array(
		  						'class' => 'form-control input-sm',
		  						'empty' => false,
		  						'label' => false,
		  						'div' => 'col-lg-8',
		  						'type' => 'select',
		  						'options' => $countries,
		  						'id' => 'countries',
		  						'multiple' => 'multiple',
		  						'name' => 'countries',
		  						'value' => isset($request_data['countries']) ? $request_data['countries'] : ''
		  					)
		  				);
		  				?>
	  				</div>
	  				<div class="col-lg-4">
	  					<?php
		  				echo $this->Html->tag('label','Email',array('class' => 'col-lg-4 control-label'));
	  					echo $this->Form->input('',array(
	  								'class'=>'form-control input-sm',
	  								'empty' => true,
	  								'label' => false,
	  								'div' => 'col-lg-8',
	  								'type' => 'text',
	  								'name' => 'email',
	  								'value' => isset($request_data['email']) ? $request_data['email'] : ''
	  							)
	  						)
	  					?>
	  				</div>
	  				<div class="col-lg-4">
	  					<?php
		  				echo $this->Html->tag('label','Bar Code',array('class' => 'col-lg-3 control-label'));
	  					echo $this->Form->input('',array(
	  								'class'=>'form-control input-sm',
	  								'empty' => true,
	  								'label' => false,
	  								'div' => 'col-lg-8',
	  								'type' => 'text',
	  								'name' => 'bar_code',
	  								'value' => isset($request_data['bar_code']) ? $request_data['bar_code'] : ''
	  							)
	  						)
	  					?>
	  				</div>
	  			</div>
	  			<div class="form-group">
	  				<div class="col-lg-4">
	  				<?php
	  				echo $this->Html->tag('label','Guest of',array('class' => 'col-lg-4 control-label'));
	  				echo $this->Form->input('',array(
	  						'class' => 'form-control input-sm',
	  						'label' => false,
	  						'div' => 'col-lg-8',
	  						'type' => 'text',
	  						'name' => 'guest_off',
	  						'hiddenField' => false,
	  						'value' => isset($request_data['guest_off']) ? $request_data['guest_off'] : ''
	  					)
	  				);
	  				?>
	  				</div>
	  				<div class="col-lg-4">
	  				<?php
	  				echo $this->Html->tag('label','Characteristics',array('class' => 'col-lg-4 control-label'));
	  				echo $this->Form->input('',array(
	  						'class' => 'form-control input-sm',
	  						'empty' => false,
	  						'label' => false,
	  						'div' => 'col-lg-8',
	  						'type' => 'select',
	  						'options' => $contactChars,
	  						'id' => 'contactCharacteristics',
	  						'multiple' => 'multiple',
	  						'name' => 'characteristics',
	  						'hiddenField' => false,
	  						'value' => isset($request_data['characteristics']) ? $request_data['characteristics'] : ''
	  					)
	  				);
	  				?>
	  				</div>
	  				<div class="col-lg-4">
	  				<?php
	  				echo $this->Html->tag('label','Registered',array('class' => 'col-lg-3 control-label'));
	  				echo $this->Form->input('',array(
	  						'class' => 'form-control input-sm',
	  						'label' => false,
	  						'div' => 'col-lg-8',
	  						'type' => 'select',
	  						'multiple' => 'multiple',
	  						'options' => array('on_site' => 'On Site','import' => 'Imported', 'manual' => 'Manual'),
	  						'name' => 'registration_method',
	  						'hiddenField' => false,
	  						'id' => 'registration_method_selct',
	  						'empty' => false,
	  						'value' => isset($request_data['registration_method']) ? $request_data['registration_method'] : ''
	  					)
	  				);
	  				?>
	  				</div>
  				</div>
  				<div class="form-group">
  					<div class="col-lg-4">
	  				<?php
	  				echo $this->Html->tag('label','General Keyword',array('class' => 'col-lg-4 control-label'));
	  				echo $this->Form->input('',array(
	  						'class' => 'form-control input-sm',
	  						'label' => false,
	  						'div' => 'col-lg-8',
	  						'type' => 'text',
	  						'name' => 'general_keyword',
	  						'hiddenField' => false,
	  						'value' => isset($request_data['guest_off']) ? $request_data['guest_off'] : ''
	  					)
	  				);
	  				?>
	  				</div>
  					<div class="col-lg-4 col-lg-offset-4">
	  					<div class="col-lg-4">&nbsp;</div>
	  					<div class="checkbox-inline col-lg-2">
	  						<label>
	  						<?php 
	  						echo $this->Form->input('',array(
	  							'type' => 'checkbox',
	  							'value' => '1',
	  							'div' => false,
	  							'hiddenField' => false,
	  							'label' => false,
	  							'name' => 'shared',
	  							'checked' => !empty($request_data['shared']) ? true : false
	  						));
	  						echo 'Shared';
	  						?>
	  						</label>
		  				</div>
		  				<div class="col-lg-6">
		  					<?php
		  					echo $this->Html->link('Clear','/utils/showInactiveContacts',array(
		  							'class' => 'btn btn-link clear_search'
		  						)
		  					);
		  					?>
		  					<button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-search"></span>&nbsp;Search</button>
		  				</div>
	  				</div>
  				</div>
	  		</div>
	  	</form>
	  	<div class="clearfix"></div>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<th width="4%">No</th>
					<th width="10%">First Name</th>
					<th width="10%">Last Name</th>
					<th width="14%">Address</th>
					<th width="10%">City</th>
					<th width="10%">Mobile</th>
					<th width="8%">Phone</th>
					<th width="10%">Email</th>
					<th width="5%" class="text-center">Actions</th>
				</thead>
				<tbody>
					<?php
					$page = $this->Paginator->param('page');
					$limit = $this->Paginator->param('limit');
					$pages = $this->Paginator->param('pageCount');
					if(!empty($contacts)) {
						$counter = ($page - 1) * $limit;
						foreach($contacts as $contact) {
					?>
					<tr>
						<td><?php echo ++$counter; ?></td>
						<td><?php echo ucwords($contact['Contact']['first_name']); ?></td>
						<td><?php echo ucwords($contact['Contact']['last_name']); ?></td>
						<td><?php echo $contact['Contact']['address']; ?></td>
						<td><?php echo $contact['Contact']['city']; ?></td>
						<td><?php echo $contact['Contact']['mobile']; ?></td>
						<td><?php echo $contact['Contact']['phone']; ?></td>
						<td><?php echo $contact['Contact']['email']; ?></td>
						<td class="text-center">
							<a onclick="return confirm('Are you sure?');" href="<?php echo $this->base ?>/utils/makeContactActive/<?php echo $contact['Contact']['uuid']; ?>" class="glyphicon glyphicon-ok text-danger fs14" title="Make contact active"></a>
						</td>
					</tr>
					<?php 
						}
					}else{
					?>
					<tr>
						<td colspan="9">No Recod found.</td>
					</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php

$this->Html->script(array('bootstrap-multiselect'),array('block' => 'bottomScript'));

$this->Html->css(array('bootstrap-multiselect'),array('block' => 'css'));

$script = '$(document).ready(function() {
	$("body").on("hidden.bs.modal", ".modal", function () {
    	$(this).removeData("bs.modal");
    });
	$("#fair_category_id").multiselect({
		buttonClass: "btn btn-default btn-sm",
		buttonWidth : "100%",
		maxHeight : 200,
		buttonContainer : "<div class=\'btn-group w100p\'>",
		buttonText : function(options, select){
						if(options.length == 0) {
							return "<span class=\'text-muted\'>Select Category</span>"
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
	
	$("#fair_id").multiselect({
		buttonClass: "btn btn-default btn-sm",
		buttonWidth : "100%",
		maxHeight : 200,
		buttonContainer : "<div class=\'btn-group w100p\'>",
		buttonText : function(options, select){
						if(options.length == 0){
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
	$("#contactCharacteristics").multiselect({
		buttonClass : "btn btn-default btn-sm",
		buttonWidth : "100%",
		buttonContainer : "<div class=\'btn-group w100p\'>",
		maxHeight : 200,
		buttonText : function(options, select){
						if(options.length == 0) {
							return "<span class=\'text-muted\'>Select characteristics</span>"
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
	
	$("#countries").multiselect({
		buttonClass : "btn btn-default btn-sm",
		buttonWidth : "100%",
		buttonContainer : "<div class=\'btn-group w100p\'>",
		maxHeight : 200,
		buttonText : function(options, select){
						if(options.length == 0) {
							return "<span class=\'text-muted\'>Select country</span>"
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
	
	$("#registration_method_selct").multiselect({
		buttonClass : "btn btn-default btn-sm",
		buttonWidth : "100%",
		buttonContainer : "<div class=\'btn-group w100p\'>",
		maxHeight : 200,
		buttonText : function(options, select){
						if(options.length == 0) {
							return "<span class=\'text-muted\'>Select Method</span>"
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

$this->Html->scriptBlock($script,array('block' => 'bottomScript'));

?>