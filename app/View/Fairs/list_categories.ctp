<div class="panel panel-primary">
	<div class="panel-heading">
		<h4>My Dashboard</h4>
	</div>
	<div class="panel-body">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h5 class="pull-left">Fair Categories</h5>
					<a class="pull-right btn btn-primary" href="<?php echo $this->base ?>/Fairs/addCategory">Add</a>
					<div class="clearfix"></div>
				</div>
				<div class="panel-body">
					<ul class="list-group">
					<?php
                    if( !empty($fairCategories) ){
                        foreach($fairCategories as $fairCategory){ 
					?>
						<li class="list-group-item">
							<span class="pull-left"><?php echo $fairCategory['FairCategory']['name']?></span>
							<a href="<?php echo $this->base ?>/Fairs/deleteCategory?FCID=<?php echo $fairCategory['FairCategory']['uuid']; ?>" class="pull-right glyphicon glyphicon-remove" onclick="return confirm('Are you sure?');"></a>
							<a href="<?php echo $this->base ?>/Fairs/addCategory?FCID=<?php echo $fairCategory['FairCategory']['uuid']; ?>" class="pull-right glyphicon glyphicon-pencil mr10"></a>
							<a class="pull-right mr10" href="<?php echo $this->base ?>/Fairs/viewFairs?FCID=<?php echo $fairCategory['FairCategory']['uuid']; ?>">Fairs</a>
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
				</div>
			</div>
		</div>
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h5 class="pull-left">Contact Categories</h5>
					<a class="pull-right btn btn-primary" href="<?php echo $this->base ?>/Fairs/addContactCategory">Add</a>
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
				</div>
			</div>
		</div>
        <div class="col-lg-12">
        	<div class="panel panel-default">
            	<div class="panel-heading">
                	<h5 class="pull-left">Corporate Categories</h5>
                    <a class="btn btn-primary pull-right" href="<?php echo $this->base ?>/Fairs/addCorporateCategory">Add</a>
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
                </div>
            </div>
        </div>
        <div class="col-lg-12">
        	<div class="panel panel-default">
            	<div class="panel-heading">
                	<h5 class="pull-left">Invite Categories</h5>
                    <a class="btn btn-primary pull-right" href="<?php echo $this->base ?>/Fairs/addInviteCategory">Add</a>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                	<ul class="list-group">
					<?php
                    if( !empty($inviteCategories) ){
                        foreach($inviteCategories as $inviteCategory){ 
					?>
						<li class="list-group-item">
							<span class="pull-left"><?php echo $inviteCategory['InviteCategory']['name']?></span>
							<a href="<?php echo $this->base ?>/Fairs/deleteInviteCategory?CID=<?php echo $inviteCategory['InviteCategory']['uuid']; ?>" class="pull-right glyphicon glyphicon-remove" onclick="return confirm('Are you sure?');"></a>
							<a href="<?php echo $this->base ?>/Fairs/addInviteCategory?CID=<?php echo $inviteCategory['InviteCategory']['uuid']; ?>" class="pull-right glyphicon glyphicon-pencil mr10"></a>
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
                </div>
            </div>
        </div>
	</div>
</div>