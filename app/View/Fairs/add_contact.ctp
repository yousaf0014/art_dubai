<?php
echo $this->Html->css('redmond/jquery-ui-1.10.3.custom.min',array('block' => 'css'));
echo $this->Html->script(array('jquery.validate.min','jquery-ui-1.10.3.custom.min','fairs'), array('block' => 'script'));
$query = $this->request->query;
$list_id = isset($query['list_id']) ? $query['list_id'] : '';
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="pull-left"><?php echo empty($conID) ? 'Add' : 'Edit'; ?> Contact</h4>
		<a class="pull-right btn btn-default btn-sm" href="<?php echo $this->request->referer(); ?>"><span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Go Back</a>
        <a href="javascript:;" class="mr10 btn btn-sm btn-default pull-right" onclick="$('#addContactForm').submit();">Save</a>
		<div class="clearfix"></div>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" id="addContactForm" role="form" method="post" action="<?php echo $this->base ?>/Fairs/addContact?CID=<?php echo $catID; ?>&CONID=<?php echo $conID; ?>&FID=<?php echo $fid; ?>&FROM=<?php echo $from; ?>&list_id=<?php echo $list_id; ?>" enctype="multipart/form-data">
        	<div class="col-lg-6 col-lg-offset-1">
				<?php
                if($from == 'Companies' || (empty($catID) && empty($fid) && empty($conID))) {
                ?>
                <div class="form-group">
                	<label class="control-label col-lg-4">Select Category</label>
                    <div class="col-lg-6">
                    	<select name="data[Contact][fair_category_id]" class="form-control input-sm" onchange="fetchFairs(this);fetchInviteType(this);">
                    		<option value="">Select Category:</option>
							<?php
                        	foreach($fairCategories as $index => $fairCategory) {
                                $selected = '';
                                
                                if(isset($contact['Contact']['fair_category_id']) && $fairCategory['FairCategory']['id'] == $contact['Contact']['fair_category_id']) {
                                    $selected = 'selected="selected"';
                                }
                    		?>
                        	<option <?php echo $selected; ?> value="<?php echo $fairCategory['FairCategory']['id']; ?>"><?php echo $fairCategory['FairCategory']['name']; ?></option>
                    		<?php
                        	}
                    		?>
                    	</select>
                    </div>
                </div>
                <div class="form-group">
                	<label class="control-label col-lg-4">Select Fair:</label>
                    <?php
                    echo $this->Form->input('Contact.fair_id',array(
                        'div' => 'col-lg-6',
                        'label' => false,
                        'class' => 'form-control input-sm',
                        'id' => 'fair_id_select',
                        'empty' => 'Select Fair',
                        'options' => $fairs,
                        'value' => isset($contact['Contact']['fair_id']) ? $contact['Contact']['fair_id'] : ''
                    ));
                    ?>
                </div>
                <?php
				}
				?>
                <div class="form-group">
                    <?php
                    echo $this->Html->tag('label','Invite Type:',array('class' => 'col-lg-4 control-label'));
                    echo $this->Form->input('Contact.invite_category_id',array(
                        'label' => false,
                        'div' => 'col-lg-6',
                        'type' => 'select',
                        'empty' => 'Select Invite Type',
                        'class' => 'form-control input-sm',
                        'options' => $invite_types
                    ));
                    ?>
                </div>
                <div class="form-group">
                    <?php
                    echo $this->Html->tag('label','Salutation:',array('class' => 'col-lg-4 control-label'));
                    echo $this->Form->input('Contact.salutation',array(
                        'label' => false,
                        'div' => 'col-lg-6',
                        'class' => 'form-control input-sm',
                        'options' => array(
                            'Mr.' => 'Mr.',
                            'Mrs' => 'Mrs',
                            'Miss' => 'Miss',
                            'His Highness' => 'His Highness',
                            'Her Highness' => 'Her Highness',
                        )
                    ));
                    ?>
                </div>
                <div class="form-group">
                    <label for="inputName" class="col-lg-4 control-label">First Name:</label>
                    <div class="col-lg-6">
                        <input class="form-control input-sm" id="inputName" placeholder="First Name" name="data[Contact][first_name]" value="<?php echo !empty($contact['Contact']['first_name']) ? $contact['Contact']['first_name'] : ''; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputLastName" class="col-lg-4 control-label">Last Name:</label>
                    <div class="col-lg-6">
                        <input class="form-control input-sm" id="inputLastName" placeholder="Last Name" name="data[Contact][last_name]" value="<?php echo !empty($contact['Contact']['last_name']) ? $contact['Contact']['last_name'] : ''; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-4 control-label">Country:</label>
                    <?php
                    echo $this->Form->input('Contact.country',array(
                        'class' => 'form-control input-sm',
                        'onchange' => 'fetchCities(this);',
                        'label' => false,
                        'div' => 'col-lg-6',
                        'options' => $countries
                    ));
                    ?>
                </div>
                <div class="form-group">
                    <label class="col-lg-4 control-label">City:</label>
                    <?php
                    echo $this->Form->input('Contact.city',array(
                        'class' => 'form-control input-sm',
                        'div' => 'col-lg-6',
                        'id' => 'city',
                        'label' => false,
                        'empty' => 'Select City',
                        'options' => $cities,
                        'value' => isset($contact['Contact']['city']) ? $contact['Contact']['city'] : ''
                    ));
                    ?>
                    <div class="col-lg-2">
                        <a href="javascript:;" id="city_other">Other</a>
                    </div>
                </div>
                <div class="form-group" id="other_city_container" style="display:none;">
                    <label class="col-lg-4 control-label">Enter City Name:</label>
                    <div class="col-lg-6">
                        <input Type="text" name="data[Contact][city_other]" class="form-control input-sm">
                    </div>
                    <div class="col-lg-2">
                        <a href="javascript:;" id="hide_other_city">Hide</a>
                    </div>
                </div>
                <div class="form-group hide">
                    <label class="col-lg-4 control-label">Country Code:</label>
                    <div class="col-lg-6">
                        <input class="form-control input-sm" name="data[Contact][country_code]" value="<?php echo isset($contact['Contact']['country_code']) ? $contact['Contact']['country_code'] : ''; ?>" id="country_code">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-4 control-label">Nationality:</label>
                    <?php
                    echo $this->Form->input('Contact.nationality',array(
                        'class' => 'form-control input-sm',
                        'label' => false,
                        'div' => 'col-lg-6',
                        'options' => $countries
                    ));
                    ?>
                </div>
                <div class="form-group">
                    <label class="col-lg-4 control-label">Address Line 1:</label>
                    <div class="col-lg-6">
                        <textarea class="form-control input-sm" rows="1" type="text" name="data[Contact][address]" placeholder="Address Line 1"><?php echo !empty($contact['Contact']['address']) ? $contact['Contact']['address'] : ''; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-4 control-label">Address Line 2:</label>
                    <div class="col-lg-6">
                        <textarea class="form-control input-sm" rows="1" type="text" name="data[Contact][address_2]" placeholder="Address Line 2"><?php echo !empty($contact['Contact']['address_2']) ? $contact['Contact']['address_2'] : ''; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-4 control-label">Address Line 3:</label>
                    <div class="col-lg-6">
                        <textarea class="form-control input-sm" rows="1" type="text" name="data[Contact][address_3]" placeholder="Address Line 3"><?php echo !empty($contact['Contact']['address_3']) ? $contact['Contact']['address_3'] : ''; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-4 control-label">Bar Code:</label>
                    <div class="col-lg-6">
                        <input class="form-control input-sm" type="text" name="data[Contact][bar_code]" value="<?php echo !empty($contact['Contact']['bar_code']) ? $contact['Contact']['bar_code'] : generate_bar_code(); ?>" placeholder="Phone">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-4 control-label">Phone:</label>
                    <div class="col-lg-6">
                        <input class="form-control input-sm" type="text" name="data[Contact][phone]" value="<?php echo !empty($contact['Contact']['phone']) ? $contact['Contact']['phone'] : ''; ?>" placeholder="Phone">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-4 control-label">Mobile:</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control input-sm" name="data[Contact][mobile]" value="<?php echo !empty($contact['Contact']['mobile']) ? $contact['Contact']['mobile'] : ''; ?>" placeholder="Mobile">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-4 control-label">Phone 2:</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control input-sm" name="data[Contact][phone2]" value="<?php echo !empty($contact['Contact']['phone2']) ? $contact['Contact']['phone2'] : ''; ?>" placeholder="Phone 2">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-4 control-label">Email:</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control input-sm" name="data[Contact][email]" value="<?php echo !empty($contact['Contact']['email']) ? $contact['Contact']['email'] : ''; ?>" placeholder="Email">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-4 control-label">Zip Code:</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control input-sm" name="data[Contact][zip]" value="<?php echo !empty($contact['Contact']['zip']) ? $contact['Contact']['zip'] : ''; ?>" placeholder="Zip Code">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-4 control-label">P.O. Box:</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control input-sm" name="data[Contact][pobox]" value="<?php echo !empty($contact['Contact']['pobox']) ? $contact['Contact']['pobox'] : ''; ?>" placeholder="P.O. Box">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-4 control-label">Website:</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control input-sm" name="data[Contact][website]" value="<?php echo !empty($contact['Contact']['website']) ? $contact['Contact']['website'] : ''; ?>" placeholder="Website">
                    </div>
                </div>
                <div class="form-group">
                    <?php
                    echo $this->Html->tag('label','Picure:',array(
                            'class' => 'col-lg-4 control-label'
                        ));
                    echo $this->Form->input('Contact.photo',array(
                            'type' => 'file',
                            'div' => 'col-lg-6',
                            'label' => false
                        ));
                    ?>
                </div>
                <?php
                if(!empty($contact['Contact']['photo']) && !is_array($contact['Contact']['photo']) && file_exists(WWW_ROOT.$contact['Contact']['photo'])){
                ?>
                <div class="form-group">
                    <?php
                    echo $this->Html->tag('label','Previous Picure:',array(
                            'class' => 'col-lg-4 control-label'
                        ));
                    ?>
                    <div class="col-lg-6">
                    <?php
                    echo $this->Html->image($contact['Contact']['photo'],array(
                            'class' => 'img-thumbnail'
                        ));
                    ?>
                    </div>
                </div>
                <?php
                }
                ?>
                
                <div class="form-group">
                    <label class="col-lg-4 control-label">Guest off:</label>
                    <div class="col-lg-6">
                        <input class="form-control input-sm" type="text" name="data[Contact][guest_off]" value="<?php echo !empty($contact['Contact']['guest_off']) ? $contact['Contact']['guest_off'] : ''; ?>" placeholder="Guest off" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-4 control-label">Source:</label>
                    <div class="col-lg-6">
                        <input class="form-control input-sm" type="text" name="data[Contact][source]" value="<?php echo !empty($contact['Contact']['source']) ? $contact['Contact']['source'] : ''; ?>" placeholder="Source" />
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="panel panel-info">
                    <div class="panel-heading">Tag Companies</div>
                    <div class="panel-body">
                        <div class="form-group">
                        <?php
                        echo $this->Html->tag('label','Type to Search:',array('class' => 'col-lg-3 control-label'));
                        echo $this->Form->input('compnay_name',array(
                                'class'=>'form-control input-sm',
                                'empty' => false,
                                'label' => false,
                                'div' => 'col-lg-7',
                                'type' => 'text',
                            ));
                        echo $this->Html->link('Add New','/fairs/addCompany',array(
                                'class' => 'btn btn-link company-popup',
                                'data-toggle' => 'modal',
                                'data-target' => '#myModal',
                            )
                        );
                        ?>
                        </div>
                        <div class="clearfix"></div>
                        <div id="tagged_companies">
                            <?php
                            if(!empty($tagedCompanies)) {
                                foreach ($tagedCompanies as $key => $tagedCompany) {
                            ?>
                            <div class="form-group" id="tag_c_<?php echo $tagedCompany['Company']['id']; ?>">
                                <label class="col-lg-3 control-label">
                                    <input name="data[ContactToCompany][<?php echo $tagedCompany['Company']['id']; ?>][id]" value="<?php echo $tagedCompany['Company']['id']; ?>" type="hidden" class="already_tagged">
                                    <input type="hidden" name="data[ContactToCompany][<?php echo $tagedCompany['Company']['id']; ?>][name]" value="<?php echo $tagedCompany['Company']['name']; ?>">
                                    <?php echo $tagedCompany['Company']['name']; ?>
                                </label>
                                <div class="col-lg-7">
                                    <input type="text" class="form-control " name="data[ContactToCompany][<?php echo $tagedCompany['Company']['id']; ?>][job_title]" value="<?php echo isset($tagedCompany['ContactToCompany']['job_title']) ? $tagedCompany['ContactToCompany']['job_title'] : ''; ?>" placeholder="Job title" />
                                </div>
                                <a href="javascript:;" onclick="$('#tag_c_<?php echo $tagedCompany['Company']['id']; ?>').remove();" class="glyphicon glyphicon-remove mt5"></a>
                                <span class="ml10">
                                    <input title="Make default" class="default_company" onclick="toggleDefault(this);" type="checkbox" name="data[ContactToCompany][<?php echo $tagedCompany['Company']['id']; ?>][default]" value="1" <?php echo isset($tagedCompany['ContactToCompany']['default']) && $tagedCompany['ContactToCompany']['default'] == '1' ? 'checked="checked"' : ''; ?>>
                                </span>
                            </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">Social Media</div>
                    <div class="panel-body">
                        <?php
                        foreach ($socialMedias as $key => $value) {
                        ?>
                        <div class="form-group">
                            <?php
                            echo $this->Html->tag('label',(String)$value.':',array('class' => 'col-lg-4 control-label'));
                            echo $this->Form->input('Contact.'.$key,array(
                                'class'=>'form-control input-sm',
                                'empty' => false,
                                'label' => false,
                                'div' => 'col-lg-7',
                                'type' => 'text',
                            ));
                            ?>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-lg-4 col-lg-offset-3">
            	<div class="form-group">
                    <div class="col-lg-4 hide">
                        <input id="inputShared" <?php //echo !empty($contact['Contact']['shared']) ? 'checked="checked"' : ''; ?> type="checkbox" name="data[Contact][shared]" value="1" checked="checked">
                        <label for="inputShared" class="control-label" >Shared</label>
                    </div>
                    <div class="col-lg-offset-6 col-lg-2">
                        <button type="submit" class="btn btn-primary btn-sm">Save</button>
                    </div>
                    
            	</div>
            </div>
		</form>
	</div>
</div>
<div id="company_taging" style="display:none;">
    <div class="form-group" id="tag_c_:CID">
        <input name="data[ContactToCompany][:CID][id]" type="hidden" value=":CID" class=":CLASS">
        <input name="data[ContactToCompany][:CID][name]" type="hidden" value=":CNAME">
        <label class="col-lg-3 control-label">:CNAME</label>
        <div class="col-lg-7">
            <input type="text" class="form-control input-sm" name="data[ContactToCompany][:CID][job_title]" value="" placeholder="Job title">
        </div>
        <a href="javascript:;" onclick="$('#tag_c_:CID').remove();" class="glyphicon glyphicon-remove mt5"></a>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                Loading...
            </div>
        </div>
    </div>
</div>
<?php

echo $this->Html->scriptStart(array('inline' => false,'block' => 'bottomScript'));

echo 'var year = '.date('Y').';';

echo '$(document).on("click","#city_other",function(event){
    jQuery("#other_city_container").show().find("input").prop("disabled",false);
});';

echo 'jQuery(document).on("click","#hide_other_city",function(event){
    jQuery("#other_city_container").hide().find("input").prop("disabled",true);
});';

