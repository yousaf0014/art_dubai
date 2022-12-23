<div class="col-lg-offset-4 col-lg-4">
	<div class="panel panel-primary">
		<div class="panel-heading"><h4>Login</h4></div>
		<div class="panel-body">
			<?php
			if($this->Session->check('Message.login_error')) {
			?>
			<div class="alert alert-danger alert-dismissable">
				 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<?php echo $this->Session->flash('login_error'); ?>
			</div>
			<?php
			}
			?>
			<form action="<?php echo $this->base ?>/Users/login" method="post" role="form">
				<div class="input-group input-group-lg form-group">
				<?php
				echo $this->Html->tag('span','',array('class' =>'glyphicon glyphicon-user input-group-addon'));
				echo $this->Form->input('User.email',array(
						'class' => 'form-control',
						'type' => 'text',
						'placeholder' => 'Username',
						'label' => false,
						'div' => false
					));
				?>
				</div>
				<div class="input-group input-group-lg form-group">
				<?php
				echo $this->Html->tag('span','',array('class' => 'glyphicon glyphicon-eye-close input-group-addon'));
				echo $this->Form->input('User.password',array(
						'class' => 'form-control',
						'type' => 'password',
						'placeholder' => 'Password',
						'label' => false,//array('text' => 'Password:'),
						'div' => false
					));
				?>
				</div>
				<div class="form-group col-lg-offset-5">
					<a href="<?php echo $this->base ?>/forgot_password" class="btn btn-link">Forgot Password?</a>
					<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-log-in"></span>&nbsp;Login</button>
				</div>
			</form>
		</div>
	</div>
</div>