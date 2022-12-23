<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="pull-left">Contact History</h4>
		<div class="pull-right">
			<a href="<?php echo $this->base ?>/fairs/contacts" class="btn btn-default btn-sm mt5"><span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Go Back</a>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th width="13%">Date:</th>
						<th width="15%">Modified By:</th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($history as $contact) { ?>
					<tr>
						<td><?php echo $this->Time->nice($contact['Log']['created']); ?></td>
						<td><?php echo $contact['User']['first_name'].' '.$contact['User']['last_name']; ?></td>
						<td>
							<?php 
							$data = unserialize($contact['Log']['data']);
							?>
							<div class="col-lg-4 row">
								<div class="col-lg-5 text-info">Salutation:</div>
								<div class="col-lg-7"><?php echo isset($data['salutation']) ? $data['salutation'] : ''; ?></div>
								<div class="clearfix"></div>
								<div class="col-lg-5 text-info">First Name:</div>
								<div class="col-lg-7"><?php echo isset($data['first_name']) ? $data['first_name'] : ''; ?></div>
								<div class="clearfix"></div>
								<div class="col-lg-5 text-info">Last Name:</div>
								<div class="col-lg-7"><?php echo isset($data['last_name']) ? $data['last_name'] : ''; ?></div>
								<div class="clearfix"></div>
								<div class="col-lg-5 text-info">City:</div>
								<div class="col-lg-7"><?php echo isset($data['city']) ? $data['city'] : ''; ?></div>
								<div class="clearfix"></div>
								<div class="col-lg-5 text-info">Country:</div>
								<div class="col-lg-7"><?php echo isset($data['country']) ? $data['country'] : ''; ?></div>
								<div class="clearfix"></div>
								<div class="col-lg-5 text-info">Country Code:</div>
								<div class="col-lg-7"><?php echo isset($data['country_code']) ? $data['country_code'] : ''; ?></div>
								<div class="col-lg-5 text-info">Phone:</div>
								<div class="col-lg-7"><?php echo isset($data['phone']) ? $data['phone'] : ''; ?></div>
								<div class="clearfix"></div>
							</div>
							<div class="col-lg-4">
								<div class="col-lg-4 text-info">Mobile:</div>
								<div class="col-lg-8"><?php echo isset($data['mobile']) ? $data['mobile'] : ''; ?></div>
								<div class="clearfix"></div>
								<div class="col-lg-4 text-info">Fax:</div>
								<div class="col-lg-8"><?php echo isset($data['fax']) ? $data['fax'] : ''; ?></div>
								<div class="clearfix"></div>
								<div class="col-lg-4 text-info">Email:</div>
								<div class="col-lg-8"><?php echo isset($data['email']) ? $data['email'] : ''; ?></div>
								<div class="clearfix"></div>
								<div class="col-lg-4 text-info">Zip:</div>
								<div class="col-lg-8"><?php echo isset($data['zip']) ? $data['zip'] : ''; ?></div>
								<div class="clearfix"></div>
								<div class="col-lg-4 text-info">P.O. Box:</div>
								<div class="col-lg-8"><?php echo isset($data['pobox']) ? $data['pobox'] : ''; ?></div>
								<div class="clearfix"></div>
								<div class="col-lg-4 text-info">Website:</div>
								<div class="col-lg-8"><?php echo isset($data['website']) ? $data['website'] : ''; ?></div>
								<div class="clearfix"></div>
								<div class="col-lg-4 text-info">Shared:</div>
								<div class="col-lg-8"><?php echo (isset($data['shared']) && $data['shared'] == '1') ? 'Yes' : 'No'; ?></div>
								<div class="clearfix"></div>
							</div>
							<div class="col-lg-4">
								<div class="col-lg-4 text-info">Guest Of:</div>
								<div class="col-lg-8"><?php echo isset($data['guest_off']) ? $data['guest_off'] : ''; ?></div>
								<div class="clearfix"></div>
								<div class="col-lg-4 text-info">Source:</div>
								<div class="col-lg-8"><?php echo isset($data['source']) ? $data['source'] : ''; ?></div>
								<div class="clearfix"></div>
								<div class="col-lg-4 text-info">Twitter:</div>
								<div class="col-lg-8"><?php echo isset($data['twitter']) ? $data['twitter'] : ''; ?></div>
								<div class="clearfix"></div>
								<div class="col-lg-4 text-info">Facebook:</div>
								<div class="col-lg-8"><?php echo isset($data['facebook']) ? $data['facebook'] : ''; ?></div>
								<div class="clearfix"></div>
								<div class="col-lg-4 text-info">Linkedin:</div>
								<div class="col-lg-8"><?php echo isset($data['linkedin']) ? $data['linkedin'] : ''; ?></div>
								<div class="clearfix"></div>
								<div class="col-lg-4 text-info">Instagram:</div>
								<div class="col-lg-8"><?php echo isset($data['instagram']) ? $data['instagram'] : ''; ?></div>
								<div class="clearfix"></div>
							</div>
							<div class="clearfix"></div>
							<div class="col-lg-1 text-info">Address:</div>
							<div class="col-lg-11"><?php echo isset($data['address']) ? $data['address'] : ''; ?></div>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>