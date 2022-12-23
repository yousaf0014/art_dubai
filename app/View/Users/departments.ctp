<div class="panel panel-primary">
	<div class="panel-heading">
    	<h4 class="pull-left">Departments</h4>
        <a class="btn btn-default pull-right btn-sm mt5" href="<?php echo $this->base ?>/Users/addDepartment"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp;Add</a>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
    	<ul class="list-group">
		<?php
        if( !empty($departments) ){
            foreach($departments as $department){ 
                $d_name = $department['Department']['name'];
                $d_uuid = $department['Department']['uuid'];

                echo $this->Html->useTag('tagstart','li',array('class' => 'list-group-item'));
                
                echo $this->Html->tag('span',$d_name,array(
                        'class' => 'pull-left'
                    ));
                echo $this->Html->link('','/Users/deleteDepartment?ID='.$d_uuid,array(
                        'class' => 'pull-right glyphicon glyphicon-remove',
                        'onclick' => "return confirm('Are you sure?');"
                    ));
                echo $this->Html->link('','/Users/addDepartment?ID='.$d_uuid,array(
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