<?php
$query = http_build_query($request_data);
$full_view = $normal_view = $search_in_contacts = $request_data;
$full_view['view'] = 'full';
$normal_view['view'] = 'normal';
$search_in_contacts['search_in_contacts'] = '1';
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="pull-left">
		<?php
		if(empty($invite_list)) {
			echo 'Invitation Management';
		}else{
			echo '<span>'.$invite_list['Fair']['name'].'</span><span class="ml10 mr10 glyphicon glyphicon-circle-arrow-right"></span><span>'.$invite_list['InviteList']['name'].'</span>';
		}
		?>
		</h4>
		<div class="pull-right mt5" id="btn_container">
			<?php
  			echo $this->Html->link('On Site Registration','/fairs/addContact?FROM=invites&list_id='.$request_data['list_id'],array(
  				'class' => 'btn btn-primary btn-sm ml3'
  			));
  			echo $this->Html->tag(
  				'a',
  				$this->Html->tag('span','',array('class' => 'glyphicon glyphicon-export')).'&nbsp;Export',
  				array(
  					'class' => 'btn btn-warning btn-sm ml3',
  					'href' => $this->base.'/utils/exportContactsList?'.$query
  				)
  			);
  			?>
			<a href="<?php echo $this->base ?>/invites/lists" class="btn btn-default btn-sm">
				<span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Go Back
			</a>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="panel-body">
		<div class="col-lg-10">
	  		<form method="get" action="<?php echo $this->base ?>/invites/index" class="form-horizontal form-search" id="search_contacts_form">
  				<div class="form-group">
  					<div class="col-lg-4">
  					<?php
  					echo $this->Form->input('',array(
  						'type' => 'hidden',
  						'div' => false,
  						'label' => false,
  						'name' => 'is_search_init',
  						'value' => '1'
  					));
  					echo $this->Form->input('',array(
  							'type' => 'hidden',
  							'div' => false,
  							'label' => false,
  							'name' => 'list_id',
  							'value' => isset($request_data['list_id']) ? $request_data['list_id'] : ''
  						)
  					);
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
	  				echo $this->Html->tag('label','Name',array('class' => 'col-lg-3 control-label'));
  					echo $this->Form->input('',array(
  								'class'=>'form-control input-sm',
  								'empty' => true,
  								'label' => false,
  								'div' => 'col-lg-8',
  								'type' => 'text',
  								'name' => 'name',
  								'value' => isset($request_data['name']) ? $request_data['name'] : ''
  							)
  						)
  					?>
  					</div>
	  			</div>
	  			<div class="form-group">
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
		  				echo $this->Html->tag('label','City',array('class' => 'col-lg-4 control-label'));
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
	  				<div class="col-lg-4">
	  					<?php
		  				echo $this->Html->tag('label','Country',array('class' => 'col-lg-3 control-label'));
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
	  			</div>
	  			<div class="form-group">
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
		  				echo $this->Html->tag('label','Bar Code',array('class' => 'col-lg-4 control-label'));
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
	  				<div class="col-lg-4">
  					<?php
	  				echo $this->Html->tag('label','Guest of',array('class' => 'col-lg-3 control-label'));
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
	  			</div>
	  			<div class="form-group">
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
	  					echo $this->Html->tag('label','List Actions',array('class' => 'col-lg-4 control-label'));
	  					echo $this->Form->input('',array(
		  						'class' => 'form-control input-sm',
		  						'empty' => false,
		  						'label' => false,
		  						'div' => 'col-lg-8',
		  						'type' => 'select',
		  						'options' => array('invited' => 'Invited','printed' => 'Printed','attended' => 'Attended', 'sms' => 'SMS'),
		  						'id' => 'list_actions',
		  						'multiple' => 'multiple',
		  						'name' => 'list_actions',
		  						'hiddenField' => false,
		  						'value' => isset($request_data['list_actions']) ? $request_data['list_actions'] : ''
	  						)
	  					);
	  					?>
	  				</div>
  					<div class="col-lg-4">
	  					<div class="col-lg-3">&nbsp;</div>
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
		  				<div class="col-lg-7">
		  					<?php
		  					echo $this->Html->link('Clear','/invites/index?list_id='.$request_data['list_id'],array(
		  							'class' => 'btn btn-link'
		  						)
		  					);
		  					?>
		  					<button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-search"></span>&nbsp;Search</button>
		  				</div>
	  				</div>
  				</div>
	  		</form>
  		</div>
  		<div class="col-lg-2">
  			<div class="mt10">
  				<?php
  				echo $this->Html->link('Normal View','/invites/index?'.http_build_query($normal_view),array('class' => 'btn btn-link'));
  				echo $this->Html->link('Full View','/invites/index?'.http_build_query($full_view),array('class' => 'btn btn-link'));
  				?>
  			</div>
  		</div>
  		<div class="clearfix"></div>
		<div class="table-responsive" id="contacts_container">
			<?php
			$pages = $this->Paginator->param('pageCount');
			$limit = $this->Paginator->param('limit');
			$count = $this->Paginator->param('count');
			if(empty($request_data['search_in_contacts'])) {
				echo $this->element('invite_list_contacts',array('search_in_contacts' => $search_in_contacts));
			}else{
				echo $this->element('contacts',array('query' => $query));
			}
			if($pages > 1) {
				echo $this->element('pagination_links');
			}
			?>
		</div>
	</div>
</div>

