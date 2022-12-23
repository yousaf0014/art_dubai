<?php
$params = $this->request->params;
$controller = strtolower($params['controller']);
$action = strtolower($params['action']);
?>
<nav class="navbar navbar-inverse" role="navigation">
	<ul class="nav navbar-nav">
		<li><a href="<?php echo $this->base ?>/fairs">Home</a></li>
		<li class="dropdown">
		 	<a class="dropdown-toggle" data-toggle="dropdown" href="#">
		      Administration <span class="caret"></span>
		    </a>
		    <ul class="dropdown-menu">
		    	<li><a href="<?php echo $this->base ?>/Fairs">Fair Management</a></li>
		    	<li><a href="<?php echo $this->base ?>/Fairs/contacts">Contact Management</a></li>
		    	<li><a href="<?php echo $this->base ?>/Fairs/viewCompanies">Company Management</a></li>
				<li><a href="<?php echo $this->base ?>/InventoryOutItems/index">Inventory Management</a></li>
				<li><a href="<?php echo $this->base ?>/invites/lists">Invitation Management</a></li>
		    </ul>
		</li>
		<li class="dropdown">
		 	<a class="dropdown-toggle" data-toggle="dropdown" href="#">
		      General Info <span class="caret"></span>
		    </a>
		    <ul class="dropdown-menu">
		    	<li><a href="<?php echo $this->base ?>/Fairs/corporateCategories">Corporate Categories</a></li>
		    	<li><a href="<?php echo $this->base ?>/Fairs/contactCategories">Contact Types</a></li>
		    	<li><a href="<?php echo $this->base ?>/Fairs/inviteCategories">Invitation Types</a></li>
				<li><a href="<?php echo $this->base ?>/ItemCategories/index">Item Categories</a></li>
				<li><a href="<?php echo $this->base ?>/users/departments">Departments</a></li>
		    	<li><a href="<?php echo $this->base ?>/users/employees">Employees</a></li>
		    	<li><a href="<?php echo $this->base ?>/users/roles">Roles</a></li>
		    	<li><a href="<?php echo $this->base ?>/flag/flags">Flags</a></li>
				<li><a href="<?php echo $this->base ?>/template/view">Templates</a></li>
				<li><a href="<?php echo $this->base ?>/utils/showInactiveContacts">Inactive Contacts</a></li>
				<li><a href="<?php echo $this->base ?>/utils/selectViewFields">View Fields</a></li>
		    </ul>
		</li>
		<li><a href="<?php echo $this->base ?>/acl">ACL</a></li>
		<li><a href="<?php echo $this->base ?>/admin/database_logger/logs">Logs</a></li>
	</ul>
</nav>