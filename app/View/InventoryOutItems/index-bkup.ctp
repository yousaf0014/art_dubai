<?php
echo $this->Html->css(array('redmond/jquery-ui-1.10.3.custom.min','nyroModal'),array('block'=>'css'));
echo $this->Html->script(array('jquery.validate.min','jquery-ui-1.10.3.custom.min','jquery.nyroModal.custom.min','fairs'), array('block' => 'script'));

?>


<div class="row">
	
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h4 class="pull-left">Inventory Items</h4>
			<a class="pull-right btn btn-default" href="<?php echo $this->base ?>/InventoryOutItems/ItemOut">Add Inventory Out</a>&nbsp;&nbsp;
			<a class="pull-right btn btn-default" href="<?php echo $this->base ?>/InventoryOutItems/ItemIn" style="margin-right:10px">Add Inventory In</a>
			<div class="clearfix"></div>
		</div>
		<div class="panel-body">
			
			<form method="get" action="<?php echo $this->base ?>/InventoryOutItems/index" class="form-horizontal forjs" forjavascript="<?php echo $this->base ?>/InventoryOutItems/EventItems" id="ItemInForm">
			<table border="0" width="100%">
				<tr>
					<td width="1%">Fair</td>
					<td width="10%" colspan="2" style="padding-left: 17px;">
					
						<select class="form-control" id="Fair" placeholder="Fair" name="fair_id" onchange="javascript:loadEvents('inventory_in')" style="width:300px;">
							
							<option value="">Please select </option>
							<?php 

							
							if( !empty($Fairs) ):
							
							foreach($Fairs as $fair): 
							
							//checking to select the category in edit mode..

							if( $fair['Fair']['id'] == $fair_id)
								$selected = "selected='selected'";
							else
								$selected = "";
							
							?>							
							<option value="<?php echo !empty($fair['Fair']['id']) ? $fair['Fair']['id'] : ''; ?>" <?php echo @$selected;?> > 								<?php echo ( !empty($fair['Fair']['name']) ? $fair['Fair']['name'] : '' ); ?>
							</option>
							
							<?php 							
							endforeach; 
							endif;		
							
							?>						
						</select>
																
					</td>
				</tr>				
				</table>
								
				<div style="display:none;" id="div_fair_event">

				<table border="0">
				<tr>
					<td width="1%">Event</td>
					<td width="10%" colspan="2" style="padding-left: 8px;">
												
						<select class="form-control" id="Events" placeholder="Fair" name="event_id" onchange="javascript:loadItems();" style="width:300px">
							
							<option value="">Please select </option>
							<?php 
							if( !empty($Events) ):							
							foreach($Events as $event): 							
							
							//checking to select the category in edit mode..
							$selected = '';
							if( !empty( $event_id ))
							{
								if( $event['FairEvent']['id'] == $event_id )
									$selected = "selected='selected'";
							}
							?>							
							<option value="<?php echo !empty($event['FairEvent']['id']) ? $event['FairEvent']['id'] : ''; ?>" <?php echo @$selected; ?> > 								<?php echo ( !empty($event['FairEvent']['name']) ? $event['FairEvent']['name'] : '' ); ?>
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
				
				<table border="0" width="100%">
				<tr>
					<td width="8%">Item</td>
					<td style="padding-left: 22px;">																					
						<select class="form-control" id="itemCategory" placeholder="itemCategory" name="item_category_id" style="width:300px;">
							<option value="">Please select </option>
							<?php 
							if( !empty($itemCategories) ):
							foreach($itemCategories as $itemCategory): 
							
							//checking to select the category in edit mode..
							if( $itemCategory['ItemCategory']['id'] == $item_category_id)
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
					<td>Assigned To</td>
					<td style="padding-left: 22px;">
					
						<select class="form-control" id="AssignTo" placeholder="AssignTo" name="assign_to_id" style="width:300px;">
							
							<option value="">Please select </option>
							<?php 
							if( !empty($Employees) ):
							foreach($Employees as $emp): 
							
							//checking to select the category in edit mode..
							if( $emp['Employee']['id'] == $assign_to_id)
								$selected = "selected='selected'";
							else
								$selected = "";							
							
							?>							
							<option value="<?php echo !empty($emp['Employee']['id']) ? $emp['Employee']['id'] : ''; ?>" <?php echo $selected; ?> ><?php echo ( !empty($emp['Employee']['first_name']) ? $emp['Employee']['first_name'] . " " . $emp['Employee']['last_name'] : '' ); ?>
							</option>
							
							<?php 							
							endforeach; 
							endif;						
							
							?>						
						</select>
					
					</td>
					<td>
					
						<input type="radio" id="chkless" name="item_less" value="1" <?php echo @$item_less == '1' ? 'checked' : '' ?>>
							<label for="chkless">Items Received Less</label>
						<input type="radio" name="item_less" id="chkmore" value="2" <?php echo @$item_less == '2' ? 'checked' : '' ?>>
							<label for="chkmore">Items Received More</label>
					
					</td>
				</tr>
				<tr>
					<td colspan="3" align="right">
						<button type="submit" class="btn btn-success">Search</button>&nbsp;&nbsp;
						<a href="<?php echo $this->base ?>/InventoryOutItems/index" class="btn btn-success">Clear Search</a>
					</td>
				</tr>
						
			</table>							
			</form>
								
	  		<hr/>
		
			<table border="0" width="100%">
				<tr>
					<th>Item</th>					
					<th>Qty Out</th>
					<th>Qty In</th>
					<th>Assigned To</th>
					<th>Assigned Date</th>
					<th>Received Date</th>
				</tr>

				<?php
                if( !empty($Items) ){
					
                    foreach($Items as $item){ 
				?>
					<tr>
						<td> <?php echo @$item['ItemCategory']['name']?> </td>
						<td> <?php echo @$item['InventoryOutItem']['qty_out']?> </td>
						<td> <?php echo @$item['InventoryOutItem']['qty_in']?> </td>
						<td> <?php echo @$item['Employee']['first_name'] . " " . @$item['Employee']['last_name']?> </td>
						<td> <?php echo @$item['InventoryOutItem']['assigned_date']?> </td>
						<td> <?php echo @$item['InventoryOutItem']['received_date']?> </td>
					</tr>
				<?php
                	}
                }else{
				?>
                	<tr><td>No record found.</td></tr>
                <?php 
                }
                ?>

			</table>
		</div>

	</div>	
	
</div>

<table width="100%">
	<tr>
		<td width="10%">
			<?php echo $this->Paginator->counter(); ?>					
		</td>
		<td align="right">
			<?php
			
			$item_category_id = isset($item_category_id) ? $item_category_id : '';
			$chk_type = isset($chk_type) ? $chk_type : '';
			$fair_id = isset($fair_id) ? $fair_id : '';
			$event_id = isset($event_id) ? $event_id : '';
			$assign_to_id = isset($assign_to_id) ? $assign_to_id : '';
			$item_less = isset($item_less) ? $item_less : '';						
			
			$pagingUrl = array(
								'separator' =>" "								
							   );
		?>
			<?php echo $this->Paginator->numbers($pagingUrl);?>
		</td>
	</tr>
</table>


<script type="text/javascript" language="javascript">
	$(document).ready(function(){		
		
		if( $('#Fair').val() != '' )
			$("#div_fair_event").show();

		/*
		if( $("#chkfair").is(":checked") )
			$("#div_fair").show();

		if( $("#chkevent").is(":checked") )
			$("#div_event").show();
		*/		
				
	});

</script>