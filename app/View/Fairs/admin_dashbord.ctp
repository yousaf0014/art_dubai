<div class="panel panel-primary">
	<div class="panel-heading">
			<h4 class="pull-left">
        <span class="glyphicon glyphicon-dashboard"></span>
        <span>&nbsp;Dashboard</span>
      </h4>
			<div class="clearfix"></div>
	</div>
  	<div class="panel-body">
  		<div class="col-lg-6">
        <div class="col-lg-6">
    			<div class="panel panel-default">
    				<div class="panel-heading clearfix">
    					<h3 class="panel-title pull-left">
                <span class="glyphicon glyphicon-user"></span>
                <span>&nbsp;My Account</span>
              </h3>
              <a class="pull-right">
                <span class="glyphicon glyphicon-pencil"></span>&nbsp;Edit</a>
              <div class="clear"></div>
    				</div>
    				<div class="panel-body">
    					<div class="table-responsive">
  	  					
  	  				</div>
    				</div>
    			</div>
    		</div>
    		<div class="col-lg-6">
    			<div class="panel panel-default">
    				<div class="panel-heading clearfix">
    					<h3 class="panel-title pull-left">
                <span class="glyphicon glyphicon-calendar"></span>
                <span>&nbsp;Test</span>
              </h3>
              <a href="<?php echo $this->base ?>/leads/addMeeting" data-target="#myModal" data-backdrop="static" data-keyboard="false" data-toggle="modal" class="pull-right" title="Add Lead Meeting">
                <span class="glyphicon glyphicon-plus-sign"></span>&nbsp;Add
              </a>
              <div class="clearfix"></div>
    				</div>
    				<div class="panel-body">
    				</div>
    			</div>
    		</div>
        <div class="clearfix"></div>
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading clearfix">
              <h3 class="panel-title">
                <span class="glyphicon glyphicon-stats"></span>
                <span>Test<small></span>
              </h3>
            </div>
            <div class="panel-body">
              <div id="chart_div"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
    		<div class="col-lg-12">
    			<div class="panel panel-default">
    				<div class="panel-heading">
    					<h3 class="panel-title pull-left">
                <span class="glyphicon glyphicon-th-list"></span>
                <span>&nbsp;Test</span>
              </h3>
              
              <div class="clearfix"></div>
    				</div>
  	  			<div class="panel-body">
              
  	  			</div>
  	  		</div>
    		</div>
      </div>
      <div class="clearfix"></div>
  	</div>
    <div class="clr"></div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>