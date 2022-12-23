<?php
echo $this->Html->script(array('bootstrap-multiselect','jquery.validate.min','jquery-ui-1.10.3.custom.min','fairs'),array('block' => 'bottomScript'));
echo $this->Html->css(array('bootstrap-multiselect','font-awesome/css/font-awesome.min'),array('block' => 'css'));
?>
<div class="panel panel-primary">
	<div class="panel-heading">
			<h4 class="pull-left"><?php echo isset($corporateCat['CorporateCategory']['name']) ? $corporateCat['CorporateCategory']['name'] : 'Companies List'; ?></h4>
			<?php if(!empty($cID)) { ?>
			<a href="<?php echo $this->base ?>/Fairs/corporateCategories" class="pull-right btn btn-default btn-sm mt5">
				<span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Go Back
			</a>
			<?php
			}
			if(!empty($companies)) { 
			?>
        <a href="javascript:;" onclick="addContact('<?php echo !empty($cID) ? $cID : ''; ?>');" class="btn btn-default btn-sm mt5 pull-right mr10"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp;Add Contact</a>
        <?php } ?>
        <?php
        $back_url = $this->base . '/Fairs/addCompany';
        if(!empty($corporateCat)){
        	$back_url = $this->base . '/Fairs/addCompany?CID=' . $corporateCat['CorporateCategory']['uuid'];
        }
        ?>
			<a class="pull-right btn btn-default btn-sm mt5 mr10" href="<?php echo $back_url ?>"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp;Add</a>
			<div class="clearfix"></div>
		</div>
  	<div class="panel-body">
  		<form method="post" action="<?php echo $this->base ?>/fairs/viewCompanies<?php echo !empty($cID) ? '?CID='.$cID : ''; ?>" class="form-horizontal form-search" id="search_companies">
  			<div class="col-lg-4">
  				<?php if(empty($corporateCat)) { ?>
  				<div class="form-group">
  					<?php
  					echo $this->Html->tag('label','Select Category',array('class' => 'col-lg-4 control-label'));
  					echo $this->Form->input(null,array(
  								'class'=>'form-control',
  								'empty' => false,
  								'name' => 'corporate_category_id',
  								'id' => 'corporate_category_id',
  								'label' => false,
  								'div' => 'col-lg-6',
  								'type' => 'select',
  								'multiple' => 'multiple',
  								'options' => $corporateCategories
  							)
  						)
  					?>
	  			</div>
	  			<?php } ?>
	  			<div class="form-group">
  					<?php 
  					echo $this->Html->tag('label','Mobile/Phone:',array('class' => 'col-lg-4 control-label'));
  					echo $this->Form->input(null,array(
  								'class'=>'form-control input-sm',
  								'empty' => true,
  								'label' => false,
  								'div' => 'col-lg-6',
  								'type' => 'text',
  								'name' => 'mobile'
  							)
  						)
  					?>
  				</div>
  			</div>
  			<div class="col-lg-4">
  				<div class="form-group">
	  				<?php
	  				echo $this->Html->tag('label','Name',array('class' => 'col-lg-4 control-label'));
  					echo $this->Form->input(null,array(
  								'class'=>'form-control input-sm',
  								'empty' => true,
  								'label' => false,
  								'div' => 'col-lg-6',
  								'type' => 'text',
  								'name' => 'name'
  							)
  						)
  					?>
	  			</div>
  				<div class="form-group">
  					<div class="col-lg-6 col-lg-offset-6">
  						<a href="javascript:;" id="clear_search" class="btn btn-link">Clear</a>
  						<button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-search"></span>&nbsp;Search</button>
  					</div>
  				</div>
  			</div>
  			<div class="col-lg-2">&nbsp;</div>
  			<div class="col-lg-2">
  				<a class="btn btn-warning btn-sm" id="guestofLink" data-target="" onclick="addGuestOf()" href="javascript:void(0)" data-toggle="modal"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp;Guest of</a>
  				<a class="btn btn-warning btn-sm" href="<?php echo $this->base ?>/utils/exportCompanies"><span class="glyphicon glyphicon-export"></span>&nbsp;Export</a>
  				<a href="javascript:;" onclick="printContacts();" class="btn btn-link"><span class="glyphicon glyphicon-print"></span>&nbsp;Print</a>	
  			</div>
  			<div class="clearfix"></div>
  		</form>
  		<hr/>
  		<div class="table-responsive" id="companies_container">
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
			<table class="table table-hover table-striped">
				<thead>
					<tr>
						<th width="2%"></th>
						<th width="3%">No</th>
						<?php
						
						$sortKey = $this->Paginator->sortKey('Company');
						$sortDir = $this->Paginator->sortDir('Company');
						
						if(!empty($viewFields)) {
							foreach ($viewFields as $key => $value) {
						?>
						<th>
							<?php 
							echo $this->Paginator->sort((String)$key,ucfirst(str_replace('_', ' ', $value)),array('class' => 'ajax_sort'));;

							if($sortKey == $key) {
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
						?>
						<?php }else{ ?>
						<th width="12%">
							<?php 
							
							echo $this->Paginator->sort('Company.name','Name',array('class' => 'ajax_sort'));

							if($sortKey == 'name') {
								if($sortDir == 'desc'){
									echo '<i class="fa fa-caret-square-o-down ml5"></i>';
								}elseif($sortDir == 'asc'){
									echo '<i class="fa fa-caret-square-o-up ml5"></i>';
								}
							}

							?>
						</th>
						<th>Address</th>
						<th width="8%">
							<?php 

							echo $this->Paginator->sort('Company.city','City',array('class' => 'ajax_sort'));

							if($sortKey == 'city') {
								if($sortDir == 'desc'){
									echo '<i class="fa fa-caret-square-o-down ml5"></i>';
								}elseif($sortDir == 'asc'){
									echo '<i class="fa fa-caret-square-o-up ml5"></i>';
								}
							}

							?>
						</th>
						<th width="12%">
							<?php 

							echo $this->Paginator->sort('Country.nicename','Country',array('class' => 'ajax_sort'));

							if($sortKey == 'nicename') {
								if($sortDir == 'desc'){
									echo '<i class="fa fa-caret-square-o-down ml5"></i>';
								}elseif($sortDir == 'asc'){
									echo '<i class="fa fa-caret-square-o-up ml5"></i>';
								}
							}

							?>
						</th>
						<th width="8%">Phone</th>
						<th width="8%">Fax</th>
						<th width="8%">Email</th>
						<th width="8%">Website</th>
						<?php } ?>
						<th width="7%" class="text-center">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
					
					$page = $this->Paginator->param('page');
					$limit = $this->Paginator->param('limit');
					$pages = $this->Paginator->param('pages');

					if( !empty( $companies) ) {
						$counter = ($page - 1) * $limit;
						foreach ($companies as $index => $company) {
					?>
					<tr>
						<td><input class="companies_chk" type="checkbox" value="<?php echo $company['Company']['id']; ?>" /></td>
						<td><?php echo ++$counter; ?></td>
						<?php
						if(!empty($viewFields)) {
							foreach ($viewFields as $key => $value) {
						?>
						<td>
						<?php
								if($key == 'created_by'){
									echo ucfirst($company['CreatedBy']['first_name'].' '.$company['CreatedBy']['last_name']); 
								}
								elseif ($key == 'updated_by') {
									echo ucfirst($company['UpdatedBy']['first_name'].' '.$company['UpdatedBy']['last_name']);
								}
								elseif($key == 'created' || $key == 'updated'){
									echo YMD2MDY($company['Company'][$key],'/');
								}
								elseif($key == 'country') {
									echo $company['Country']['nicename'];
								}else{
									echo ucfirst($company['Company'][$key]);
								}
						?>
						</td>
						<?php
							}
						}else{ 

						?>
						<td><?php echo ucwords($company['Company']['name']); ?></td>
						<td><?php echo $company['Company']['address']; ?></td>
						<td><?php echo $company['Company']['city']; ?></td>
						<td><?php echo $company['Country']['nicename']; ?></td>
						<td><?php echo $company['Company']['phone']; ?></td>
						<td><?php echo $company['Company']['fax']; ?></td>
						<td><?php echo $company['Company']['email']; ?></td>
						<td><?php echo $company['Company']['website']; ?></td>
						<?php } ?>
						<td class="text-center">
							<a class="mr5 glyphicon glyphicon-eye-open" href="<?php echo $this->base ?>/fairs/viewCompany?COID=<?php echo $company['Company']['uuid']; ?>" title="View Details"></a>
							<a href="<?php echo $this->base ?>/Fairs/addCompany?COID=<?php echo $company['Company']['uuid']; ?>&CID=<?php echo $cID ?>" class="glyphicon glyphicon-pencil mr5" title="Edit"></a>
							<a href="<?php echo $this->base ?>/Fairs/deleteCompany?COID=<?php echo $company['Company']['uuid']; ?>" class="glyphicon glyphicon-remove" onclick="return confirm('Are you sure?')" title="Delete"></a>
						</td>
					</tr>
					<?php
						}
					}else{
					?>
					<tr>
						<td colspan="7">No record found.</td>
					</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
		<?php if($pages > 1) { ?>
		<div class="col-lg-6">
			<ul class="pagination">
				<?php echo $this->Paginator->numbers(array('tag' => 'li','separator' => '','currentClass' => 'active','currentTag' => 'a', 'class' => 'ajax_sort' )); ?>
			</ul>
		</div>
		<?php } ?>
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
$code = 'jQuery(document).on("submit","#search_companies",function(event) {
	event.preventDefault();
	searchCompanies();
});

jQuery(document).on("click","#clear_search",function(event){
	event.preventDefault();
	clearSearch();
});

jQuery(document).on("click","a.ajax_sort,li.ajx_pagination a",function(event) {
	event.preventDefault();
	loadCompanies(this);
});
';

$code .= 'clearSearch = function(){
	jQuery("#search_companies")[0].reset();
	jQuery.ajax({
		url : basePath + "/fairs/viewCompanies"
	}).done(function(data){
		jQuery("#companies_container").html($(data).find("#companies_container").html());
		multiselect_deselectAll(jQuery("#corporate_category_id"));
	});
};
loadCompanies = function(elem) {
	jQuery.ajax({
		url : jQuery(elem).attr("href")
	}).done(function(data){
		jQuery("#companies_container").html($(data).find("#companies_container").html());
	});
}
';

