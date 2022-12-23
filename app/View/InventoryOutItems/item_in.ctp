<?php
echo $this->Html->css(array('redmond/jquery-ui-1.10.3.custom.min','nyroModal'),array('block'=>'css'));
echo $this->Html->script(array('jquery.validate.min','jquery-ui-1.10.3.custom.min','jquery.nyroModal.custom.min','fairs'), array('block' => 'script'));
?>
<div class="">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h4 class="pull-left"><?php echo empty($ID) ? 'Add' : 'Edit'; ?> Item In</h4>
			<a class="pull-right btn btn-default btn-sm mt5" href="<?php echo $this->base ?>/InventoryOutItems/index">
				<span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Go Back
			</a>
			<div class="clearfix"></div>
		</div>
		<div class="panel-body">
			<form class="form-horizontal forjs" id="ItemInForm" role="form" method="post" forjavascript="<?php echo $this->base ?>/InventoryOutItems/EventItems" action="<?php echo $this->base ?>/InventoryOutItems/ItemIn?ID=<?php echo !empty($ID) ? $ID : '' ; ?>&invout_id=<?php echo !empty( $inventory_out['InventoryOut']['id']) ? $inventory_out['InventoryOut']['id'] : '' ; ?>" enctype="multipart/form-data">
				
				<div class="form-inline" style="display:none;">
				<label class="col-lg-2 control-label">Type:</label>
				<div class="radio" style="padding-top: 0px; padding-bottom: 10.1px;">
				
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
					<label class="radio" style="margin-left: 4px;">
					<input type="radio" id="chkfair" name="data[InventoryOut][type]" value="Fair" onclick="javascript:showdiv('Fair');" <?php echo $chk; ?> >Fair
					</label>
					
        			<label class="radio" style="margin-left: 6px;">
					<input type="radio" id="chkevent" name="data[InventoryOut][type]" value="Event" onclick="javascript:showdiv('Event');" <?php echo $chk2; ?> >Event
					</label>
					
				</div>
				</div>
				
				<div class="form-group" id="div_fair">
					<label class="col-lg-2 control-label">				
						Fair:
					</label>
				<div class="col-lg-4">
												
						<select class="form-control input-sm" id="Fair" placeholder="Fair" name="data[InventoryOut][fair]" onchange="javascript:loadEvents('inventory_in')" >
							
							<option value="">Please select </option>
							<?php 

							if( !empty($Fairs) ):
							
							foreach($Fairs as $fair): 
							
							//checking to select the category in edit mode..
							if( !empty($inventory_out) )
							{								
								if( $inventory_out['InventoryOut']['type'] == 'fair' )
								{
									if( $fair['Fair']['id'] == $item[0]['InventoryOut']['fair_or_event_id'])
										$selected = "selected='selected'";
									else
										$selected = "";
								}
							}
							
							?>							
							<option value="<?php echo !empty($fair['Fair']['id']) ? $fair['Fair']['id'] : ''; ?>" <?php echo @$selected;?> > 								<?php echo ( !empty($fair['Fair']['name']) ? $fair['Fair']['name'] : '' ); ?>
							</option>
							
							<?php 							
							endforeach; 
							endif;		
							
							?>						
						</select>
				</div>
				</div>
				
				<div class="form-group" style="display:none;" id="div_fair_event">
					<label class="col-lg-2 control-label">Event:</label>
				<div class="col-lg-4">
						<select class="form-control input-sm" id="Events" placeholder="Fair" name="data[InventoryOut][event]" onchange="javascript:loadItems();">
							
							<option value="">Please select </option>
							<?php 
							if( !empty($Events) ):							
							foreach($Events as $event): 							
							
							//checking to select the category in edit mode..
							if( !empty($inventory_out) )
							{
								if( $inventory_out['InventoryOut']['type'] == 'event' )
								{
									if( $event['FairEvent']['id'] == $item[0]['InventoryOut']['fair_or_event_id'] )
										$selected = "selected='selected'";
									else
										$selected = "";
								}
							}
							?>							
							<option value="<?php echo !empty($event['FairEvent']['id']) ? $event['FairEvent']['id'] : ''; ?>" <?php echo @$selected; ?> > 								<?php echo ( !empty($event['FairEvent']['name']) ? $event['FairEvent']['name'] : '' ); ?>
							</option>
							
							<?php 							
							endforeach; 
							endif;						
							
							?>						
						</select>
				</div>
				</div>
				
				<div class="form-group">					
					<label for="inputName" class="col-lg-2 control-label">Item Category:</label>
					<div class="col-lg-4">
						
						<select class="form-control input-sm" id="itemCategory" placeholder="itemCategory" name="data[InventoryOutItem][item_category_id]" onchange="javascript:showquantity()">
							<option value="">Please select </option>
							<?php 
							if( !empty($itemCategories) ):
																									
							foreach($itemCategories as $itemCategory): 
							
							//checking to select the category in edit mode..
							if( $itemCategory['ItemCategory']['id'] == $item[0]['InventoryOutItem']['item_category_id'])
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
						
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-lg-2 control-label">Quantity Out:</label>
					<div class="col-lg-4">					
						<input class="form-control input-sm" id="qty_out" readonly=true value="<?php echo !empty($item[0]['InventoryOutItem']['qty_out']) ? $item[0]['InventoryOutItem']['qty_out'] : ''; ?>" />
					</div>
				</div>

				<div class="form-group">
					<label class="col-lg-2 control-label">Quantity In:</label>
					<div class="col-lg-4">
						<input class="form-control input-sm" name="data[InventoryOutItem][qty_in]" value="<?php echo !empty($item[0]['InventoryOutItem']['qty_in']) ? $item[0]['InventoryOutItem']['qty_in'] : ''; ?>" />
					</div>
				</div>								
				
				<div class="form-group">
					<label class="col-lg-2 control-label">Received By:</label>
				<div class="col-lg-4">
						<select class="form-control input-sm" id="ReceivedBy" placeholder="ReceivedBy" name="data[InventoryOutItem][received_by]">
							
							<option value="">Please select </option>
							<?php 
							if( !empty($Employees) ):
							foreach($Employees as $emp): 
							
							//checking to select the category in edit mode..
							if( $emp['Employee']['id'] == $item[0]['InventoryOutItem']['received_by'])
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
				</div>
				</div>
				
				<div class="form-group">
					<div class="col-lg-offset-5 col-lg-6">
						<button type="submit" class="btn btn-primary btn-sm">Save</button>
					</div>
				</div>
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
		
		validate_item_in_form();
				
	});';		

echo $this->Html->scriptEnd();

?>