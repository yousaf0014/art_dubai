validate_list_add_form = function(){
	jQuery('#addListForm').validate({
		errorClass : 'error',
		rules : {
			'data[InviteList][name]' : {required:true},
			'data[InviteList][invite_category_id]' : {required:true},
			'data[InviteList][fair_id]' : {required:true},
			'data[InviteList][fair_event_id]' : {required:true},
		},
		messages : {
			'data[InviteList][name]' : {required:'Please enter name'},
			'data[InviteList][fair_id]' : {required:'Please select a fair'},
			'data[InviteList][invite_category_id]' : {required:'Please select category'},
			'data[InviteList][fair_event_id]' : {required:'Please select event'},
		},
		showErrors: function(errorMap, errorList) {
			show_errors(this,errorMap,errorList,'right');
		  }
	});
}
validate_add_fair_form = function(){
	jQuery('#addFairForm').validate({
		errorClass : 'error',

		rules : {
			'data[Fair][name]' : {required:true},
			'data[Fair][start_date]' : {required:true},
			'data[Fair][duration]' : {required:true},
			'data[Fair][location]' : {required:true}
		},
		messages : {
			'data[Fair][name]' : {required:'Please enter name'},
			'data[Fair][start_date]' : {required:'Please enter start date'},
			'data[Fair][duration]' : {required:'Please enter duration'},
			'data[Fair][location]' : {required:'Please enter location'}
		},
		showErrors: function(errorMap, errorList) {
			show_errors(this,errorMap,errorList,'right');
		  }
	});
}

validate_fair_cat_form = function(){
	jQuery('#addCatForm').validate({
		errorClass : 'has-error',
		rules : {
			'data[FairCategory][name]' : {required:true}
		},
		messages : {
			'data[FairCategory][name]' : {required:'Please enter name'}
		},
		showErrors: function(errorMap, errorList) {
			show_errors(this,errorMap,errorList,'right');
		  }
	});
}
validate_fair_event_form = function(){
	jQuery('#addFairEventForm').validate({
		errorClass : 'has-error',
		rules : {
			'data[FairEvent][name]' : {required:true},
			'data[FairEvent][start_date]' : {required:true},
			'data[FairEvent][duration]' : {required:true},
			'data[FairEvent][location]' : {required:true}
		},
		messages : {
			'data[FairEvent][name]' : {required:'Please enter name'},
			'data[FairEvent][start_date]' : {required:'Please enter start date'},
			'data[FairEvent][duration]' : {required:'Please enter duration'},
			'data[FairEvent][location]' : {required:'Please enter location'}
		},
		showErrors: function(errorMap, errorList) {
			show_errors(this,errorMap,errorList,'right');
		  }
	});
}
validate_contact_cat_form = function(){
	jQuery('#addCatForm').validate({
		errorClass : 'has-error',
		rules : {
			'data[ContactCategory][name]' : {required:true}
		},
		messages : {
			'data[ContactCategory][name]' : {required:'Please enter name'}
		},
		showErrors: function(errorMap, errorList) {
			show_errors(this,errorMap,errorList,'right');
		}
	});
}
validate_contact_characteristics_form = function(){
	jQuery('#addCatForm').validate({
		errorClass : 'has-error',
		rules : {
			'data[ContactCharacteristic][name]' : {required:true},
			'data[ContactCharacteristic][fair_id]' : {required:true}
		},
		messages : {
			'data[ContactCharacteristic][name]' : {required:'Please enter name'},
			'data[ContactCharacteristic][fair_id]' : {required:'Please select fair'},
		},
		showErrors: function(errorMap, errorList) {
			show_errors(this,errorMap,errorList,'right');
		}
	});
}

validate_corp_cat_form = function(){
	jQuery('#addCorpCateg').validate({
		errorClass : 'has-error',
		rules : {
			'data[CorporateCategory][name]' : {required:true}
		},
		messages : {
			'data[CorporateCategory][name]' : {required:'Please enter name'}
		},
		showErrors: function(errorMap, errorList) {
			show_errors(this,errorMap,errorList,'right');
		}
	});
}