$code .= 'searchCompanies = function(){
	jQuery.ajax({
		url : basePath + "/fairs/viewCompanies?"+jQuery("#search_companies").serialize()
	}).done(function(data){
		jQuery("#companies_container").html($(data).find("#companies_container").html());
	})
};

function multiselect_deselectAll($el) {
		$("option", $el).each(function(element) {
		$el.multiselect("deselect", $(this).val());
	});
};
';

$code .= '$(document).ready(function(){
	$("#corporate_category_id").multiselect({
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
});';
$code .= "addContact = function(corporateCatID) {
	if($('input[type=\"checkbox\"].companies_chk:checked').length<1) {
		alert('Please select at least one compnay');
		return false;
	}
	var companyIDs = '';
	$('input[type=\"checkbox\"].companies_chk:checked').each(function(){
		companyIDs += this.value+',';
	});
	window.location = basePath+'/Fairs/addContact?FROM=Companies&CID='+corporateCatID+'&cids='+companyIDs;
};";

$code .= 'function addGuestOf(){
	if($("input[type=\'checkbox\'].companies_chk:checked").length<1) {
		alert("Please select at least one compnay");
		return false;
	}
	var companyIDs = "";
	jQuery("input[type=\'checkbox\'].companies_chk:checked").each(function(){
		companyIDs += this.value+",";
	});
	
	$("#guestofLink").attr("href",basePath + "/fairs/addGuestOf?companyIds="+companyIDs);
	$("#guestofLink").attr("data-target","#myModal");
		
	return false;
}';
echo $this->Html->scriptBlock($code,array('inline' => false,'block' => 'bottomScript'));
?>