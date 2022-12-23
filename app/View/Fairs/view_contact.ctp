<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="pull-left">
			<span>Contact Details</span>
			<span class="ml10 mr10 glyphicon glyphicon-circle-arrow-right"></span>
			<span><?php echo ucwords($contact['Contact']['first_name'].' '.$contact['Contact']['last_name']); ?></span>
		</h4>
		<a class="btn btn-default btn-sm mt5 pull-right" href="<?php echo $this->base ?>/fairs/contacts">
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
			  		<div class="col-lg-2">First Name:</div>
					<div class="col-lg-10"><?php echo $this->Html->tag('strong',ucfirst($contact['Contact']['first_name'])); ?></div>
					<div class="clearfix"></div>
			  	</li>
			  	<li class="list-group-item">
			  		<div class="col-lg-2">Last Name:</div>
					<div class="col-lg-10"><?php echo $this->Html->tag('strong',ucfirst($contact['Contact']['last_name'])); ?></div>
					<div class="clearfix"></div>
			  	</li>
			  	<li class="list-group-item">
					<div class="col-lg-2">Address:</div>
					<div class="col-lg-10"><?php echo $this->Html->tag('strong',ucfirst($contact['Contact']['address'])); ?></div>
					<div class="clearfix"></div>
				</li>
				<li class="list-group-item">
					<div class="col-lg-2">City:</div>
					<div class="col-lg-10"><?php echo $this->Html->tag('strong',ucfirst($contact['Contact']['city'])); ?></div>
					<div class="clearfix"></div>
				</li>
				<li class="list-group-item">
					<div class="col-lg-2">Country:</div>
					<div class="col-lg-10"><?php echo $this->Html->tag('strong',$contact['Contact']['country']); ?></div>
					<div class="clearfix"></div>
				</li>
				<li class="list-group-item">
					<div class="col-lg-2">Fairs:</div>
					<div class="col-lg-10">
						<strong>
						<?php
						if(!empty($contact['Fair'])) {
							$fair_names = Set::extract('/name',$contact['Fair']);
							echo implode(', ', $fair_names);
						}else{
							echo 'None';
						}
						?>
						</strong>
					</div>
					<div class="clearfix"></div>
				</li>
				<li class="list-group-item">
					<div class="col-lg-2">Email:</div>
					<div class="col-lg-10"><?php echo $this->Html->tag('strong',$contact['Contact']['email']); ?></div>
					<div class="clearfix"></div>
				</li>
				<li class="list-group-item">
					<div class="col-lg-2">Phone:</div>
					<div class="col-lg-10"><?php echo $this->Html->tag('strong',$contact['Contact']['phone']); ?></div>
					<div class="clearfix"></div>
				</li>
				<li class="list-group-item">
					<div class="col-lg-2">Mobile:</div>
					<div class="col-lg-10"><?php echo $this->Html->tag('strong',$contact['Contact']['mobile']); ?></div>
					<div class="clearfix"></div>
				</li>
				<li class="list-group-item">
					<div class="col-lg-2">Fax:</div>
					<div class="col-lg-10"><?php echo $this->Html->tag('strong',$contact['Contact']['fax']); ?></div>
					<div class="clearfix"></div>
				</li>
				<li class="list-group-item">
					<div class="col-lg-2">Website:</div>
					<div class="col-lg-10"><?php echo $this->Html->tag('strong',$contact['Contact']['website']); ?></div>
					<div class="clearfix"></div>
				</li>
				<li class="list-group-item">
					<div class="col-lg-2">Bar Code:</div>
					<div class="col-lg-10"><?php echo $this->Html->tag('strong',$contact['Contact']['bar_code']); ?></div>
					<div class="clearfix"></div>
				</li>
				<li class="list-group-item">
					<div class="col-lg-2">Guest of:</div>
					<div class="col-lg-10"><?php echo $this->Html->tag('strong',$contact['Contact']['guest_off']); ?></div>
					<div class="clearfix"></div>
				</li>
				<li class="list-group-item">
					<div class="col-lg-2">Source:</div>
					<div class="col-lg-10"><?php echo $this->Html->tag('strong',$contact['Contact']['source']); ?></div>
					<div class="clearfix"></div>
				</li>
				<li class="list-group-item">
					<div class="col-lg-2">Facebook:</div>
					<div class="col-lg-10"><?php echo $this->Html->tag('strong',$contact['Contact']['facebook']); ?></div>
					<div class="clearfix"></div>
				</li>
				<li class="list-group-item">
					<div class="col-lg-2">Twitter:</div>
					<div class="col-lg-10"><?php echo $this->Html->tag('strong',$contact['Contact']['twitter']); ?></div>
					<div class="clearfix"></div>
				</li>
				<li class="list-group-item">
					<div class="col-lg-2">Linkedin:</div>
					<div class="col-lg-10"><?php echo $this->Html->tag('strong',$contact['Contact']['linkedin']); ?></div>
					<div class="clearfix"></div>
				</li>
				<li class="list-group-item">
					<div class="col-lg-2">Instagram:</div>
					<div class="col-lg-10"><?php echo $this->Html->tag('strong',$contact['Contact']['instagram']); ?></div>
					<div class="clearfix"></div>
				</li>
				<li class="list-group-item">
					<div class="col-lg-2">Registration Method:</div>
					<div class="col-lg-10"><?php echo $this->Html->tag('strong',ucwords($contact['Contact']['registration_method'])); ?></div>
					<div class="clearfix"></div>
				</li>
				<li class="list-group-item">
					<div class="col-lg-2">Created:</div>
					<div class="col-lg-10"><?php echo $this->Html->tag('strong',YMD2MDY($contact['Contact']['created'],'/')); ?></div>
					<div class="clearfix"></div>
				</li>
				<li class="list-group-item">
					<div class="col-lg-2">Created by:</div>
					<div class="col-lg-10"><?php echo $this->Html->tag('strong',ucwords($contact['CreatedBy']['first_name'].' '.$contact['CreatedBy']['last_name'])); ?></div>
					<div class="clearfix"></div>
				</li>
				<li class="list-group-item">
					<div class="col-lg-2">Updated:</div>
					<div class="col-lg-10"><?php echo $this->Html->tag('strong',YMD2MDY($contact['Contact']['updated'],'/')); ?></div>
					<div class="clearfix"></div>
				</li>
				<li class="list-group-item">
					<div class="col-lg-2">Updated by:</div>
					<div class="col-lg-10"><?php echo $this->Html->tag('strong',ucwords($contact['UpdatedBy']['first_name'].' '.$contact['UpdatedBy']['last_name'])); ?></div>
					<div class="clearfix"></div>
				</li>
			</ul>
		</div>
		<div class="col-lg-4">
			<ul class="list-group">
			  	<li class="list-group-item">
			  		<div class="col-lg-3">Characteristics:</div>
					<div class="col-lg-9">
						<strong>
						<?php
						if(!empty($contact['ContactCharacteristic'])) {
							$chars = Set::extract('/name',$contact['ContactCharacteristic']);
							echo implode(', ', $chars);
						}else{
							echo 'None';
						}
						?>
						</strong>
					</div>
					<div class="clearfix"></div>
			  	</li>
			  	<li class="list-group-item">
			  		<div class="col-lg-12"><strong>Tagged Companies:</strong></div>
					<div class="col-lg-12">
						<table class="table table-striped">
							<thead>
								<tr>
									<th width="40%">Name:</th>
									<th>Job Title</th>
								</tr>
							</thead>
							<tbody>
							<?php
							if(!empty($contact['Company'])) {
								foreach($contact['Company'] as $company) {
							?>
								<tr>
									<td><?php echo $company['name']; ?></td>
									<td><?php echo $company['ContactToCompany']['job_title']; ?></td>
								</tr>
							<?php
								}
								}else{
							?>
								<tr>
									<td colspan="2">No record found.</td>
								</tr>
							<?php
								}
							?>
							</tbody>
						</table>
					</div>
					<div class="clearfix"></div>
			  	</li>
			</ul>
		</div>
	</div>
</div>