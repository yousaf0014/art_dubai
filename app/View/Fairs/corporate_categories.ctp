<div class="panel panel-primary">
	<div class="panel-heading">
    	<h4 class="pull-left">Corporate Categories</h4>
        <a class="btn btn-default pull-right btn-sm mt5" href="<?php echo $this->base ?>/Fairs/addCorporateCategory"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp;Add</a>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
    	<ul class="list-group">
		<?php
        if( !empty($corporateCategories) ){
            foreach($corporateCategories as $corporateCategory){ 
		?>
			<li class="list-group-item">
				<span class="pull-left"><?php echo $corporateCategory['CorporateCategory']['name']?></span>
				<a href="<?php echo $this->base ?>/Fairs/deleteCorporateCategory?CID=<?php echo $corporateCategory['CorporateCategory']['uuid']; ?>" class="pull-right glyphicon glyphicon-remove" onclick="return confirm('Are you sure?');"></a>
				<a href="<?php echo $this->base ?>/Fairs/addCorporateCategory?CID=<?php echo $corporateCategory['CorporateCategory']['uuid']; ?>" class="pull-right glyphicon glyphicon-pencil mr10"></a>
				<a class="pull-right mr10" href="<?php echo $this->base ?>/Fairs/viewCompanies?CID=<?php echo $corporateCategory['CorporateCategory']['uuid']; ?>">Companies</a>
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