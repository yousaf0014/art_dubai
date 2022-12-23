<?php
echo $this->Html->script(array('jquery.validate.min','fairs'),array('block' => 'bottomScript'));
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="pull-left">Import Contacts</h4>
		<div class="clearfix"></div>
	</div>
  	<div class="panel-body">
  		<form method="post" id="importContacts" action="<?php echo $this->base ?>/utils/importRecoreds" class="form-horizontal">
  			<div class="form-group">
				<?php 
				echo $this->Html->tag('label','Select Category',array('class' => 'col-lg-2 control-label'));
				echo $this->Form->input('Contact.fair_category_id',array(
						'type' => 'select',
						'class' => 'form-control input-sm',
						'options' => $fairCats,
						'label' => false,
						'div' => 'col-lg-2',
						'empty' => '',
						'onchange' => 'fetchFairs(this)'
					));
				?>
			</div>
			<div class="form-group">
				<?php
				echo $this->Html->tag('label','Select Fair',array('class' => 'col-lg-2 control-label'));
				echo $this->Form->input('Contact.fair_id',array(
						'type' => 'select',
						'class' => 'form-control input-sm',
						'options' => $fairs,
						'label' => false,
						'div' => 'col-lg-2',
						'empty' => '',
						'id' => 'fair_id_select'
					));
				?>
			</div>
			<div class="form-group">
				<div class="checkbox col-lg-offset-2">
					<label>
						<input class type="checkbox" name="data[Contact][shared]" value="1">Shared
					</label>
				</div>
			</div>
			<?php
			if(!empty( $duplicates)) {
			?>
			<p class="text-warning pull-left">The information you enterted match with the following record(s) in the system. You can overwrite the existing record by selecting them or ignore the record you are going to add.</p>
			<div class="pull-right">
				<div class="alert alert-warning pull-right">Existing Record</div>
				<div class="alert pull-right">Your Record</div>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
			<table class="table table-condensed">
				<thead>
					<tr>
                    	<th width="5%">Overwrite</th>
                    	<th width="3%">Ignore</th>
						<th width="10%">First Name</th>
                        <th  width="10%">Last Name</th>
						<th>Address</th>
						<th width="10%">Phone</th>
						<th width="5%">Email</th>
						<th width="5%">Mobile</th>
						<th width="5%">Fax</th>
						<th width="10%">Website</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<input type="checkbox" id="parent_overwrite" onclick="toggle_childs('overwrite',this)">
						</td>
						<td>
							<input type="checkbox" id="parent_ignore" onclick="toggle_childs('ignore',this)">
						</td>
						<td colspan="8"></td>
					</tr>
					<?php
					
						foreach ($duplicates as $index => $contact) {
					?>
					
					<tr>
						<td>
							<input type="checkbox" id="parent_chk_<?php echo $index; ?>" class="overwrite" onclick="toggle_checkboxes('parent','<?php echo $index; ?>','overwrite');">
						</td>
						<td>
							<input type="checkbox" name="data[Contact][ignore][<?php echo $index; ?>]" class="ignore_<?php echo $index; ?> ignore" onclick="toggle_overwirte_chk('<?php echo $index; ?>',this);">
						</td>
                        <td><label><?php echo ucwords($contact['Contact']['first_name']); ?></label></td>
                        <td><label><?php echo ucwords($contact['Contact']['last_name']); ?></label></td>
						<td><?php echo $contact['Contact']['address']; ?></td>
						<td><?php echo $contact['Contact']['phone']; ?></td>
						<td><?php echo $contact['Contact']['email']; ?></td>
						<td><?php echo $contact['Contact']['mobile']?></td>
						<td><?php echo $contact['Contact']['fax']; ?></td>
						<td><?php echo $contact['Contact']['website']; ?></td>
					</tr>
					
					<?php

						foreach($contact['duplicateRecords'] as $key => $value) {
					?>
					<tr class="warning">
						<td>
							<input type="checkbox" name="data[Contact][overwrite][<?php echo $index; ?>][]" value="<?php echo $value['Contact']['uuid']?>" class="overwrite_chk_<?php echo $index; ?> overwrite" onclick="toggle_checkboxes('child','<?php echo $index; ?>','overwrite');">
						</td>
						<td>&nbsp;</td>
						<td class="<?php echo $contact['Contact']['first_name'] == $value['Contact']['first_name'] ? 'danger' : '';?>"><?php echo $value['Contact']['first_name'] ?></td>
						<td class="<?php echo $contact['Contact']['last_name'] == $value['Contact']['last_name'] ? 'danger' : ''; ?>"><?php echo $value['Contact']['last_name'] ?></td>
						<td class="<?php echo $contact['Contact']['address'] == $value['Contact']['address'] ? 'danger' : '';?>"><?php echo $value['Contact']['address'] ?></td>
						<td class="<?php echo $contact['Contact']['phone'] == $value['Contact']['phone'] ? 'danger' : '';?>"><?php echo $value['Contact']['phone'] ?></td>
						<td class="<?php echo $contact['Contact']['email'] == $value['Contact']['email'] ? 'danger' : '';?>"><?php echo $value['Contact']['email'] ?></td>
						<td class="<?php echo $contact['Contact']['mobile'] == $value['Contact']['mobile'] ? 'danger' : '';?>"><?php echo $value['Contact']['mobile'] ?></td>
						<td class="<?php echo $contact['Contact']['fax'] == $value['Contact']['fax'] ? 'danger' : '';?>"><?php echo $value['Contact']['fax'] ?></td>
						<td class="<?php echo $contact['Contact']['website'] == $value['Contact']['website'] ? 'danger' : '';?>"><?php echo $value['Contact']['website'] ?> </td>
					</tr>
					<?php
						}
					}
				?>
				</tbody>
			</table>
			<?php
			}
			?>
			<div class="pull-right">
				<button type="submit" class="btn btn-primary btn-sm">Continue</button>
			</div>
			<div class="clearfix"></div>
		</form>
	</div>