echo '$(document).ready(function() {
		validate_add_contact_form();
        $("body").on("hidden.bs.modal", ".modal", function () {
            $(this).removeData("bs.modal");
        });
        $("#compnay_name").autocomplete({
            source : function(request,response){
                var tagged = "";
                $("input.already_tagged").each(function( index ) {
                    tagged += this.value+",";
                });
                $.ajax({
                    url : basePath+"/fairs/search_companies",
                    dataType : "json",
                    data: {
                        tagged : tagged,
                        term : request.term
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return item;
                        }));
                    }
                });
            },
            select : function(event, ui) {
                var html = $("#company_taging").html();
                html = html.replace(/:CID/g,ui.item.id);
                html = html.replace(/:CNAME/g,ui.item.label);
                html = html.replace(/:CLASS/g,"already_tagged");
                $("#tagged_companies").prepend(html);
            }
        });
	});';

echo 'fetchFairs = function(elem){
    var selected_value = jQuery(elem).find("option:selected").val();
    jQuery.ajax({
        dataType : "json",
        type : "get",
        url : basePath + "/fairs/fetechFairs",
        data : {cat_id:selected_value}
    }).done(function(data){
        var html = \'<option value="">Select Fair</option>\';
        $(data).each(function(index,element){
            var selected = "";
            if(year == element.year) {
                selected = \'selected="selected"\';
            }
            html += \'<option value="\'+element.key+\'" \'+selected+\'>\'+element.value+\'</option>\';
        });
        jQuery("#fair_id_select").html(html);
    });
};';

