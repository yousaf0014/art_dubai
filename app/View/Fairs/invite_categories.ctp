<div class="panel panel-primary">
	<div class="panel-heading">
    	<h4 class="pull-left">Invitation Types</h4>
        <a class="btn btn-default pull-right btn-sm mt5" href="<?php echo $this->base ?>/Fairs/addInviteCategory"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp;Add</a>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
    	<ul class="list-group">
            <li class="list-group-item">
                <strong class="col-lg-4">Name</strong>
                <strong class="col-lg-4">Fair Category</strong>
                <strong class="col-lg-offset-3">Actions</strong>
                <div class="clearfix"></div>
            </li>
		<?php
        if( !empty($inviteCategories) ) {
            foreach($inviteCategories as $inviteCategory) {
                $uuid = $inviteCategory['InviteCategory']['uuid'];
		?>
			<li class="list-group-item">
                <span class="col-lg-4"><?php echo $inviteCategory['InviteCategory']['name']; ?></span>
                <span class="col-lg-4"><?php echo $inviteCategory['FairCategory']['name']; ?></span>
                <span class="col-lg-offset-3">
    				<a href="<?php echo $this->base ?>/Fairs/addInviteCategory?CID=<?php echo $inviteCategory['InviteCategory']['uuid']; ?>" class="glyphicon glyphicon-pencil" title="Edit"></a>
                    <a href="<?php echo $this->base ?>/Fairs/deleteInviteCategory?CID=<?php echo $inviteCategory['InviteCategory']['uuid']; ?>" class="glyphicon glyphicon-remove ml5" onclick="return confirm('Are you sure?');" title="Delete"></a>
                    <?php
                    
                    $listCount = isset($inviteCategory['InviteCategory']['listCount']) ? $inviteCategory['InviteCategory']['listCount'] : '0';
                    echo $this->Html->link('Lists ('.$listCount.')','/invites/lists/'.$uuid,array(
                            'class' => 'pull-right mr10 myTip',
                            'id' => 'invite_list_'.$inviteCategory['InviteCategory']['id']
                        ));
                    if(!empty($inviteCategory['InviteList'])) {
                    ?>
                    <div id="invite_list_<?php echo $inviteCategory['InviteCategory']['id']; ?>_tip" class="hidden">
                        <ul>
                        <?php
                            foreach($inviteCategory['InviteList'] as $inviteList) {
                        ?>
                            <li><a href="<?php echo $this->base ?>/invites/index?list_id=<?php echo $inviteList['uuid']?>"><?php echo $inviteList['name']; ?></a></li>
                        <?php
                            }
                        ?>
                        </ul>
                    </div>
                    <?php

                    }

                    ?>
                </span>
				<div class="clearfix"></div>
			</li>
		<?php
        	}
        }else{
		?>
        	<li class="list-group-item">No record found.</li>
        <?php 
        }
        ?>
		</ul>
        <?php echo $this->element('pagination_links'); ?>
    </div>
</div>

<?php

echo $this->Html->css('jquery.qtip.min');

echo $this->Html->script('jquery.qtip.min');
    
?>
<script type="text/javascript">
    jQuery('a.myTip').qtip({
        content: {
            text: function(event,api) {
                return $('#'+$(this).prop('id')+'_tip').html();
            }
        },
        position : {
            at : 'right bottom',
            my: 'right top'
        },
        hide : {
             fixed: true,
        }
    });
</script>