validate_add_comany_form = function(){
	jQuery('#addCompanyForm').validate({
		errorClass : 'has-error',
		rules : {
			'data[Company][corporate_category_id]' : {required:true},
			'data[Company][name]' : {required:true},
			'data[Company][city]' : {required:true},
			'data[Company][address]' : {required:true},
			'data[Company][phone]' : {required:true},
			'data[Company][email]' : {required:true,email:true}
		},
		messages : {
			'data[Company][corporate_category_id]' : {required:'Please select category'},
			'data[Company][name]' : {required:'Please enter name'},
			'data[Company][city]' : {required:'Please enter city'},
			'data[Company][address]' : {required:'Please enter address'},
			'data[Company][phone]' : {required:'Please enter phone number'},
			'data[Company][email]' : {required:'Please enter email',email:'Valid email required'}	
		},
		showErrors: function(errorMap, errorList) {
			show_errors(this,errorMap,errorList,'right');
		  }
	});
}

validate_invite_category_form = function(){
	jQuery('#addCatForm').validate({
		errorClass : 'has-error',
		rules : {
			'data[InviteCategory][name]' : {required:true},
			'data[InviteCategory][fair_category_id]' : {required:true}
		},
		messages : {
			'data[InviteCategory][name]' : {required:'Please enter name'}
		},
		showErrors: function(errorMap, errorList) {
			show_errors(this,errorMap,errorList,'right');
		}
	});
}

validate_add_contact_form = function(){
	jQuery('#addContactForm').validate({
		errorClass : 'has-error',
		rules : {
			'data[Contact][fair_category_id]' : {required:true},
			'data[Contact][fair_id]' : {required:true},
			'data[Contact][invite_category_id]' : {required:true},
			'data[Contact][first_name]' : {required:true},
			'data[Contact][last_name]' : {required:true},
			'data[Contact][city]' : {required:true},
			// 'data[Contact][address]' : {required:true},
			'data[Contact][email]' : {required:true,email:true},
			'data[Contact][bar_code]' : {required:true}
		},
		messages : {
			'data[Contact][fair_category_id]' : {required:'Please select a category'},
			'data[Contact][fair_id]' : {required:'Please select a fair'},
			'data[Contact][invite_category_id]' : {required:'Please select invite type'},
			'data[Contact][first_name]' : {required:'Please enter first name'},
			'data[Contact][last_name]' : {required:'Please enter last name'},
			'data[Contact][city]' : {required:'please enter city'},
			// 'data[Contact][address]' : {required:'Please enter address'},
			'data[Contact][email]' : {required:'Please enter email',email:'Valid email required'},
			'data[Contact][bar_code]' : {required:'Please enter bar code'}
		},
		showErrors: function(errorMap, errorList) {
			show_errors(this,errorMap,errorList,'right');
		}
	});
}

validate_add_department = function(){
	$("#addForm").validate({
		rules : {
			"data[Department][name]" : {required:true}
		},
		messages : {
			"data[Department][name]" : {required:"Please enter name"}
		},
		showErrors: function(errorMap, errorList) {
			show_errors(this,errorMap,errorList,'right');
		}
	});
}

validate_add_notes = function() { 
	$('#addForm').validate({
		rules : {
			'data[Notes][title]' : {required:true},
			'data[Notes][description]' : {required:true}
		},
		messages : {
			'data[Notes][title]' : {required:'Title is required'},
			'data[Notes][description]' : {required:'Description is required'}
		},
		showErrors: function(errorMap, errorList) {
			show_errors(this,errorMap,errorList,'right');
		}
	});
};

validate_add_flag = function() { 
	$('#addForm').validate({
		rules : {
			'data[Flag][color]' : {required:true},
			'data[Flag][title]' : {required:true}
		},
		messages : {
			'data[Flag][color]' : {required:'Color is required'},
			'data[Flag][title]' : {required:'Title is required'}
		},
		showErrors: function(errorMap, errorList) {
			show_errors(this,errorMap,errorList,'right');
		}
	});
};

validate_add_employee = function(uuid){
	var user_uuid = uuid;
	$('#addEmployee').validate({
		rules : {
			'data[User][fair_category_id]' : {required:true},
			'data[User][department_id]' : {required:true},
			'data[User][first_name]' : {required:true},
			'data[User][last_name]' : {required:true},
			'data[User][password]' : {minlength:6,required:function(user_uuiduser_uuid) {
											if(user_uuid == ''){
												return true;
											}
											return false;
										}
									 },
			'data[User][confirm_password]' : {equalTo:'#password'},
			'data[User][email]' : {required:true,email:true,remote:basePath+'/Users/check/email/'+uuid}
		},
		messages : {
			'data[User][fair_category_id]' : {required:'Fair category is required'},
			'data[User][first_name]' : {required:'First Name is required'},
			'data[User][last_name]' : {required:'Last Name is required'},
			'data[User][email]' : {required:'Email is required',email:'Valid email required',remote:'Email already exists in system'},
			'data[User][password]' : {required:'Password is required'},
		},
		showErrors: function(errorMap, errorList) {
			show_errors(this,errorMap,errorList,'right');
		}
	});
}