</div>

<?php
$code = 'jQuery(document).ready(function(){
		validate_import_contacts();
});';

$code .= 'var toggle_checkboxes = function(callee,index,type){
	
	if(callee=="parent") {
		if($("input[type=\'checkbox\']#parent_chk_"+index).is(":checked")) {
			$("input[type=\'checkbox\']."+type+"_chk_"+index).prop("checked",true);
			$("input[type=\'checkbox\'].ignore_"+index).prop("checked",false);
		}else{
			$("input[type=\'checkbox\']."+type+"_chk_"+index).prop("checked",false);
		}
	}
	if(callee=="child") {
		if($("input[type=\'checkbox\']."+type+"_chk_"+index+":checked").length == $("input[type=\'checkbox\']."+type+"_chk_"+index).length){
			jQuery("#parent_chk_"+index).prop("checked",true);
			jQuery("input[type=\'checkbox\'].ignore_"+index).prop("checked",false);
		}else{
			$("#parent_chk_"+index).prop("checked",false);
		}
	}
};';

$code .= 'var toggle_childs = function(callee,elem){
		var oposite = callee == "overwrite" ? "ignore" : "overwrite";
		if(jQuery(elem).is(":checked")) {
			jQuery("input[type=\'checkbox\']."+callee).prop("checked",true);
			jQuery("."+oposite).prop("checked",false);
			jQuery("input#parent_"+oposite).prop("checked",false);
		}else{
			jQuery("input[type=\'checkbox\']."+callee).prop("checked",false);
		}
};';

$code .= 'var toggle_overwirte_chk = function(index,elem){
	if(jQuery(elem).is(":checked")){
		jQuery("input[type=\'checkbox\'].overwrite_chk_"+index).prop("checked",false);
		jQuery("input[type=\'checkbox\']#parent_chk_"+index).prop("checked",false);
	}
};';

$code .= 'fetchFairs = function(elem){
    var selected_value = jQuery(elem).find("option:selected").val();
    jQuery.ajax({
        dataType : "json",
        type : "get",
        url : basePath + "/fairs/fetechFairs",
        data : {cat_id:selected_value}
    }).done(function(data){
        var html = \'<option value="">Select Fair</option>\';
        $(data).each(function(index,element){
            html += \'<option value="\'+element.key+\'">\'+element.value+\'</option>\';
        });
        jQuery("#fair_id_select").html(html);
    });
}';

echo $this->Html->scriptBlock($code,array('block' => 'bottomScript'));

?>