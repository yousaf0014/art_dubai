<?php
echo $this->Html->css(array('redmond/jquery-ui-1.10.3.custom.min','nyroModal'),array('block'=>'css'));
echo $this->Html->script(array('jquery.validate.min','jquery-ui-1.10.3.custom.min','jquery.nyroModal.custom.min','fairs'), array('block' => 'script'));

?>


<div class="">
	
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h4 class="pull-left">Inventory Items</h4>
			<a class="pull-right btn btn-default btn-sm mt5" href="<?php echo $this->base ?>/InventoryOutItems/ItemOut">
				<span class="glyphicon glyphicon-plus-sign"></span>&nbsp;Add Inventory Out
			</a>&nbsp;&nbsp;
			<a class="pull-right btn btn-default btn-sm mt5" href="<?php echo $this->base ?>/InventoryOutItems/ItemIn" style="margin-right:10px">
				<span class="glyphicon glyphicon-plus-sign"></span>&nbsp;Add Inventory In
			</a>
			<div class="clearfix"></div>
		</div>
		<div class="panel-body">
			
			<form method="get" action="<?php echo $this->base ?>/InventoryOutItems/index" class="form-horizontal form-search forjs" forjavascript="<?php echo $this->base ?>/InventoryOutItems/EventItems" id="ItemInForm" name="ItemForm" role="form">
				<div class="form-group">
					<label class="col-lg-1 control-label">Fair</label>
					<div class="col-lg-3">
						<select class="form-control input-sm" id="Fair" placeholder="Fair" name="fair_id" onchange="javascript:loadEvents('inventory_in')" style="width:300px;">
								
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
					</div>
				</div>
									
				<div style="display:none;" id="div_fair_event" class="form-group">
					<label class="col-lg-1 control-label">Event</label>
					<div class="col-lg-3">
						<select class="form-control input-sm" id="Events" placeholder="Fair" name="event_id" onchange="javascript:loadItems();" style="width:300px">
							
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
					</div>
				</div>
					
				<div class="form-group">
					<label class="control-label col-lg-1">Item</label>
					<div class="col-lg-3">																				
						<select class="form-control input-sm" id="itemCategory" placeholder="itemCategory" name="item_category_id" style="width:300px;">
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
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-lg-1">Assigned To</label>
					<div class="col-lg-3">
							<select class="form-control input-sm" id="AssignTo" placeholder="AssignTo" name="assign_to_id" style="width:300px;">
								
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
						
						</div>
						<div class="col-lg-3 col-lg-offset-2">
							<input type="radio" id="chkless" name="item_less" value="1" <?php echo @$item_less == '1' ? 'checked' : '' ?>>
								<label for="chkless">Items Received Less</label>
							<input type="radio" name="item_less" id="chkmore" value="2" <?php echo @$item_less == '2' ? 'checked' : '' ?>>
								<label for="chkmore">Items Received More</label>
						
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-offset-7">
							<button type="submit" class="btn btn-success btn-sm">Search</button>&nbsp;&nbsp;
							<a href="<?php echo $this->base ?>/InventoryOutItems/index" class="btn btn-success btn-sm">Clear Search</a>
							<a class="btn btn-warning btn-sm" onclick="javascript:ExportSubmit();" href="#"><span class="glyphicon glyphicon-export"></span>&nbsp;Export</a>
						</div>
					</div>							
			</form>
								
	  		<hr/>
		
			<table border="0" width="100%" class="table table-hover table-striped">
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
	
	function ExportSubmit()
		{					
			form_action = document.ItemForm.action;
			document.ItemForm.action = "<?php echo $this->base ?>/Utils/exportInventory";
			document.ItemForm.submit();
			
			document.ItemForm.action = form_action;
		
		}

</script>