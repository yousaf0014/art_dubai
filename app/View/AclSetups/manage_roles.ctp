
<script>
	var savePermission = function(member_type_name, module, module_id, elem, perm_type)
	{
		var loading_img = '#loading_of_'+ perm_type + '_' + module_id + '_' + member_type_name;
         var getClass = '';
		if($(elem).hasClass("allow"))
		{
			var img_src_big = "<?=$this->webroot?>images/tick_big.gif";
			var img_class = 'deny glyphicon glyphicon-check';
			var img_class_big = 'no zee';
			var img_title = 'allowed';
			getClass = 'allow';
		}else{
			var img_src_big = "<?=$this->webroot?>images/cross_big.png";
			var img_class = 'allow glyphicon glyphicon-remove-circle';
			var img_class_big = 'yes zee';
			var img_title = 'denied';
			getClass = 'deny';
		}
		$(elem).hide();
		$(loading_img).show();

		$.get("<?php echo $this->base?>/acl_setups/setPermissions", {member_type: member_type_name, action: getClass,permission_type: perm_type, module_alias: module}, function (data){
			$(loading_img).hide();
			if(data == ''){
				$(elem).attr('class', img_class).show();
				
				if($(elem).parent().parent().find('span img.allow').length > 3 || $(elem).parent().parent().find('span img.deny').length > 3 ){
				  $(elem).parent().parent().find('div.big_image img').hide();
				  $(elem).parent().parent().find('div.big_image img.zee').attr({src: img_src_big, title: img_title}).attr('class', img_class_big).show();
				  	
		     }
				  
			}else{ 
				$(elem).show();
				alert('Could not change permission! Please try again later.');
			}
		});
	}

	function saveAll(member_type_name, module, module_id, elem, perm_type)
	  {
	         var getClass = '';
			if($(elem).hasClass("yes"))
			{
				var img_src_big = "<?=$this->webroot?>images/tick_big.gif";
				var img_class_big = 'no zee';
				var img_title = 'allowed';
				var img_class_small = 'deny glyphicon glyphicon-check';
				getClass = 'allow';
			}else{
				var img_src_big = "<?=$this->webroot?>images/cross_big.png";
				var img_class_big = 'yes zee';
				var img_title = 'denied';
				var img_class_small = 'allow glyphicon glyphicon-remove-circle';
				getClass = 'deny';
			}
		  $(elem).parent().parent().parent().find('span img').hide();
		  $(elem).parent().parent().parent().find('span img.load').show();
		  
		$.get("<?=$this->base?>/acl_setups/setPermissions", {member_type: member_type_name, action: getClass, permission_type: '*', module_alias: module}, function (data){
			if(data == ''){
			  $(elem).parent().parent().parent().find('span img').removeClass("blue under");
			  $(elem).attr({src: img_src_big, title: img_title}).attr('class', img_class_big).show();
		      $(elem).parent().parent().parent().find('span img.show').attr('class', img_class_small).show();
			  $(elem).parent().parent().parent().find('span img.load').hide();   
			}else{
			$(elem).parent().parent().parent().find('span img.show').show();
			$(elem).show();
			$(elem).parent().parent().parent().find('span img.load').hide();
			alert('Could not change permission! Please try again later.');
			}
		});
	}
		
</script>


<?php
	$totalMemberTypes = count($allMemberTypes);
	if($totalMemberTypes > 4){
		$width = ($totalMemberTypes * 140) + 240;
	}else{
		$width = '860';
	}
?>

<div class="panel panel-primary">
	<div class="panel-heading">
		<?php echo $this->Html->tag('h4','Set Group Permissions'); ?>
	</div>
	<div class="panel-body">
		<form name="groups_select_form" id="GroupsSelectForm" action="<?php echo $this->base?>/acl_setups/manage_group_roles" method="post">
			<table class="table" width="100%" cellspacing="0">
		        <tr>
		            <td>Feature Labels</td>
		            <?php foreach($allMemberTypes as $memTypeId => $typeName){?>
		                <td width="180" align="left">
		                    <div style="margin-left:20px;"><?php echo ucwords(strtolower($typeName)); ?></div>
		                    <div class="VAED_container" style="font-weight:bold; margin-left:20px;">
		                        <div class="pull-left" style="width:10px;" title="View Permission">V </div> 
		                       	<div class="pull-left pl5 pr5">|</div>
		                        <div class="pull-left" style="width:10px;" title="Add Permission">A</div>
		                        <div class="pull-left pl5 pr5">|</div>
		                        <div class="pull-left" style="width:10px;" title="Edit Permission">E</div>
		                        <div class="pull-left pl5 pr5">|</div> 
		                        <div class="pull-left" style="width:10px;" title="Delete Permission">D</div>
		                        <div class="clearfix"></div>
		                    </div>
		                </td>
		            <?php } ?>
		        </tr>
		        
		        <?php
		        
		        $authentication_types = array('read', 'create', 'update', 'delete');
					foreach($perms as $memTypeName => $modulePermInfo){
				?>
		                
		            <tr>
		                <td>
		                    <?php echo (empty($modulePermInfo) ? $memTypeName : '<a class="glyphicon glyphicon-plus"></a>'.$memTypeName)
		                    ?>
		                </td>
		                <?php foreach($allMemberTypes as $memTypeId => $typeName){?>
		                    <td align="center">
		                    	<div class="big_image mr5"  style="float:left;">
		                            <span>
		                                <?php if($modulePermInfo[$typeName]['perms']['all'] == '1'){ ?>
		                                    <a title="allowed" class="no zee glyphicon glyphicon-check"  onclick="saveAll('<?php echo $modulePermInfo[$typeName]['member_type_name']?>', '<?php echo $memTypeName?>', '<?php echo $modulePermInfo[$typeName]['module_id']?>', this, '*')"  ></a>
		                                <?php }else{ ?>
		                                    <a title="denied" class="yes zee glyphicon glyphicon-remove-circle"  onclick="saveAll('<?php echo $modulePermInfo[$typeName]['member_type_name']?>', '<?php echo $memTypeName?>', '<?=$modulePermInfo[$typeName]['module_id']?>', this, '*')"></a>
		                                <?php } ?>
		                            </span>
								</span>
		                        
		                    	<?php foreach($authentication_types as $auth_type){ ?>
		                            <span class="pr5">
		                                <img src="<?php echo $this->base; ?>/img/loading.gif" class="load" border="0" style="display:none"/>
		                                <?php if($modulePermInfo[$typeName]['perms'][$auth_type] == '1'){ ?>
		                                    <a title="allowed" class="glyphicon glyphicon-check deny"  onclick="savePermission('<?php echo $modulePermInfo[$typeName]['member_type_name']?>', '<?php echo $memTypeName; ?>', '<?php echo $modulePermInfo[$typeName]['module_id']?>', this, '<?php echo $auth_type; ?>')"  ></a>
		                                <?php }else{ ?>
		                                    <a title="denied" class="glyphicon glyphicon-remove-circle allow"  onclick="savePermission('<?php echo $modulePermInfo[$typeName]['member_type_name']?>', '<?php echo $memTypeName?>', '<?php echo $modulePermInfo[$typeName]['module_id']?>', this, '<?php echo $auth_type; ?>')" ></a>
		                                <?php } ?>
		                            </span>
		                        <?php } ?>
		                    </td>
		                <?php } ?>
		            </tr>
		        <?php } ?>
		    </table>
		</form>
	</div>
</div>