validate_add_role = function() {
	jQuery('#addFrom').validate({
		rules : {
			'data[Role][name]' : {required:true}
		},
		messages : {
			'data[Role][name]' : {required:'Name is required'}
		},
		showErrors: function(errorMap, errorList) {
			show_errors(this,errorMap,errorList,'right');
		}
	});
}

validate_add_guestof_form = function(){
	jQuery('#addGuestofForm').validate({ 
		errorClass : 'has-error',
		rules : {
			'data[guestOf][fair_id]' : {required:true},
			'data[guestOf][invite_category_id]' : {required:true},
			'data[guestOf][invites]' : {required:true,number:true},
			'data[guestOf][guest_of]' : {required:true},
		},
		messages : {
			'data[guestOf][fair_id]' : {required:'Please select a fair'},
			'data[guestOf][invite_category_id]' : {required:'Please select a category'},
			'data[guestOf][first_name]' : {required:'Please enter no of invites'},
			'data[guestOf][last_name]' : {required:'Please enter guest of'}
		},
		showErrors: function(errorMap, errorList) {
			show_errors(this,errorMap,errorList,'right');
		}
	});
	return false;
}

validate_add_contact_as_form = function(){
	jQuery('#addGuestofContactForm').validate({ 
		errorClass : 'has-error',
		rules : {
			'data[GuestOf][fair_id]' : {required:true},
			'data[GuestOf][invite_category_id]' : {required:true},
			'data[GuestOf][invites]' : {required:true,number:true},
			'data[GuestOf][list_name]' : {required:true},
			'data[GuestOf][event_id]' : {required:true},
			'data[GuestOf][guest_of]' : {required:true}
		},
		messages : {
			'data[GuestOf][fair_id]' : {required:'Please select a fair'},
			'data[GuestOf][invite_category_id]' : {required:'Please select a category'},
			'data[GuestOf][invites]' : {required:'Please enter no of invites'},
			'data[GuestOf][list_name]' : {required:'Please enter name'},
			'data[GuestOf][guest_of]' : {required:'Please enter name of guest'}
		},
		showErrors: function(errorMap, errorList) {
			show_errors(this,errorMap,errorList,'right');
		}
	});
	return false;
}

validate_add_Template = function(){
	$("#addForm").validate({
		rules : {
			"data[Template][title]" : {required:true},
			"data[Template][type]" : {required:true},
			"data[Template][comments]" : {required:true}			
		},
		messages : {
			"data[Template][title]" : {required:"Please enter title"},
			'data[Template][type]' : {required:'Please select template type'},
			"data[Template][comments]" : {required:"Please enter comments"}
		},
		showErrors: function(errorMap, errorList) {
			show_errors(this,errorMap,errorList,'right');
		}
	});
}

show_errors = function(refer,errorMap,errorList,position){
	$.each(refer.successList, function(index, value) {
		return $(value).popover("hide");
	});
	return $.each(errorList, function(index, value) {
		var _popover;
		_popover = $(value.element).popover({
			trigger: "manual",
			placement: position,
			content: value.message,
			template: "<div class=\"popover error w100p\"><div class=\"arrow\"></div><div class=\"popover-inner\"><div class=\"popover-content\"><p></p></div></div></div>"
		});
		// Bootstrap 3:
		_popover.data("bs.popover").options.content = value.message
		// Bootstrap 2.x:
	  	//_popover.data("popover").options.content = value.message;
	  	return $(value.element).popover("show");
	});
}

toggle_btn = function(){
	if($('input[type="checkbox"].chk-co:checked').length<1){
		$('#write_default').css('display','');
		$('#write_primary').css('display','none');
	}else{
		$('#write_default').css('display','none');
		$('#write_primary').css('display','');
	}
}

validate_item_cat_form = function(){
	jQuery('#addCorpCateg').validate({
		
		errorClass : 'has-error',
		rules : {
			'data[ItemCategory][name]' : {required:true}
		},
		messages : {
			'data[ItemCategory][name]' : {required:'Please enter name'}
		},
		showErrors: function(errorMap, errorList) {
			show_errors(this,errorMap,errorList,'right');
		}
	});
}

