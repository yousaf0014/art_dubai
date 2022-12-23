<div class="col-lg-offset-4 col-lg-4">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h4>Reset Password</h4>
		</div>
		<div class="panel-body">
			<?php echo $this->Session->flash('message'); ?>

			<form class="form-horizontal" method="post" action="<?php echo $this->base ?>/forgot_password" id="recover_email">
				<div class="form-group">
					<label class="col-md-2 control-label">Email</label>
					<div class="col-md-9">
						<input type="text" class="form-control" name="data[User][email]">
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-offset-5">
						<a href="<?php echo $this->base ?>/login" class="btn btn-link">Login</a>
						<button class="btn btn-primary">Reset Password</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<?php echo $this->Html->script(array('jquery.validate.min')); ?>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('#recover_email').validate({
			rules : {
				'data[User][email]' : {required:true,email:true}
			},
			messages : {
				'data[User][email]' : {required:'Please enter email',email:'Please enter valid email'}
			}
		});
	});
</script>