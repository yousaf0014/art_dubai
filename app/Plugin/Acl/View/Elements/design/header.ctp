<div class="panel panel-primary">
	
	<?php
	echo $this->Session->flash('plugin_acl');
	?>
	<div class="panel-heading">
    	<h4><?php echo __d('acl', 'ACL'); ?></h4>
    </div>
	<div class="panel-body">
        <ul class="nav nav-tabs">
        <?php
        if(!isset($no_acl_links))
        {
            $selected = $this->request->controller;
            $active   = ($selected == 'aros') ? 'active' : '';
            echo "<li class=\"{$active}\">";
            echo $this->Html->link(__d('acl', 'Permissions'), '/admin/acl/aros/index');

            $active   = ($selected == 'acos') ? 'active' : '';
            echo "</li><li class=\"{$active}\">";        
            echo $this->Html->link(__d('acl', 'Actions'), '/admin/acl/acos/index');
            echo "</li>";

            $active = ($selected == 'utilities') ? 'active' : '';
            echo '<li class="'.$active.'">';
            echo $this->Html->link(__d('acl','Actions Alias'), '/admin/acl/utilities/action_names');
            echo '</li>';
        }
        ?>
        </ul>