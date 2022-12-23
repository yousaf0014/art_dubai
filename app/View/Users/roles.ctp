<div class="panel panel-primary">
	<div class="panel-heading">
    	<h4 class="pull-left">Roles</h4>
        <a class="btn btn-default btn-sm mt5 pull-right" href="<?php echo $this->base ?>/users/addRole"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp;Add</a>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
    	<ul class="list-group">
		<?php
        if( !empty($roles) ){
            foreach($roles as $role){ 
                $r_name = $role['Role']['name'];
                $r_uuid = $role['Role']['uuid'];

                echo $this->Html->useTag('tagstart','li',array('class' => 'list-group-item'));
                
                echo $this->Html->tag('span',$r_name,array(
                        'class' => 'pull-left'
                    ));
                echo $this->Html->link('','/Users/deleteRole?RID='.$r_uuid,array(
                        'class' => 'pull-right glyphicon glyphicon-remove',
                        'onclick' => "return confirm('Are you sure?');"
                    ));
                echo $this->Html->link('','/Users/addRole?RID='.$r_uuid,array(
                        'class' => 'pull-right glyphicon glyphicon-pencil mr10'
                    ));
                echo $this->Html->tag('div','',array('class' => 'clearfix'));
                
                echo $this->Html->useTag('tagend','li');

        	}
        }else{
            echo $this->Html->tag('li','No record found',array('class' => 'list-group-item'));
        }

        ?>
		</ul>
        <?php echo $this->element('pagination_links'); ?>
    </div>
</div>