<?php
echo $this->Html->css(array('redmond/jquery-ui-1.10.3.custom.min','nyroModal'),array('block'=>'css'));
echo $this->Html->script(array('jquery.validate.min','jquery-ui-1.10.3.custom.min','jquery.nyroModal.custom.min','fairs'), array('block' => 'script'));
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="pull-left">Manage Contact Documents</h4>
		<a class="pull-right btn btn-default btn-sm mt5" href="<?php echo $this->base ?>/fairs/contacts">
			<span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Go Back
		</a>
		<div class="clearfix"></div>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" id="addCorpCateg" role="form" method="post" action="<?php echo $this->base ?>/Fairs/addContactDocuments?CID=<?php echo (!empty($cID) ? $cID : ''); ?>&contact_uuid=<?php echo (!empty($contact_uuid) ? $contact_uuid : ''); ?>&FID=<?php echo (!empty($FID) ? $FID : ''); ?>" enctype="multipart/form-data">
			
			<div class="form-group">
				<label for="inputName" class="col-lg-2 control-label">Title:</label>
				<div class="col-lg-4">
					<input class="form-control input-sm" id="inputName" placeholder="Name" name="data[ContactDocument][title]" />
				</div>
			</div>
			
			<div class="form-group">
				<label for="inputName2" class="col-lg-2 control-label">Attachment 1:</label>
				<div class="col-lg-4">
					<input class="" id="inputName" placeholder="Name" name="data[ContactDocument][attachment1]" type="file" />
				</div>
			</div>		
			
			<div class="form-group">
				<label for="inputName3" class="col-lg-2 control-label">Attachment 2:</label>
				<div class="col-lg-4">
					<input class="" id="inputName" placeholder="Name" name="data[ContactDocument][attachment2]" type="file" />
				</div>
			</div>		
			
			<div class="form-group">
				<label for="inputName3" class="col-lg-2 control-label">Attachment 3:</label>
				<div class="col-lg-4">
					<input class="" id="inputName" placeholder="Name" name="data[ContactDocument][attachment3]" type="file" />
				</div>
			</div>		
			
			<div class="form-group">
				<label for="inputName4" class="col-lg-2 control-label">Attachment 4:</label>
				<div class="col-lg-4">
					<input class="" id="inputName" placeholder="Name" name="data[ContactDocument][attachment4]" type="file" />
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
	
<div class="panel panel-default">
	<div class="panel-heading">
		<h4 class="pull-left">Uploaded Documents</h4>			
		<div class="clearfix"></div>
	</div>
	<div class="panel-body">
		<table width="100%">
			
			<tr>
			<?php 				
				//Showing titles first in one row
				$count = count( $all_images );
				foreach($all_images as $title):
			?>
				<td>
					<?=$title['ContactDocument']['title']?><br />
					<?php
						$contact_id = !empty($title['ContactDocument']['title']) ? $title['ContactDocument']['id'] : '';
					?>
					<span style='font-size:10px;'><a href="<?php echo $this->base ?>/Fairs/deleteContactDocuments?CID=<?php echo (!empty($contact_id) ? $contact_id : ''); ?>">Delete</a></span>
				</td>
			<?php endforeach; ?>
			</tr>								
			
			<tr>
				<td colspan="<?=$count?>"><hr /></td>
			</tr>
											
			<tr>
			<?php 				
				//Showing image first in one row
				foreach($all_images as $title):
				$img1 = '..'.DS.'app'.DS.WEBROOT_DIR.DS."upload".DS.$title['ContactDocument']['attachment1'];					
			?>
				<td>						
					<img src="<?=$img1; ?>" width="80" height="80" />
				</td>
			<?php endforeach; ?>
			</tr>
			
			<tr>
			<?php 				
				//Showing image first in one row
				foreach($all_images as $title):
				$img2 = '..'.DS.'app'.DS.WEBROOT_DIR.DS."upload".DS.$title['ContactDocument']['attachment2'];
			?>
				<td><img src="<?=$img2; ?>" width="80" height="80" /></td>
			<?php endforeach; ?>
			</tr>
			
			<tr>
			<?php 				
				//Showing image first in one row
				foreach($all_images as $title):
				$img3 = '..'.DS.'app'.DS.WEBROOT_DIR.DS."upload".DS.$title['ContactDocument']['attachment3'];	
			?>
				<td><img src="<?=$img3; ?>" width="80" height="80" /></td>
			<?php endforeach; ?>
			</tr>
			
			<tr>
			<?php 				
				//Showing image first in one row
				foreach($all_images as $title):
				$img4 = '..'.DS.'app'.DS.WEBROOT_DIR.DS."upload".DS.$title['ContactDocument']['attachment4'];	
			?>
				<td><img src="<?=$img4; ?>" width="80" height="80" /></td>
			<?php endforeach; ?>
			</tr>
			
		</table>
	</div>
</div>

<?php

echo $this->Html->scriptStart(array('inline' => false,'block' => 'bottomScript'));

echo '$(document).ready(function(){
		//validate_corp_cat_form();
	});';

echo $this->Html->scriptEnd();

?>