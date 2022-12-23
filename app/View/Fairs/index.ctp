<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="pull-left">Fair Categories</h4>
		<a class="pull-right btn btn-default btn-sm mt5" href="<?php echo $this->base ?>/Fairs/addCategory"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp;Add</a>
		<div class="clearfix"></div>
	</div>
	<div class="panel-body">
		<div class="col-lg-12">
			<ul class="list-group">
			<?php
            if( !empty($fairCategories) ){
                foreach($fairCategories as $fairCategory){ 
			?>
				<li class="list-group-item">
					<span class="pull-left"><?php echo $fairCategory['FairCategory']['name']?></span>
					<a href="<?php echo $this->base ?>/Fairs/deleteCategory?FCID=<?php echo $fairCategory['FairCategory']['uuid']; ?>" class="pull-right glyphicon glyphicon-remove" onclick="return confirm('Are you sure?');"></a>
					<a href="<?php echo $this->base ?>/Fairs/addCategory?FCID=<?php echo $fairCategory['FairCategory']['uuid']; ?>" class="pull-right glyphicon glyphicon-pencil mr10"></a>
					<a class="pull-right mr10" href="<?php echo $this->base ?>/Fairs/viewFairs?FCID=<?php echo $fairCategory['FairCategory']['uuid']; ?>">Fair Years</a>
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
</div>