<div class="panel panel-primary">
    <div class="panel-heading">
        <?php
        echo $this->Html->tag('h4','Manage ACL',array('class' => 'pull-left'));
        echo $this->Html->link('Add Module','/aclSetups/addModule',array('class' => 'pull-right btn btn-default'));
        echo $this->Html->link('Manage','/acl_setups/manage',array('class' => 'pull-right btn btn-default mr10'));
        echo $this->Html->link('Manage Roles','/acl_setups/manage_roles',array('class' => 'pull-right btn btn-default mr10'));
        echo $this->Html->tag('div','',array('class' => 'clearfix'));
        ?>
    </div>
    <div class="panel-body">
        <div>
             <?php echo $tree_html; ?>
        </div>
    </div>
</div>