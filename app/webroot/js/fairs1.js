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
			'data[ContactCharacteristic][name]' : {required:true}
		},
		messages : {
			'data[ContactCharacteristic][name]' : {required:'Please enter name'}
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
			'data[InviteCategory][name]' : {required:true}
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
			'data[Contact][first_name]' : {required:true},
			'data[Contact][last_name]' : {required:true},
			'data[Contact][city]' : {required:true},
			'data[Contact][address]' : {required:true},
			'data[Contact][email]' : {required:true,email:true}
		},
		messages : {
			'data[Contact][fair_category_id]' : {required:'Please select a category'},
			'data[Contact][fair_id]' : {required:'Please select a fair'},
			'data[Contact][first_name]' : {required:'Please enter first name'},
			'data[Contact][last_name]' : {required:'Please enter last name'},
			'data[Contact][city]' : {required:'please enter city'},
			'data[Contact][address]' : {required:'Please enter address'},
			'data[Contact][email]' : {required:'Please enter email',email:'Valid email required'}
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

validate_add_employee = function(uuid){
	$('#addEmployee').validate({
		rules : {
			'data[User][department_id]' : {required:true},
			'data[User][first_name]' : {required:true},
			'data[User][last_name]' : {required:true},
			'data[User][username]' : {minlength: 4,remote:basePath+'/Users/check/username/'+uuid},
			'data[User][password]' : {minlength:6},
			'data[User][confirm_password]' : {equalTo:'#password'},
			'data[User][email]' : {email:true}
		},
		messages : {
			'data[User][first_name]' : {required:'First Name is required'},
			'data[User][last_name]' : {required:'Last Name is required'},
			'data[User][username]' : {remote:'Username already exists in system'},
			'data[User][email]' : {email:'Valid email required'}
		},
		showErrors: function(errorMap, errorList) {
			show_errors(this,errorMap,errorList,'right');
		}
	});
}

validate_add_role = function() {
	$('#addFrom').validate({
		rules : {
			'data[User][name]' : {required:true}
		},
		messages : {
			'data[User][name]' : {required:'Name is required'}
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