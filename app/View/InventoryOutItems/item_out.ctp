<?php
echo $this->Html->css(array('redmond/jquery-ui-1.10.3.custom.min','nyroModal'),array('block'=>'css'));
echo $this->Html->script(array('jquery.validate.min','jquery-ui-1.10.3.custom.min','jquery.nyroModal.custom.min','fairs'), array('block' => 'script'));
?>
<div class="">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h4 class="pull-left"><?php echo empty($ID) ? 'Add' : 'Edit'; ?> Item Out</h4>
			<a class="pull-right btn btn-default btn-sm mt5" href="<?php echo $this->base ?>/InventoryOutItems/index">
				<span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Go Back
			</a>
			<div class="clearfix"></div>
		</div>
		<div class="panel-body">
		
			<form class="form-horizontal forjs" id="ItemOutForm" role="form" forjavascript="<?php echo $this->base ?>/InventoryOutItems/FairEvents" method="post" action="<?php echo $this->base ?>/InventoryOutItems/ItemOut?ID=<?php echo !empty($ID) ? $ID : '' ; ?>&invout_id=<?php echo !empty( $inventory_out['InventoryOut']['id']) ? $inventory_out['InventoryOut']['id'] : '' ; ?>" enctype="multipart/form-data">
			
			<table width="100%" cellspacing="0" cellpadding="0" border="0">
			<tr>
				<td align="right" width="15%" valign="top"><label class="control-label">Item Category</label></td>
				<td style="padding-left: 15px;">
					<select class="form-control input-sm" id="itemCategory" placeholder="itemCategory" name="data[InventoryOutItem][item_category_id]" style="width: 300px;">
							<option value="">Please select </option>
							<?php 
							if( !empty($itemCategories) ):
							foreach($itemCategories as $itemCategory): 
							
							//checking to select the category in edit mode..
							if( $itemCategory['ItemCategory']['id'] == $item['InventoryOutItem']['item_category_id'])
								$selected = "selected='selected'";
							else
								$selected = "";
							
							?>
							
							<option value="<?php echo !empty($itemCategory['ItemCategory']['id']) ? $itemCategory['ItemCategory']['id'] : ''; ?>" <?php echo $selected; ?>> 
							<?php echo ( !empty($itemCategory['ItemCategory']['name']) ? $itemCategory['ItemCategory']['name'] : '' ); ?>
							
							</option>
							
							<?php 							
							endforeach; 
							endif;						
							
							?>						
						</select>
				</td>
			</tr>
			
			<tr>
				<td align="right"><label class="control-label">Quantity</label></td>
				<td style="padding-left: 15px;">
					<input style="width: 300px;margin-top:6px;" class="form-control input-sm" name="data[InventoryOutItem][qty_out]" value="<?php echo !empty($item['InventoryOutItem']['qty_out']) ? $item['InventoryOutItem']['qty_out'] : ''; ?>" />	
				</td>
			</tr>
			
			<tr style="display:none;">
				<td align="right"><label>Type</label></td>
				
				<td style="padding-left: 15px;">
				
					<?php
						 if( !empty( $inventory_out ) )
						 	$chk = $inventory_out['InventoryOut']['type'] == 'fair' ? 'checked' : '';
						else
							$chk = '';
						
						if( !empty( $inventory_out ) )
						 	$chk2 = $inventory_out['InventoryOut']['type'] == 'event' ? 'checked' : '';
						else
							$chk2 = '';
					?>
					
					<label>	
					<input style="margin-top:6px;" type="radio" id="chkfair" name="data[InventoryOut][type]" value="Fair" onclick="javascript:showdiv('Fair');" <?php echo $chk; ?> >Fair	</label>
					
					<label>			
					<input type="radio" id="chkevent" name="data[InventoryOut][type]" value="Event" onclick="javascript:showdiv('Event');" <?php echo $chk2; ?> >Event	</label>
					
				</td>
			</tr>
			</table>
			
			<div class="form-group" style="display:block;" id="div_fair">
			<table width="100%" cellpadding="0" cellspacing="0">			
			<tr>
				<td colspan="2">&nbsp;</td>				
			</tr>
			<tr>
				<td width="15%" align="right" valign="top"><label class="control-label">Fair</label></td>
				<td style="padding-left: 15px;">					
				<div class="col-lg-4">
						<select class="form-control input-sm" id="Fair" placeholder="Fair" name="data[InventoryOut][fair_id]" onchange="javascript:loadEvents('inventory_out')" style="padding-top: 6px; width: 300px; padding-left: 12px; margin-left: -4px;">
							
							<option value="">Please select </option>
							<?php 
							if( !empty($Fairs) ):
							foreach($Fairs as $fair): 
							
							//checking to select the category in edit mode..
							if( !empty($inventory_out) )
							{
								if( $inventory_out['InventoryOut']['type'] == 'fair' )
								{
									if( $fair['Fair']['id'] == $item['InventoryOut']['fair_or_event_id'])
										$selected = "selected='selected'";
									else
										$selected = "";
								}
							}
							
							?>							
							<option value="<?php echo !empty($fair['Fair']['id']) ? $fair['Fair']['id'] : ''; ?>" <?php echo $selected;?> > 								<?php echo ( !empty($fair['Fair']['name']) ? $fair['Fair']['name'] : '' ); ?>
							</option>
							
							<?php 							
							endforeach; 
							endif;		
							
							?>						
						</select>
				</div>
				</td>
			</tr>							
							
			</table>
			</div>
		
			
			<div class="form-group" id="div_fair_event" style="display:none;">
			<table width="100%" cellpadding="0" cellspacing="0">			
			<tr>
				<td width="15%" align="right" valign="top"><label class="control-label">Event</label></td>
				<td style="padding-left: 15px;">					
				<div class="col-lg-4">
						<select class="form-control input-sm" id="Fair_Event" placeholder="Fair" name="data[InventoryOut][event_id]" style="padding-top: 6px; width: 300px; padding-left: 12px; margin-left: -4px;">
							
							<option value="">Please select </option>
							<?php 
							if( !empty($Fairs) ):
							foreach($Fairs as $fair): 
							
							//checking to select the category in edit mode..
							if( !empty($inventory_out) )
							{
								if( $inventory_out['InventoryOut']['type'] == 'fair' )
								{
									if( $fair['Fair']['id'] == $item['InventoryOut']['fair_or_event_id'])
										$selected = "selected='selected'";
									else
										$selected = "";
								}
							}
							
							?>							
							<option value="<?php echo !empty($fair['Fair']['id']) ? $fair['Fair']['id'] : ''; ?>" <?php echo $selected;?> > 								<?php echo ( !empty($fair['Fair']['name']) ? $fair['Fair']['name'] : '' ); ?>
							</option>
							
							<?php 							
							endforeach; 
							endif;		
							
							?>						
						</select>
				</div>
				</td>
			</tr>							
							
			</table>
			</div>
			
			<div class="form-group" style="display:none;" id="div_event">
			<table width="100%" cellpadding="0" cellspacing="0">
			<tr>
				<td width="15%" align="right" valign="top"><label class="control-label">Event</label></td>
				<td style="padding-left: 23px;">
					<select class="form-control input-sm" id="Events" placeholder="Fair" name="data[InventoryOut][event_id_old]" style="width: 300px;">
							
							<option value="">Please select </option>
							<?php 
							if( !empty($Events) ):							
							foreach($Events as $event): 							
							
							//checking to select the category in edit mode..
							if( !empty($inventory_out) )
							{
								if( $inventory_out['InventoryOut']['type'] == 'event' )
								{
									if( $event['FairEvent']['id'] == $item['InventoryOut']['fair_or_event_id'] )
										$selected = "selected='selected'";
									else
										$selected = "";
								}
							}
							?>
							
							<option value="<?php echo !empty($event['FairEvent']['id']) ? $event['FairEvent']['id'] : ''; ?>" <?php echo $selected; ?> > 								<?php echo ( !empty($event['FairEvent']['name']) ? $event['FairEvent']['name'] : '' ); ?>
							</option>
							
							<?php 							
							endforeach; 
							endif;						
							
							?>						
						</select>
				
				</td>
			</tr>
			</table>
			</div>
			
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td align="right" width="15%" valign="top"><label class="control-label">Assign To</label></td>
				<td style="padding-left: 15px;">
					<select class="form-control input-sm" id="AssignTo" placeholder="AssignTo" name="data[InventoryOutItem][assign_to_id]" style="width: 300px;">
							
							<option value="">Please select </option>
							<?php 
							if( !empty($Employees) ):
							foreach($Employees as $emp): 
							
							//checking to select the category in edit mode..
							if( $emp['Employee']['id'] == $item['InventoryOutItem']['assign_to_id'])
								$selected = "selected='selected'";
							else
								$selected = "";							
							
							?>							
							<option value="<?php echo !empty($emp['Employee']['id']) ? $emp['Employee']['id'] : ''; ?>" <?php echo $selected; ?> > 								<?php echo ( !empty($emp['Employee']['first_name']) ? $emp['Employee']['first_name'] . " " . $emp['Employee']['last_name'] : '' ); ?>
							</option>
							
							<?php 							
							endforeach; 
							endif;						
							
							?>						
						</select>
				</td>
			</tr>
			
			<tr><td colspan="2">&nbsp;</td></tr>
			<tr>
				<td>&nbsp;</td>
				<td width="20%" align="right"><button type="submit" class="btn btn-primary btn-sm">Save</button></td>
				<td>&nbsp;</td>
			</tr>
			
			</table>
			
			</form>
		</div>		
	</div>
</div>
<?php

echo $this->Html->scriptStart(array('inline' => false,'block' => 'bottomScript'));

echo '$(document).ready(function(){						
		
		/*
		if( $("#chkfair").is(":checked") )
			$("#div_fair").show();
		
		if( $("#chkevent").is(":checked") )
			$("#div_event").show();
		*/
		
		validate_item_out_form();
	});';		

echo $this->Html->scriptEnd();

?>