<?php
$this->passedArgs['controller'] = 'fairs';
$this->passedArgs['action'] = 'contacts';
$full_view = $normal_viw = $this->passedArgs;
$full_view['view'] = 'all';
$normal_viw['view'] = 'normal';
$query_string = http_build_query($request_data);
echo $this->Html->script(
	array(
		'bootstrap-multiselect',
		'file_upload/jquery.iframe-transport',
		'file_upload/vendor/jquery.ui.widget',
		'file_upload/jquery.fileupload'
	),
	array(
		'block' => 'bottomScript'
	)
);
echo $this->Html->css(array(
		'bootstrap-multiselect',
		'file_upload/jquery.fileupload',
		'font-awesome/css/font-awesome.min'
	),
	array(
		'block' => 'css'
	)
);
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="pull-left">Contacts List</h4>
		<div class="pull-right" id="btn_container">
			<?php
			//create invite list link
			$create_invite_link = '/invites/createList?'.$query_string;
			
			echo $this->Html->link(
				'Create invite list',
				$create_invite_link,
				array(
					'class' => 'btn btn-success btn-sm ml2',
					'data-toggle' => 'modal',
					'data-keyboard' => 'false',
					'data-backdrop' => 'static',
					'data-target' => '#myModal',
				)
			);
			?>
			<span class="btn btn-warning btn-sm fileinput-button ml2">
  				<i class="glyphicon glyphicon-import"></i>
  				<span>Import</span>
  				<input type="file" name="data[import]" id="import_file">
            </span>
            <a href="<?php echo $this->base ?>/files/downloads/import_sample.xls" class="btn btn-info btn-sm ml2"><span class="glyphicon glyphicon-download-alt"></span>&nbsp;Import Sample</a>
            <a class="btn btn-warning btn-sm ml2" data-toggle="modal" data-keyboard="false" data-backdrop="static" data-target="#myModal" href="<?php echo $this->base ?>/utils/exportContactsPopup?<?php echo $query_string; ?>"><span class="glyphicon glyphicon-export"></span>&nbsp;Export</a>
			<a class="btn btn-default btn-sm ml2 ajax_contents" href="<?php echo $this->base ?>/Fairs/addContact?FROM=main"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp;Add</a>
			<a href="javascript:;" onclick="printContacts();" class="btn btn-link"><span class="glyphicon glyphicon-print"></span>&nbsp;Print</a>
		</div>
		<div class="clearfix"></div>
	</div>
  	<div class="panel-body">
	  	<form method="get" action="<?php echo $this->base ?>/fairs/contacts" class="form-horizontal form-search" id="search_contacts_form">
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
		  				echo $this->Html->tag('label','Flag',array('class' => 'col-lg-4 control-label'));
		  				?>
		  				<div class="col-lg-8">
			  				<select name="flag[]" class="form-control input-sm" "value"="<?php echo isset($request_data['flag']) ? $request_data['flag'] : ''; ?>" id="flag" multiple="multiple">
			  					<?php
			  					foreach ($flags as $flag) {
			  					?>
			  					<option value="<?php echo $flag['Flag']['id']; ?>"><span style="color:#<?php echo $flag['Flag']['color']; ?>"><?php echo $flag['Flag']['title']; ?></span></option>
			  					<?php
			  					}
			  					?>
			  				</select>
			  			</div>
		  			</div>
	  				<div class="col-lg-4">
	  				<?php
	  				echo $this->Html->tag('label','Company',array('class' => 'col-lg-4 control-label'));
	  				echo $this->Form->input('',array(
	  						'class' => 'form-control input-sm',
	  						'label' => false,
	  						'div' => 'col-lg-8',
	  						'type' => 'select',
	  						'multiple' => 'multiple',
	  						'options' => $companies,
	  						'name' => 'company',
	  						'hiddenField' => false,
	  						'id' => 'companies',
	  						'empty' => false,
	  						'value' => isset($request_data['company']) ? $request_data['company'] : ''
	  					)
	  				);
	  				?>
	  				</div>
	  				<div class="col-lg-4">
	  				<?php
	  				echo $this->Html->tag('label','General Keyword',array('class' => 'col-lg-3 control-label'));
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
	  			</div>
	  			<div class="form-group">
  					<div class="col-lg-4 col-lg-offset-8">
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
		  					echo $this->Html->link('Clear','/fairs/contacts',array(
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
  		<div class="col-lg-2" id="records_limit">
			<div>
				<?php
				//Normal View Link
				echo $this->Html->link(
					'Normal View',
					$normal_viw,
					array('class' => 'btn btn-link')
				);

				//Full view Link
				echo $this->Html->link(
					'Full View',
					$full_view,
					array( 'class' => 'btn btn-link')
				);

  				echo $this->Form->input('',array(
  					'type' => 'select',
  					'options' => array('20' => '20', '40' => '40', '60' => '60' ,'80' => '80', '100' => '100', '200' => '200', '500' => '500'),
  					'div' => 'col-lg-9 mt10',
  					'label' => 'Show records',
  					'class' => 'form-control input-sm',
  					'onchange' => 'getContacts(this)',
  					'id' => 'records_limit_selct',
  					'value' => isset($request_data['limit']) ? $request_data['limit'] : 20
  				));

				?>
			</div>
		</div>
  		<div class="clearfix"></div>
  		<hr/>
  		<div id="contacts_container">
	  		<div class="table-responsive">
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
				<table class="table table-hover table-striped table-condensed">
					<thead>
						<tr>
							<th width="4%">No</th>
							<th width="10%">Characteristics</th>
							<th width="10%">Invite List</th>
							<?php
							
							$sortKey = $this->Paginator->sortKey('Contact');
							$sortDir = $this->Paginator->sortDir('Contact');
							
							if(!empty($viewFields)) {
								foreach($viewFields as $viewField) {
							?>
							<th>
								<?php 
								
								echo $this->Paginator->sort('Contact.'.$viewField,ucfirst(str_replace('_', ' ', $viewField)),array('class' => 'ajax_sort')); 
								
								if($sortKey == 'Contact.'.$viewField) {
									if($sortDir == 'desc'){
										echo '<i class="fa fa-caret-square-o-down ml5"></i>';
									}elseif($sortDir == 'asc'){
										echo '<i class="fa fa-caret-square-o-up ml5"></i>';
									}
								}
								?>

							</th>
							<?php
								}
							}else{
							?>
							<th width="7%">
								<?php 
								echo $this->Paginator->sort('Contact.first_name','First Name',array('class' => 'ajax_sort'));

								if($sortKey == 'Contact.first_name') {
									if($sortDir == 'desc'){
										echo '<i class="fa fa-caret-square-o-down ml5"></i>';
									}elseif($sortDir == 'asc'){
										echo '<i class="fa fa-caret-square-o-up ml5"></i>';
									}
								}
								
								?>
							</th>
							<th width="7%">
								<?php 

								echo $this->Paginator->sort('Contact.las_name','Last Name',array('class' => 'ajax_sort')); 
								
								if($sortKey == 'Contact.las_name') {
									if($sortDir == 'desc'){
										echo '<i class="fa fa-caret-square-o-down ml5"></i>';
									}elseif($sortDir == 'asc'){
										echo '<i class="fa fa-caret-square-o-up ml5"></i>';
									}
								}

								?>
							</th>
							<th width="14%">
								<?php 
								echo $this->Paginator->sort('Contact.address','Address',array('class' => 'ajax_sort'));

								if($sortKey == 'Contact.address') {
									if($sortDir == 'desc'){
										echo '<i class="fa fa-caret-square-o-down ml5"></i>';
									}elseif($sortDir == 'asc'){
										echo '<i class="fa fa-caret-square-o-up ml5"></i>';
									}
								}

								?>
							</th>
							<th width="6%">
								<?php 
								echo $this->Paginator->sort('Contact.city','City',array('class' => 'ajax_sort'));

								if($sortKey == 'Contact.city') {
									if($sortDir == 'desc'){
										echo '<i class="fa fa-caret-square-o-down ml5"></i>';
									}elseif($sortDir == 'asc'){
										echo '<i class="fa fa-caret-square-o-up ml5"></i>';
									}
								}

								?>
							</th>
							<th width="10%">
								<?php 
								
								echo $this->Paginator->sort('Country.nicename','Country',array('class' => 'ajax_sort'));

								if($sortKey == 'Contact.nicename') {
									if($sortDir == 'desc'){
										echo '<i class="fa fa-caret-square-o-down ml5"></i>';
									}elseif($sortDir == 'asc'){
										echo '<i class="fa fa-caret-square-o-up ml5"></i>';
									}
								}
								
								?>
							</th>
							<th width="6%">
								<?php 
								echo $this->Paginator->sort('Contact.mobile','Mobile',array('class' => 'ajax_sort'));
								
								if($sortKey == 'Contact.mobile') {
									if($sortDir == 'desc'){
										echo '<i class="fa fa-caret-square-o-down ml5"></i>';
									}elseif($sortDir == 'asc'){
										echo '<i class="fa fa-caret-square-o-up ml5"></i>';
									}
								}

								?>
							</th>
							<th width="6%">
								<?php 
								echo $this->Paginator->sort('Contact.phone','Phone',array('class' => 'ajax_sort'));

								if($sortKey == 'Contact.phone') {
									if($sortDir == 'desc'){
										echo '<i class="fa fa-caret-square-o-down ml5"></i>';
									}elseif($sortDir == 'asc'){
										echo '<i class="fa fa-caret-square-o-up ml5"></i>';
									}
								}

								?>
							</th>
							<th width="8%">
								<?php 
								echo $this->Paginator->sort('Contact.email','Email',array('class' => 'ajax_sort')); 

								if($sortKey == 'Contact.email') {
									if($sortDir == 'desc'){
										echo '<i class="fa fa-caret-square-o-down ml5"></i>';
									}elseif($sortDir == 'asc'){
										echo '<i class="fa fa-caret-square-o-up ml5"></i>';
									}
								}

								?>
							</th>
							<?php } ?>
							<th width="10%">Fair</th>
							<?php
							if(!empty($request_data['view']) && $request_data['view'] == 'all') {
								if(!empty($field_diff)) {
									foreach ($field_diff as $key => $value) {
										if($key =='id' || $key == 'uuid' || $key == 'fair_id' || $key == 'fair_category_id' || $key == 'active' || $key == 'photo'){
											continue;
										}
							?>
							<td>
								<?php 
								echo $this->Paginator->sort('Contact.'.$key,ucfirst(str_replace('_', ' ', $key)),array('class' => 'ajax_sort'));

								if($sortKey == 'Contact.'.$key) {
									if($sortDir == 'desc'){
										echo '<i class="fa fa-caret-square-o-down ml5"></i>';
									}elseif($sortDir == 'asc'){
										echo '<i class="fa fa-caret-square-o-up ml5"></i>';
									}
								}

								?>
							</td>
							<?php
									}

							?>
							<?php
								}else{
							?>
							<th>Webiste</th>
							<th><?php echo $this->Paginator->sort('Contact.source','Source')?></th>
							<th><?php echo $this->Paginator->sort('Contact.guest_off','Guest off')?></th>
							<th><?php echo $this->Paginator->sort('Contact.bar_code','Bar Code')?></th>
							<th>Facebook</th>
							<th>Twitter</th>
							<th>Linkedin</th>
							<th>Instagram</th>
							<th><?php echo $this->Paginator->sort('Contact.shared','Shared',array('class' => 'ajax_sort')); ?></th>
							<?php 
								}
							} 
							?>
							<th width="13%" class="text-center">Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$page = $this->Paginator->param('page');
						$limit = $this->Paginator->param('limit');
						$pages = $this->Paginator->param('pageCount');
						if( !empty( $contacts) ) {
							$counter = ($page - 1) * $limit;
							foreach ($contacts as $index => $contact) {
						?>
						<tr>
							<td><?php echo ++$counter; ?></td>
							<td>
							<?php
							if(!empty($contact['ContactCharacteristic'])) {
								$characteristics = Set::extract('/name',$contact['ContactCharacteristic']);
								echo implode(', ', $characteristics);
							}else{
								echo 'None';
							}
							?>
							</td>
							<td>
							<?php
							if(!empty($contact['InviteList'])) {
								foreach ($contact['InviteList'] as $key => $value) {
									echo '<a href="'.$this->base.'/invites?list_id='.$value['uuid'].'">'.$value['name'].',</a> ';
								}
							}else{
								echo 'None';
							}
							?>
							</td>
							<?php
							if(!empty($viewFields)) {
								foreach($viewFields as $field){
							?>
							<td>
							<?php
							if($field == 'shared') {
								echo $contact['Contact'][$field] == '1' ? 'Yes' : 'No';	
							}
							elseif ($field == 'created' || $field == 'updated') {
								echo $this->Time->format('F jS, Y',$contact['Contact'][$field]);
							}
							elseif ($field == 'created_by') {
								echo $contact['CreatedBy']['first_name'].' '. $contact['CreatedBy']['last_name'];
							}
							elseif($field == 'updated_by') {
								echo $contact['UpdatedBy']['first_name'].' '. $contact['UpdatedBy']['last_name'];
							}
							else {
								echo ucfirst($contact['Contact'][$field]); 
							}
							?>
							</td>
							<?php
								}
							}else{
							?>
							<td><?php echo ucwords($contact['Contact']['first_name']); ?></td>
							<td><?php echo ucwords($contact['Contact']['last_name']); ?></td>
							<td><?php echo $contact['Contact']['address']; ?></td>
							<td><?php echo $contact['Contact']['city']; ?></td>
							<td><?php echo $contact['Contact']['country']; ?></td>
							<td><?php echo $contact['Contact']['mobile']; ?></td>
							<td><?php echo $contact['Contact']['phone']; ?></td>
							<td><?php echo $contact['Contact']['email']; ?></td>
							<?php } ?>
							<td>
								<?php
								if(!empty($contact['Fair'])) {
									$fair_names = Set::extract('/name',$contact['Fair']);
									echo implode(', ', $fair_names);
								}else{
									echo 'None';
								}
								?>
							</td>
							<?php
							if(!empty($request_data['view']) && $request_data['view'] == 'all') {
								if(!empty($field_diff)){
									foreach($field_diff as $key => $value){
										if($key =='id' || $key == 'uuid' || $key == 'fair_id' || $key == 'fair_category_id' || $key == 'active' || $key == 'photo'){
											continue;
										}
							?>
							<td>
							<?php 
							if($key == 'shared'){
								echo $contact['Contact'][$key] == '1' ? 'Yes' : 'No';	
							}
							elseif ($key == 'created' || $key == 'updated') {
								echo YMD2MDY($contact['Contact'][$key],'/');
							}elseif ($key == 'created_by') {
								echo $contact['CreatedBy']['first_name'].' '. $contact['CreatedBy']['last_name'];
							}elseif($key == 'updated_by'){
								echo $contact['UpdatedBy']['first_name'].' '. $contact['UpdatedBy']['last_name'];
							}
							else{
								echo ucfirst($contact['Contact'][$key]); 
							}
							?>
							</td>
							<?php
									}
								}else{
							?>
							<td><?php echo $contact['Contact']['website']; ?></td>
							<td><?php echo $contact['Contact']['source']; ?></td>
							<td><?php echo $contact['Contact']['guest_off']; ?></td>
							<td><?php echo $contact['Contact']['bar_code']; ?></td>
							<td><?php echo $contact['Contact']['facebook']; ?></td>
							<td><?php echo $contact['Contact']['twitter']; ?></td>
							<td><?php echo $contact['Contact']['linkedin']; ?></td>
							<td><?php echo $contact['Contact']['instagram']; ?></td>
							<td><?php echo $contact['Contact']['shared'] == 1 ? 'Yes' : 'No'; ?></td>
							<?php 
								}
							} 
							?>
							<td class="text-center">
								<?php
								//characteristics link
								echo $this->Html->link(
									'',
									'/fairs//tagCharacteristics?CONID='.$contact['Contact']['uuid'].'&FROM=main',
									array(
										'title' => 'Characteristics',
										'class' => 'mr5 glyphicon glyphicon-cog'
									)
								);
								//add guest of link
								echo $this->Html->link(
									'', 
									'/fairs/addContactAsGuest?CONID='.$contact['Contact']['uuid'],
									array(
										'title' => 'Add as guest of contacts',
										'class' => 'glyphicon glyphicon-plus-sign mr5',
										'data-toggle' => 'modal',
										'data-keyboard' => 'false',
										'data-backdrop' => 'static',
										'data-target' => '#myModal',
									)
								);
								//view details link
								echo $this->Html->link(
									'',
									'/fairs/viewContact?CONID='.$contact['Contact']['uuid'],
									array('title' => 'View Details','class' => 'glyphicon glyphicon-eye-open mr5')
								);

								//contact histroy
								echo $this->Html->link(
									'',
									'/utils/viewContactHistory?CONID='.$contact['Contact']['uuid'],
									array('title' => 'View Histroy', 'class' => 'glyphicon glyphicon-dashboard mr5')
								);
								//edit link
								echo $this->Html->link(
									'',
									'/fairs/addContact?CONID='.$contact['Contact']['uuid'].'&FROM=main',
									array( 'title' => 'Edit', 'class' => 'glyphicon glyphicon-pencil mr5' )
								);

								//delete link
								echo $this->Html->link(
									'',
									'/fairs/deleteContact?COID='.$contact['Contact']['uuid'],
									array( 
										'title' => 'Delete',
										'class' => 'glyphicon glyphicon-remove mr5',
										'onclick' => "return confirm('Are you sure?')"
									)
								);

								//upload Document(s) link
								echo $this->Html->link(
									'',
									'/fairs/addContactDocuments?contact_uuid='.$contact['Contact']['uuid'],
									array(
										'title' => 'Upload Document(s)',
										'class' => 'glyphicon glyphicon-upload'
									)
								);
								
								?>
								<a data-target="#myNotes" data-backdrop="static" data-keyboard="false" data-toggle="modal" class="glyphicon glyphicon-list-alt"  title="Notes" id="guestofLink"  href="<?php echo $this->base ?>/notes/view?contact_id=<?=$contact['Contact']['id']?>"></a>
								<a  data-target="#myFlag" <?=(isset($contact['Flag'][0]['color'])?'style="color:#'.$contact['Flag'][0]['color'].'"':'#000')?> data-backdrop="static" data-keyboard="false" data-toggle="modal" class="glyphicon glyphicon-flag" title="Flag" id="guestofLink" href="<?php echo $this->base ?>/flag/view?contact_id=<?=$contact['Contact']['id']?>"></a>
								<a title="Print adress" href="javascript:;" onclick="printAddress('<?php echo $contact['Contact']['uuid']; ?>')" class="glyphicon glyphicon-print"></a>
							</td>
						</tr>
						<?php
							
							}
						}else{

						?>
						<tr>
							<td colspan="12">No record found.</td>
						</tr>
						<?php
						
						}

						?>
					</tbody>
				</table>
			</div>
			<?php 
			
			if($pages > 1) { 

			?>
			<div class="col-lg-6">
				<?php
				$this->Paginator->options(array(
					'url' => $request_data
				));
				echo $this->element('pagination_links',array('class' => 'ajx_pagination'));
				?>
			</div>
			<?php } ?>
		</div>
	</div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	
</div>
<div class="modal fade" id="myNotes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>
<div class="modal fade" id="myFlag" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>

<?php

$code = 'loadContacts = function(elem,refresh_form){
	jQuery.ajax({
		url : jQuery(elem).attr("href")
	}).done(function(data){
		jQuery("#contacts_container").html($(data).find("#contacts_container").html());
		jQuery("#btn_container").html($(data).find("#btn_container").html());
		jQuery("#records_limit").html($(data).find("#records_limit").html());
		if(refresh_form) {
			multiselect_deselectAll($("#fair_category_id"));
			multiselect_deselectAll($("#fair_id"));
			multiselect_deselectAll($("#countries"));
			multiselect_deselectAll($("#registration_method_selct"));
			multiselect_deselectAll($("#contactCharacteristics"));
			multiselect_deselectAll($("#flag"));
			multiselect_deselectAll($("#companies"));
		}
	});
}
searchContacts = function(){
	jQuery.ajax({
		url : basePath + "/fairs/contacts?"+jQuery("#search_contacts_form").serialize()
	}).done(function(data){
		jQuery("#contacts_container").html($(data).find("#contacts_container").html());
		jQuery("#btn_container").html($(data).find("#btn_container").html());
		jQuery("#records_limit").html($(data).find("#records_limit").html());
	})
}
function multiselect_deselectAll($el) {
		$("option", $el).each(function(element) {
		$el.multiselect("deselect", $(this).val());
	});
}
';

$code .= 'jQuery(document).on("submit","#search_contacts_form",function(event){
		event.preventDefault();
		searchContacts();
	});
	
	jQuery(document).on("click","a.ajax_sort,li.ajx_pagination a",function(event) {
		event.preventDefault();
		loadContacts(this,false);
	});
	jQuery(document).on("click","a.clear_search",function(event){
		event.preventDefault();
		document.getElementById("search_contacts_form").reset();
		loadContacts(this,true);
	});';
	