echo 'fetchInviteType = function(elem){
    var selected_value = jQuery(elem).find("option:selected").val();
    jQuery.ajax({
        dataType : "json",
        type : "get",
        url : basePath + "/fairs/getInviteTypes",
        data : {cat_id:selected_value}
    }).done(function(data){
        var html = \'<option value="">Select Invite Type</option>\';
        $(data).each(function(index,element){
            var selected = "";
            html += \'<option value="\'+element.key+\'" \'+selected+\'>\'+element.value+\'</option>\';
        });
        jQuery("#ContactInviteCategoryId").html(html);
    });
};';

echo 'fetchCities = function(elem){
    var selected_value = jQuery(elem).find("option:selected").val();
    jQuery.ajax({
        dataType : "json",
        type : "get",
        url : basePath + "/fairs/getCities",
        data : {country_code:selected_value}
    }).done(function(data){
        var html = \'<option value="">Select City</option>\';
        $(data.cities).each(function(index,element){
            html += \'<option value="\'+element.key+\'">\'+element.value+\'</option>\';
        });
        jQuery("#city").html(html);
        jQuery("#country_code").val(data.country_code);
    });
};';

echo 'toggleDefault = function(elem){
    if(jQuery(elem).is(":checked")) {
        jQuery("input.default_company").prop("checked",false);
        jQuery(elem).prop("checked",true);
    }
}';

echo $this->Html->scriptEnd();

?>