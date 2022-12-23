<div class="panel panel-default">
	<div class="panel-heading">
		<h5 class="pull-left">Oops!</h5>
		<a class="pull-right btn btn-primary btn-sm" href="<?php echo $this->request->referer(); ?>"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Go Back</a>
		<div class="clearfix"></div>
	</div>
	<div class="panel-body">
		<h5 class="alert alert-danger">You are not authorized to access that location.<a class="btn btn-link btn-sm" href="<?php echo $this->request->referer(); ?>"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back</a></h5>
	</div>
</div>