$code .= '$(document).ready(function() {
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
	$("#flag").multiselect({
		buttonClass : "btn btn-default btn-sm",
		buttonWidth : "100%",
		buttonContainer : "<div class=\'btn-group w100p\'>",
		maxHeight : 200,
		buttonText : function(options, select){
						if(options.length == 0) {
							return "<span class=\'text-muted\'>Select Flag</span>"
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
	$("#companies").multiselect({
		buttonClass : "btn btn-default btn-sm",
		buttonWidth : "100%",
		buttonContainer : "<div class=\'btn-group w100p\'>",
		maxHeight : 200,
		buttonText : function(options, select){
						if(options.length == 0) {
							return "<span class=\'text-muted\'>Select Company</span>"
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
	$("#import_file").fileupload({
		url: "'.$this->base.'/utils/importContacts",
		acceptFileTypes : /(\.|\/)(xls?x)$/i,
		done: function (e, data) {
			if(data.result == "error"){
				alert("File extension or file type is not recognized");
			}else{
				window.location = "'.$this->base.'/utils/findDuplicates";
			}
        }
    });
	
});';
$code .= 'printContacts = function(){
	window.open("'.$this->base.'/utils/printContacts","printContact");
};	';

$code .= 'printAddress = function(conID){
	window.open("'.$this->base.'/fairs/printAddress?CONID="+conID);
};';

$code .= 'getContacts = function(elem){
	var select_val = jQuery(elem).find(":selected").val();
	jQuery("#records_per_page").val(select_val);
	jQuery("#search_contacts_form").submit();
}';

$this->Html->scriptBlock($code,array('block' => 'bottomScript'));

?>