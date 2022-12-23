<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="pull-left">Contact Types</h4>
		<a class="pull-right btn btn-default btn-sm mt5" href="<?php echo $this->base ?>/Fairs/addContactCategory"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp;Add</a>
		<a href="<?php echo $this->base ?>/utils/exportContactTypes"  class="pull-right btn btn-warning btn-sm mr5 mt5"><span class="glyphicon glyphicon-export"></span>&nbsp;Export</a>
		<span class="btn btn-primary btn-sm fileinput-button mr10 pull-right mt5">
			<i class="glyphicon glyphicon-import"></i>
			<span>Import</span>
			<input type="file" id="import_file" name="data[import]">
        </span>
		<a href="<?php echo $this->base ?>/utils/exportContactCharacteristics"  class="pull-right btn btn-warning btn-sm mr5 mt5"><span class="glyphicon glyphicon-export"></span>&nbsp;Export Characteristics</a>
		<div class="clearfix"></div>
	</div>
	<div class="panel-body">
		<ul class="list-group">
		<?php
		if( !empty($contactsCategories) ){
			foreach($contactsCategories as $contactCategory){ 
		?>
        	<li class="list-group-item">
            	<span class="pull-left"><?php echo $contactCategory['ContactCategory']['name']?></span>
                <a href="<?php echo $this->base ?>/Fairs/deleteContactCategory?CCID=<?php echo $contactCategory['ContactCategory']['uuid']; ?>" class="pull-right glyphicon glyphicon-remove" onclick="return confirm('Are you sure?');"></a>
                <a href="<?php echo $this->base ?>/Fairs/addContactCategory?CCID=<?php echo $contactCategory['ContactCategory']['uuid']; ?>" class="pull-right glyphicon glyphicon-pencil mr10"></a>
                <a class="pull-right mr10" href="<?php echo $this->base ?>/Fairs/contactCharacteristics?CID=<?php echo $contactCategory['ContactCategory']['uuid']; ?>">Manage</a>
                <div class="clearfix"></div>
            </li>
		<?php
			}
		}else{
		?>
			<li class="list-group-item">No record found.</li>
		<?php 
		}
		?>
		</ul>
		<?php echo $this->element('pagination_links'); ?>
	</div>
</div>

<?php

$this->Html->script(
	array('file_upload/jquery.iframe-transport','file_upload/vendor/jquery.ui.widget','file_upload/jquery.fileupload'),
	array('block' => 'bottomScript')
);

$this->Html->css(array('file_upload/jquery.fileupload',),array('block' => 'css'));

$script = 'jQuery(document).ready(function(){
	jQuery("#import_file").fileupload({
		url: "'.$this->base.'/utils/importContactCats",
		acceptFileTypes : /(\.|\/)(xls?x)$/i,
		type : "POST",
		done: function (e, data) {
			if(data.result == "error"){
				alert("File extension or file type is not recognized");
			}else{
				window.location = "'.$this->base.'/utils/importContactCats?readFile=1";
			}
        }
    });
});';

$this->Html->scriptBlock($script,array('block' => 'bottomScript'));

?>