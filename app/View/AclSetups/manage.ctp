<?php
	$dropDownSelectedModule = ''
?>
<div class="panel panel-primary">
	<div class="panel-heading">
	<?php
		echo $this->Html->tag('h4','Manage Control/Action Permissions');
	?>
	</div>
	<div class="panel-body">
		<div class="col-lg-6 col-lg-offset-6">
			<form id="search" method="get" action="<?=$this->base?>/AclSetups/manage" class="form-horizontal" role="form"> 
				<div class="form-group">
					<div class="col-lg-5">
						<select  name="controller" class="form-control">
							<option value="">All</option>
							<?php foreach($controllerNamz as $id=>$name){ ?>
							<option value="<?=$name?>" <?php if($controllerSeach == $name){ echo "selected='selected'"; $dropDownSelectedModule = $name;}?> ><?=$name?></option>
							<?php }?>	
						</select>
					</div>
					<div class="col-lg-5">
						<input name="searchText" type="text" value="<?php echo $searchText?>" class="form-control" />
					</div>
					<a class="btn btn-success" href="javascript:;" onclick="$('#search').submit();">Search</a>
				</div>
			</form>
		</div>
		<div class="clearfix"></div>
		<div class="col-lg-12">
			<form id="aclManage" method="post" action="<?=$this->base?>/acl_setups/manage">
	
				<table class="table" cellspacing="0">
			    	<thead>
						<tr class="admin_heading">
							<th width="5%">No.</th>
				            <th width="15%">Controller</th>
							<th width="15%">Method</th>
							<th width="25%">
								<?php
								echo $this->Form->input('Modules', array ( 
											'label' => false, 
											'type' => 'select', 
											'class' => 'form-control input-sm',
											'options' => $moduleList, 
											'onchange' => 'selectModules(this)', 
											'empty' => '--Choose Parent--'
										)
									);
								?>
							</th>
							<th width="7%">
								<div class="checkbox">
									<label>
										<input type="checkbox" onchange="selectAll(this,'create')"/>Create
									</label>
								</div>
							</th>
							<th width="5%">
								<div class="checkbox">
									<label>
										<input type="checkbox" onchange="selectAll(this,'read')"/>Read
									</label>
								</div>
							</th>
							<th width="5%">
								<div class="checkbox">
									<label>
										<input type="checkbox" onchange="selectAll(this,'update')"/>Update
									</label>
								</div>
							</th>
							<th width="5%">
								<div class="checkbox">
									<label>
										<input type="checkbox" onchange="selectAll(this,'delete')"/>Delete
									</label>
								</div>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if(!empty($dataList)){
						$i=0;
						foreach($dataList as $index){
						$class = '';
						if ($i++ % 2 == 0) {
							$class = ' alt-row';
						}
						?>
						<tr class="admin_list <?php echo $class;?>">
							<td align="center"><?php  echo $i; ?></td>
										
							<td><?php echo $index['AppPermission']['controller_name']?></td>
							<td><?php echo $index['AppPermission']['method_name']?></td>
							<td>
								<?php 
								echo $this->Form->input('AppPermission.'.$index['AppPermission']['id'].'.aco_id',  array ( 
										'label' => false, 
										'options' => $moduleList, 
										'selected' => $index['AppPermission']['aco_id'], 
										'class' => 'all_modules form-control input-sm', 
										'empty' => '--Choose Parent--')); 
								?>
							</td>
							<td  style="text-align:left">
								<input type="checkbox" value="1" name="data[AppPermission][<?=$index['AppPermission']['id']?>][_create]" <?php if($index['AppPermission']['_create'] == 1){ echo "checked='checked'" ;}?> class="create"/>
							</td>
							<td  style="text-align:left">	
								<input type="checkbox" value="1" name="data[AppPermission][<?=$index['AppPermission']['id']?>][_read]" <?php if($index['AppPermission']['_read'] == 1){ echo "checked='checked'" ;}?> class="read" />
							</td>
							<td  style="text-align:left">	
								<input type="checkbox" value="1" name="data[AppPermission][<?=$index['AppPermission']['id']?>][_update]" <?php if($index['AppPermission']['_update'] == 1){ echo "checked='checked'" ;}?> class="update" />
							</td>
							<td  style="text-align:left">	
								<input type="checkbox" value="1" name="data[AppPermission][<?=$index['AppPermission']['id']?>][_delete]" <?php if($index['AppPermission']['_delete'] == 1){ echo "checked='checked'" ;}?> class="delete" />
							</td>
						</tr>

						<?php 
						} 
						}else{
						?>
						<tr>
							<td  colspan="7"><?php __sc('no_entry_found')?></td>
						</tr>
					
						<?php } ?>
					</tbody>
				</table>
				<div>
					<input type="submit" value="Update" class="btn btn-primary"/>
					<input name="data[searchText]" type="hidden" value="<?php echo $searchText; ?>" />
					<input name="data[controller]" type="hidden" value="<?php echo $dropDownSelectedModule; ?>" />
				</div>
			</form>
		</div>
	</div>
</div>

<script>
function selectModules(elem){
	value = $(elem).val();
	$("select.all_modules option[value='"+value+"']").attr('selected', 'selected');
}

selectAll = function (elem,clas){
	if($(elem).is(':checked')){
		$('input.'+clas).attr('checked','checked');
	}else{
		$('input.'+clas).removeAttr('checked');
	}
}
</script>