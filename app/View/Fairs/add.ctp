<?php
echo $this->Html->css(array('redmond/jquery-ui-1.10.3.custom.min','nyroModal'),array('block'=>'css'));
echo $this->Html->script(array('jquery.validate.min','jquery-ui-1.10.3.custom.min','fairs'), array('block' => 'script'));
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="pull-left"><?php echo empty($fID) ? 'Add' : 'Edit'; ?> Fair</h4>
		<a class="pull-right btn btn-default btn-sm mt5" href="<?php echo $this->base ?>/Fairs/viewFairs?FCID=<?php echo $fcID; ?>"><span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Go Back</a>
		<div class="clearfix"></div>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" id="addFairForm" role="form" method="post" action="<?php echo $this->base ?>/fairs/add?FID=<?php echo $fID; ?>&FCID=<?php echo $fcID; ?>" enctype="multipart/form-data">
			<div class="col-lg-6">
				<div class="form-group">
					<label for="inputName" class="col-lg-4 control-label">Select Fair:</label>
					<div class="col-lg-7">
						<?php
						if(!empty($fairCategories)) {
							?>
							<select name="data[Fair][fair_category_id]" class="form-control input-sm">
							<?php
							foreach ($fairCategories as $key => $fairCategory) {
								$selected = '';
								if( !empty($fair) && $fair['Fair']['fair_category_id'] == $fairCategory['FairCategory']['id'] ){
									$selected = 'selected="selected"';
								}
							?>
								<option <?php echo $selected; ?> value="<?php echo $fairCategory['FairCategory']['id']; ?>"><?php echo $fairCategory['FairCategory']['name']?></option>
							<?php
							}
							?>
							</select>
						<?php
						}
						?>
					</div>
				</div>
				<div class="form-group">
					<label for="inputName" class="col-lg-4 control-label">Name:</label>
					<div class="col-lg-7">
						<input class="form-control input-sm" id="inputName" placeholder="Name" name="data[Fair][name]" value="<?php echo !empty($fair['Fair']['name']) ? $fair['Fair']['name'] : ''; ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-4 control-label">Year:</label>
					<div class="col-lg-7">
						<select class="form-control input-sm" name="data[Fair][year]">
						<?php
						for($i = 0; $i <= 10; $i++){
							$selectedYear = '';
							$year = $startYear + $i;
							if( !empty($fair) && $fair['Fair']['year'] == $year ){
								$selectedYear = 'selected="selected"';
							}
						?>
							<option <?php echo $selectedYear; ?> value="<?php echo $year; ?>"><?php echo ($startYear+$i); ?></option>
						<?php
						}
						?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-4 control-label">Start Date:</label>
					<div class="col-lg-7">
						<input type="text" id="start_date" class="form-control input-sm" name="data[Fair][start_date]" placeholder="Start Date" value=<?php echo !empty($fair['Fair']['start_date']) ? YMD2MDY($fair['Fair']['start_date'],'/') : ''; ?>>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-4 control-label">Duration:</label>
					<div class="col-lg-3">
						<input class="form-control input-sm" min="1" type="number" name="data[Fair][duration]" placeholder="Duration" value="<?php echo !empty($fair['Fair']['duration']) ? $fair['Fair']['duration'] : ''; ?>">
					</div>
					<div class="col-lg-3">
						<select class="form-control input-sm" name="data[Fair][duration_unit]">
							<?php
							$selected_unit = !empty($fair['Fair']['duration_unit']) ? $fair['Fair']['duration_unit'] : '';
							?>
							<option <?php echo $selected_unit  == 'day' ? 'selected="selected"' : ''; ?> value="day">Day(s)</option>
							<option <?php echo $selected_unit  == 'week' ? 'selected="selected"' : ''; ?> value="week">Week(s)</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-4 control-label">Location:</label>
					<div class="col-lg-7">
						<input class="form-control input-sm" type="text" name="data[Fair][location]" placeholder="Location" value="<?php echo !empty($fair['Fair']['location']) ? $fair['Fair']['location'] : ''; ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-4 control-label">Location Map</label>
					<div class="col-lg-7">
						<input type="file" name="data[Fair][location_map]">
					</div>
				</div>
				<?php
				if( !empty($fair['Fair']['location_map']) && file_exists(WWW_ROOT.$fair['Fair']['location_map']) ){
				?>
				<div class="form-group">
					<label class="col-lg-4 control-label">Previous Map:</label>
					<div class="col-lg-7">
						<img class="img-thumbnail" src="<?php echo $this->webroot.$fair['Fair']['location_map']; ?>">
					</div>
				</div>
				<?php
				}
				?>
				<div class="form-group">
					<label class="col-lg-4 control-label">Description:</label>
					<div class="col-lg-8">
						<textarea class="form-control input-sm" rows="5" name="data[Fair][description]" id="description"><?php echo !empty($fair['Fair']['description']) ? $fair['Fair']['description'] : ''; ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-offset-5">
						<div class="checkbox">
							<label>
								<input name="data[Fair][import_contacts]" value="1" type="checkbox" /> Import Contacts From Previous Fair
							</label>
						</div>
					</div>
					<div class="col-lg-offset-10">
						<button type="submit" class="btn btn-primary btn-sm">Save</button>
					</div>
				</div>
			</div>
			<div class="col-lg-5">
				<input type="hidden" name="data[Fair][lat]" id="lat" value="<?php echo isset($fair['Fair']['lat']) ? $fair['Fair']['lat'] : ''; ?>">
				<input type="hidden" name="data[Fair][lng]" id="lng" value="<?php echo isset($fair['Fair']['lng']) ? $fair['Fair']['lng'] : ''; ?>">
				<div id="map-convas" style="height:580px;">
				</div>
			</div>
			<div class="clearfix"></div>
		</form>
	</div>
</div>
<?php

echo $this->Html->script(array('http://maps.google.com/maps/api/js?sensor=true','ckeditor/ckeditor','ckeditor/adapters/jquery','gmaps'), array('block' => 'script'));

echo $this->Html->scriptStart(array('inline' => false,'block' => 'bottomScript'));

echo '$(document).ready(function(){
		$("#start_date").datepicker({});
		validate_add_fair_form();
		jQuery("#description").ckeditor({
			allowedContent : true
		});
	});';

echo 'var lat = 24.9500;';
echo 'var lng = 55.3333;';

if(!empty($fair['Fair']['lat']) && !empty($fair['Fair']['lng'])) {
	echo 'lat = '.$fair['Fair']['lat'].';';
	echo 'lng ='.$fair['Fair']['lng'].';';
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

	if(!empty($fair['Fair']['lat']) && !empty($fair['Fair']['lng'])) {

		echo 'map.addMarker({
			lat : '.$fair['Fair']['lat'].',
			lng : '.$fair['Fair']['lng'].',
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