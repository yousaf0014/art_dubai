<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="pull-left">Print Invite List</h4>
		<div class="pull-right">
			<a href="javascript:;" onclick="hideModal('#myModal')" class="glyphicon glyphicon-remove-circle pull-right text-primary f20 mt5"></a>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="panel-body">
		<div class="height-500" id="print_area">
			<div class="col-lg-4 col-lg-offset-4">
				<ul class="list-group">
					<li class="list-group-item pl0 pr5">
				  		<div class="col-lg-4">Contact Name:</div>
						<div class="col-lg-8"><strong><?php echo ucwords($contact['Contact']['first_name'].' '.$contact['Contact']['last_name']); ?></strong></div>
						<div class="clearfix"></div>
						<div class="col-lg-4">Company Name:</div>
						<div class="col-lg-8"><strong><?php echo $contact['Contact']['first_name']; ?></strong></div>
						<div class="clearfix"></div>
						<div class="col-lg-4">Address:</div>
						<div class="col-lg-8"><strong><?php echo $contact['Contact']['address']; ?></strong></div>
						<div class="clearfix"></div>
						<div class="col-lg-4">City:</div>
						<div class="col-lg-8"><strong><?php echo ucfirst($contact['Contact']['city']); ?></strong></div>
						<div class="clearfix"></div>
						<div class="col-lg-4">Mobile:</div>
						<div class="col-lg-8"><strong><?php echo $contact['Contact']['mobile'].'/'.$contact['Contact']['phone']; ?></strong></div>
						<div class="clearfix"></div>
						<div class="col-lg-4">Phone:</div>
						<div class="col-lg-8"><strong><?php echo $contact['Contact']['phone']; ?></strong></div>
						<div class="clearfix"></div>
						<div class="col-lg-12">Bar Code</div>
						<div class="clearfix"></div>
						<div>
							<?php
							$data_to_encode = $contact['Contact']['bar_code'];
	                        
							// Generate Barcode data
							$this->Barcode->barcode();
							$this->Barcode->setType('C128');
							$this->Barcode->setCode($data_to_encode);
							$this->Barcode->setSize(80,200);
							$this->Barcode->hideCodeType('C128');
							// Generate filename            
							$random = rand(0,1000000);
							$file = 'img/barcode/code_'.$random.'.png';

							// Generates image file on server            
							$this->Barcode->writeBarcodeFile($file);

							// Display image
							echo $this->Html->image('barcode/code_'.$random.'.png');
							?>
						</div>
						<div class="clearfix"></div>
				  	</li>
				</ul>
			</div>
		</div>
	</div>
</div>