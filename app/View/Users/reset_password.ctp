<div class="col-lg-offset-4 col-lg-4">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h4>Reset Password</h4>
		</div>
		<div class="panel-body">
			<?php
			if($this->Session->check('Message.message')) {
				echo $this->Session->flash('message');
				echo '<a href="'.$this->base.'/login" class="btn btn-primary">Login</a>';
			}
			
			if(empty($this->request->query['success'])) {
				if($is_valid_link == 'invalid_link') {
					echo '<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Invalid link</div>';
					echo '<a href="'.$this->base.'/login" class="btn btn-primary">Login</a>';
				}elseif($is_valid_link == 'expired_link') {
					echo '<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Link already used.</div>';
					echo '<a href="'.$this->base.'/login" class="btn btn-primary">Login</a>';
				}else{
			
			?>
			<form class="form-horizontal" method="post" action="<?php echo $this->base ?>/ResetPassword?link=<?php echo $link; ?>" id="reset_form">
				<?php

				if($passowrd_error == 'password_length') {
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Password must be at least 8 characters.</div>';
				}elseif($passowrd_error == 'passowrd_mismatch') {
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Password and confirm password donot match.</div>';
				}
				
				?>
				<div class="form-group">
					<label class="control-label col-md-4">New Password:</label>
					<?php
					echo $this->Form->input('User.password',array(
						'label' => false,
						'div' => 'col-md-8',
						'class' => 'form-control',
						'id' => 'password',
						'type' => 'password'
					));
					?>
				</div>
				<div class="form-group">
					<label class="control-label col-md-4">Confirm Password:</label>
					<?php
					echo $this->Form->input('User.cpassword',array(
						'label' => false,
						'div' => 'col-md-8',
						'class' => 'form-control',
						'id' => 'cpassword',
						'type' => 'password'
					));
					?>
				</div>
				<div class="form-group">
					<div class="col-md-offset-9">
						<button class="btn btn-primary">Reset</button>
					</div>
				</div>
			</form>
			<?php
				
				}
			
			}
			?>
		</div>
	</div>
</div>

<?php echo $this->Html->script(array('jquery.validate.min')); ?>

<script type="text/javascript">
	jQuery('#reset_form').validate({
		rules : {
			'data[User][password]' : {required:true,minlength:8},
			'data[User][cpassword]' : {required:true,equalTo:'#password'}
		},
		messages : {
			'data[User][password]' : {required:'Please enter a strong password'},
			'data[User][cpassword]' : {required:'Please enter password again',equalTo:'Password do not match'}
		}
	});
</script>