<?php
echo $this->Html->css(array('redmond/jquery-ui-1.10.3.custom.min','nyroModal'),array('block'=>'css'));
echo $this->Html->script(array('jquery.validate.min','jquery-ui-1.10.3.custom.min','jquery.nyroModal.custom.min','fairs'), array('block' => 'script'));
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="pull-left"><?php echo empty($fairEventID) ? 'Add' : 'Edit'; ?> Event</h4>
		<a class="pull-right btn btn-default btn-sm mt5" href="<?php echo $this->base ?>/Fairs/viewFairs?FCID=<?php echo $fcID; ?>"><span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Go Back</a>
		<div class="clearfix"></div>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" id="addFairEventForm" role="form" method="post" action="<?php echo $this->base ?>/fairs/addEvent?FID=<?php echo $fID; ?>&FCID=<?php echo $fcID; ?>&FEID=<?php echo $fairEventID; ?>" enctype="multipart/form-data">
			<div class="col-lg-6">
				<div class="form-group">
					<label for="inputName" class="col-lg-4 control-label">Name:</label>
					<div class="col-lg-7">
						<input class="form-control input-sm" id="inputName" placeholder="Name" name="data[FairEvent][name]" value="<?php echo !empty($event['FairEvent']['name']) ? $event['FairEvent']['name'] : ''; ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="inputName" class="col-lg-4 control-label">Type:</label>
					<div class="col-lg-7">
						<select class="form-control input-sm" id="inputName" placeholder="Name" name="data[FairEvent][type]">
							<?php
							foreach ($eventTypes as $key => $value) {
								$selected_type = '';
								if(!empty($event) && $event['FairEvent']['type'] == $key ){
									$selected_type = 'selected="selected"';
								}
							?>
							<option <?php echo $selected_type; ?> value="<?php echo $key ?>"><?php echo $value; ?></option>
							<?php
							}
							?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-4 control-label">Start Date:</label>
					<div class="col-lg-7">
						<input type="text" id="start_date" class="form-control input-sm" name="data[FairEvent][start_date]" placeholder="Start Date" value="<?php echo !empty($event['FairEvent']['start_date']) ? YMD2MDY($event['FairEvent']['start_date'],'/') : ''; ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-4 control-label">Duration:</label>
					<div class="col-lg-3">
						<input class="form-control input-sm" min="1" type="number" name="data[FairEvent][duration]" placeholder="Duration" value="<?php echo !empty($event['FairEvent']['duration']) ? $event['FairEvent']['duration'] : ''; ?>">
					</div>
					<div class="col-lg-3">
						<select class="form-control input-sm" name="data[FairEvent][duration_unit]">
							<?php
							$selected_unit = !empty($event['FairEvent']['duration_unit']) ? $event['FairEvent']['duration_unit'] : '';
							?>
							<option <?php echo $selected_unit  == 'day' ? 'selected="selected"' : ''; ?> value="day">Day(s)</option>
							<option <?php echo $selected_unit  == 'week' ? 'selected="selected"' : ''; ?> value="week">Week(s)</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-4 control-label">Location:</label>
					<div class="col-lg-7">
						<input class="form-control input-sm" type="text" name="data[FairEvent][location]" placeholder="Location" value="<?php echo !empty($event['FairEvent']['location']) ? $event['FairEvent']['location'] : ''; ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-4 control-label">Location Map:</label>
					<div class="col-lg-7">
						<input type="file" name="data[FairEvent][location_map]">
					</div>
				</div>
				<?php
				if( !empty($event['FairEvent']['location_map']) && file_exists(WWW_ROOT.$event['FairEvent']['location_map']) ){
				?>
				<div class="form-group">
					<label class="col-lg-4 control-label">Previous Map:</label>
					<div class="col-lg-7">
						<img class="img-thumbnail" src="<?php echo $this->webroot.$event['FairEvent']['location_map']; ?>">
					</div>
				</div>
				<?php
				}
				?>
				<div class="form-group">
					<label class="col-lg-4 control-label">Description:</label>
					<div class="col-lg-8">
						<textarea class="form-control" rows="5" name="data[FairEvent][description]" id="description"><?php echo !empty($event['FairEvent']['description']) ? $event['FairEvent']['description'] : ''; ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-offset-10">
						<button type="submit" class="btn btn-primary btn-sm">Save</button>
					</div>
				</div>
			</div>
			<div class="col-lg-5">
				<input type="hidden" name="data[FairEvent][lat]" id="lat" value="<?php echo isset($event['FairEvent']['lat']) ? $event['FairEvent']['lat'] : ''; ?>">
				<input type="hidden" name="data[FairEvent][lng]" id="lng" value="<?php echo isset($event['FairEvent']['lng']) ? $event['FairEvent']['lng'] : ''; ?>">
				<div id="map-convas" style="height:580px;">
				</div>
			</div>
			<div class="clearfix"></div>
		</form>
	</div>
</div>

<?php

echo $this->Html->script(array('http://maps.google.com/maps/api/js?sensor=true','ckeditor/ckeditor','ckeditor/adapters/jquery','gmaps'), array('block' => 'script'));

echo $this->Html->scriptStart(array('inline' => false, 'block' => 'bottomScript'));
	echo '$(document).ready(function(){
		$("#start_date").datepicker({});
		validate_fair_event_form();
		jQuery("#description").ckeditor({
			allowedContent : true
		});
	});';

	echo 'var lat = 24.9500;';
	echo 'var lng = 55.3333;';

	if(!empty($event['FairEvent']['lat']) && !empty($event['FairEvent']['lng'])) {
		echo 'lat = '.$event['FairEvent']['lat'].';';
		echo 'lng ='.$event['FairEvent']['lng'].';';
	}

	echo '$(document).ready(function(){
			$("#start_date").datepicker({});
			validate_add_fair_form();

			map = new GMaps({
				div: "#map-convas",
				lat: lat,
				lng: lng,
				zoom : 9
			});';

		if(!empty($event['FairEvent']['lat']) && !empty($event['FairEvent']['lng'])) {

			echo 'map.addMarker({
				lat : '.$event['FairEvent']['lat'].',
				lng : '.$event['FairEvent']['lng'].',
			});';

		}
		
	echo	'GMaps.on("click", map.map, function(event) {
		    	var index = map.markers.length;
		    	var lat = event.latLng.lat();
		    	var lng = event.latLng.lng();

		    	jQuery("#lat").val(lat);
		    	jQuery("#lng").val(lng);

		    	map.removeMarkers();

			    map.addMarker({
			      lat: lat,
			      lng: lng,
			    });
		  	});

		});';

echo $this->Html->scriptEnd();

?>