<div id="junkDiv">
	<a data-target="#myModal" data-backdrop="static" data-keyboard="false" data-toggle="modal" href="<?php echo $this->base ?>/invites/bulkAction/:ACTION"></a>
</div>

<div id="tempDiv">
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>
<?php

echo $this->Html->script(array('bootstrap-multiselect','ckeditor/ckeditor','ckeditor/adapters/jquery'),array('block' => 'bottomScript'));
echo $this->Html->css(array('bootstrap-multiselect'),array('block' => 'css'));

$no_of_records = $count < $limit ? $count : $limit;

$code = 'jQuery(document).ready(function() {

	var records = '.$no_of_records.';
	var obj = {
		"invited" : "invited",
		"printed" : "printed",
		"attended" : "attended",
		"sms_list" : "sms_list"
	};
	jQuery.each(obj,function(index,value) {
		var temp = jQuery("a."+value+".glyphicon-ok").length;
		if(temp == records) {
			jQuery("#"+value+"_all_a").toggleClass("glyphicon-ok glyphicon-remove-circle");
			jQuery("#"+value+"_all_a").toggleClass("text-success text-danger");
		}
	});
	
	jQuery("#fair_category_id").multiselect({
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
	
	jQuery("#fair_id").multiselect({
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
	jQuery("#contactCharacteristics").multiselect({
		buttonClass : "btn btn-default btn-sm",
		buttonWidth : "100%",
		maxHeight : 200,
		buttonContainer : "<div class=\'btn-group w100p\'>",
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
	
	jQuery("#countries").multiselect({
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
	
	jQuery("#list_actions").multiselect({
		buttonClass : "btn btn-default btn-sm",
		buttonWidth : "100%",
		buttonContainer : "<div class=\'btn-group w100p\'>",
		maxHeight : 200,
		buttonText : function(options, select){
						if(options.length == 0) {
							return "<span class=\'text-muted\'>Select Action</span>"
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

$code .= 'var toggle_action = function(action,id,elem){
	var value = 1;
	if(jQuery(elem).hasClass("glyphicon-ok")) {
		value = 0;
	}
	jQuery("#"+action+"_"+id).css("display","");
	jQuery(elem).css("display","none");
	jQuery.ajax({
		type : "get",
		url : basePath + "/invites/logValue",
		data : {action:action,value:value,id:id}
	}).done(function(data){
		if(data == 1 && action == "attended") {
			jQuery("#attended_"+id).html("<span class=\"glyphicon glyphicon-ok text-success fs14\"></span>");
		}else{
			if(data == 1){
				$(elem).toggleClass("glyphicon-ok glyphicon-remove-circle");
				$(elem).toggleClass("text-success text-danger");
			}
			jQuery("#"+action+"_"+id).css("display","none");
			jQuery(elem).css("display","");
		}
	});
};';

$code .= 'var toggle_actions = function(action) {
	var cls = "glyphicon-remove-circle";
	if(jQuery("#"+action+"_all_a").hasClass("glyphicon-ok")) {
		cls = "glyphicon-ok";
	}
	jQuery("#"+action+"_all").css("display","");
	jQuery("a."+action+"."+cls).hide().trigger("click");
	jQuery("#"+action+"_all").css("display","none");
	
	jQuery("#"+action+"_all_a").toggleClass("glyphicon-ok glyphicon-remove-circle");
	jQuery("#"+action+"_all_a").toggleClass("text-success text-danger");
};';


$code .= 'bulkAction = function(action){
	checked_length = jQuery(".contact_checkbox:checked").length;
	values = jQuery(".contact_checkbox:checked").map(function() {
		return this.value;
	}).get();
	
	if(checked_length < 1) {
		alert("Please check contact(s) first");
	}else{
		if(action == "delete" && confirm("Are your sure?")) {
			jQuery.ajax({
				url : basePath + "/invites/deleteFromList",
				type : "post",
				data : {contact_uuids:values}
			}).done(function(data){
				jQuery("#search_contacts_form").submit();
			});
		}else if(action == "sms" || action== "send_invitation") {
			var tempHtml = jQuery("#junkDiv").html();
			tempHtml = tempHtml.replace(/:ACTION/g,action);
			jQuery("#tempDiv").html(tempHtml);
			jQuery("#tempDiv").find("a").trigger("click");
		}
	}

};';

$code .= 'checkboxStatus = function(elem){
	if(jQuery(elem).is(":checked")){
		jQuery(".contact_checkbox").prop("checked",true)
	}else{
		jQuery(".contact_checkbox").prop("checked",false);
	}
};';

$code .= 'jQuery(document).on("submit","#search_contacts_form",function(event){
		event.preventDefault();
		searchContacts();
	});';

$code .= 'searchContacts = function(){
	jQuery.ajax({
		url : basePath + "/invites/index?"+jQuery("#search_contacts_form").serialize()
	}).done(function(data){
		jQuery("#contacts_container").html($(data).find("#contacts_container").html());
		jQuery("#btn_container").html($(data).find("#btn_container").html());
	})
};';

$code .= '

bulkDelete = function(){
	values = jQuery(".contact_list_id").map(function() {
		return this.value;
	}).get();
	
	if(confirm("Are your sure?")) {
		jQuery.ajax({
			url : basePath + "/invites/deleteFromList",
			type : "post",
			data : {contact_uuids:values}
		}).done(function(data){
			jQuery("#search_contacts_form").submit();
		});
	}

};


';

echo $this->Html->scriptBlock($code,array('block' => 'bottomScript'));

?>