validate_item_out_form = function()
{	
	jQuery('#ItemOutForm').validate({
		errorClass : 'has-error',
		rules : {
			'data[InventoryOutItem][item_category_id]' : {required:true},
			'data[InventoryOutItem][qty_out]' : {required:true},
			'data[InventoryOutItem][type]' : {required:true},
			'data[InventoryOutItem][assign_to_id]' : {required:true}
		},
		messages : {
			'data[InventoryOutItem][item_category_id]' : {required:'Please select item category'},
			'data[InventoryOutItem][qty_out]' : {required:'Please enter quantity out'},
			'data[InventoryOutItem][type]' : {required:'Please select type'},
			'data[InventoryOutItem][assign_to_id]' : {required:'Please select employee'}
		},
		showErrors: function(errorMap, errorList) {
			show_errors(this,errorMap,errorList,'right');
		  }
	});
}

showdiv = function(event_type)
{
	if( event_type == 'Fair' )
	{
		$('#div_fair').show();
		$('#div_event').hide();		
	}
	else
	{
		$('#div_event').show();
		$('#div_fair').hide();		
	}
}

loadItems = function()
{	
	url = $('#ItemInForm').attr('forjavascript');
	
	/*
	if($('#chkfair').is(":checked"))
		id = $('#Fair').val();
	else
		id = $('#Events').val();
	*/

	fair_id = $('#Fair').val();
	
	if( $('#Events').val() != 'undefined' && $('#Events').val() != '' )
	{
		event_id = $('#Events').val();
		url += "?fair_id=" + fair_id + "&event_id="+ event_id;
	}
	else
		url += "?fair_id=" + fair_id;
		
	$.get(url,'',function(data){
		$('#itemCategory').empty();
		$('#itemCategory').append( $('<option></option>').val('').html('Please select..') );
		//populating combo box		
		arr = data.split("^");		

		$.each(arr,function(){

			item = this.split("~");
			$('#itemCategory').append(
           		$('<option></option>').val(item[0]).html(item[1])
				)
			
			}); //loop ends 				
		
		});	
		
	//end populating combo box		
}

function loadEvents(called_from)
{		
	url = $('.forjs').attr('forjavascript');
	id = $('#Fair').val();
	
	url += "/FairEvents?fair_id=" + id;	
	
	$('#div_fair_event').show();
	if( called_from != "inventory_out")
		this.loadItems();		
	//else if( called_from != "index_fair" )
	//	this.loadItems_index();		
	
	$.get(url,'',function(data){
		$('#Fair_Event').empty();
		$('#Fair_Event').append( $('<option></option>').val('').html('Please select..') );
		//populating combo box
		arr = data.split("^");		
		
		$.each(arr,function(){
			//console.log(this);
			item = this.split("~");
			$('#Fair_Event').append(
           		$('<option></option>').val(item[0]).html(item[1])
				)
			
			}); //loop ends 				
		
		});	
		
	//end populating combo box		
}


showquantity = function()
{
	$('#qty_out').val('');
	$id = $('#itemCategory').val();
	qty = $id.split("_")[1];
	$('#qty_out').val(qty);
}

validate_item_in_form = function()
{	
	jQuery('#ItemInForm').validate({
		errorClass : 'has-error',
		rules : {
			'data[InventoryOutItem][item_category_id]' : {required:true},
			'data[InventoryOutItem][qty_in]' : {required:true},
			'data[InventoryOutItem][type]' : {required:true},
			'data[InventoryOutItem][received_by]' : {required:true}
		},
		messages : {
			'data[InventoryOutItem][item_category_id]' : {required:'Please select item category'},
			'data[InventoryOutItem][qty_in]' : {required:'Please enter quantity'},
			'data[InventoryOutItem][type]' : {required:'Please select type'},
			'data[InventoryOutItem][received_by]' : {required:'Please select employee'}
		},
		showErrors: function(errorMap, errorList) {
			show_errors(this,errorMap,errorList,'right');
		  }
	});
}

validate_import_contacts = function() {
	$("#importContacts").validate({
		rules : {
			"data[Contact][fair_category_id]" : {required:true},
			"data[Contact][fair_id]" : {required:true}
		},
		showErrors: function(errorMap, errorList) {
			show_errors(this,errorMap,errorList,'right');
	  	}
	});
}
addContact = function(data){
	var html = $("#company_taging").html();
	html = html.replace(/:CID/g,data.company.id);
	html = html.replace(/:CNAME/g,data.company.name);
	html = html.replace(/:CLASS/g,"already_tagged");
	$("#tagged_companies").prepend(html);
};
hideModal = function(selector){
	jQuery(selector).modal("hide");
}