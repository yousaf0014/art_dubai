<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="pull-left">
			<span>Company Details</span>
			<span class="ml10 mr10 glyphicon glyphicon-circle-arrow-right"></span>
			<span><?php echo ucwords($company['Company']['name']); ?></span>
		</h4>
		<a class="btn btn-default pull-right" href="<?php echo $this->base ?>/fairs/viewCompanies">
			<span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Go Back
		</a>
		<?php
		echo $this->Html->tag('div','',array('class' => 'clearfix'));
		?>
	</div>
	<div class="panel-body">
		<div class="col-lg-6 col-lg-offset-1">
			<ul class="list-group">
			  	<li class="list-group-item">
			  		<div class="col-lg-2">Name:</div>
					<div class="col-lg-10"><?php echo $this->Html->tag('strong',ucwords($company['Company']['name'])); ?></div>
					<div class="clearfix"></div>
			  	</li>
			  	<li class="list-group-item">
			  		<div class="col-lg-2">Category:</div>
					<div class="col-lg-10"><?php echo $this->Html->tag('strong',ucwords($company['CorporateCategory']['name'])); ?></div>
					<div class="clearfix"></div>
			  	</li>
			  	<li class="list-group-item">
					<div class="col-lg-2">Address:</div>
					<div class="col-lg-10"><?php echo $this->Html->tag('strong',ucfirst($company['Company']['address'])); ?></div>
					<div class="clearfix"></div>
				</li>
				<li class="list-group-item">
					<div class="col-lg-2">City:</div>
					<div class="col-lg-10"><?php echo $this->Html->tag('strong',ucfirst($company['Company']['city'])); ?></div>
					<div class="clearfix"></div>
				</li>
				<li class="list-group-item">
					<div class="col-lg-2">Country:</div>
					<div class="col-lg-10"><?php echo $this->Html->tag('strong',$company['Country']['nicename']); ?></div>
					<div class="clearfix"></div>
				</li>
				<li class="list-group-item">
					<div class="col-lg-2">Email:</div>
					<div class="col-lg-10"><?php echo $this->Html->tag('strong',$company['Company']['email']); ?></div>
					<div class="clearfix"></div>
				</li>
				<li class="list-group-item">
					<div class="col-lg-2">Phone:</div>
					<div class="col-lg-10"><?php echo $this->Html->tag('strong',$company['Company']['phone']); ?></div>
					<div class="clearfix"></div>
				</li>
				<li class="list-group-item">
					<div class="col-lg-2">Mobile:</div>
					<div class="col-lg-10"><?php echo $this->Html->tag('strong',$company['Company']['mobile']); ?></div>
					<div class="clearfix"></div>
				</li>
				<li class="list-group-item">
					<div class="col-lg-2">Fax:</div>
					<div class="col-lg-10"><?php echo $this->Html->tag('strong',$company['Company']['fax']); ?></div>
					<div class="clearfix"></div>
				</li>
				<li class="list-group-item">
					<div class="col-lg-2">Website:</div>
					<div class="col-lg-10"><?php echo $this->Html->tag('strong',$company['Company']['website']); ?></div>
					<div class="clearfix"></div>
				</li>
				<li class="list-group-item">
					<div class="col-lg-2">Created:</div>
					<div class="col-lg-10"><?php echo $this->Html->tag('strong',YMD2MDY($company['Company']['created'],'/')); ?></div>
					<div class="clearfix"></div>
				</li>
				<li class="list-group-item">
					<div class="col-lg-2">Created by:</div>
					<div class="col-lg-10"><?php echo $this->Html->tag('strong',ucwords($company['CreatedBy']['first_name'].' '.$company['CreatedBy']['last_name'])); ?></div>
					<div class="clearfix"></div>
				</li>
				<li class="list-group-item">
					<div class="col-lg-2">Updated:</div>
					<div class="col-lg-10"><?php echo $this->Html->tag('strong',YMD2MDY($company['Company']['updated'],'/')); ?></div>
					<div class="clearfix"></div>
				</li>
				<li class="list-group-item">
					<div class="col-lg-2">Updated by:</div>
					<div class="col-lg-10"><?php echo $this->Html->tag('strong',ucwords($company['UpdatedBy']['first_name'].' '.$company['UpdatedBy']['last_name'])); ?></div>
					<div class="clearfix"></div>
				</li>
			</ul>
		</div>
	</div>
</div>