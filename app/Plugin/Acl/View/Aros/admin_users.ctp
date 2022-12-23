<?php 
echo $this->element('design/header');
echo $this->element('Aros/links');
?>
<div class="mt20">
<?php

echo $this->Form->create('User', array('url' => array('plugin' => 'acl', 'controller' => 'aros', 'action' => 'admin_users'), 'class'=>'form-horizontal','role' => 'form'));

echo $this->Html->useTag('tagstart','div',array('class' => 'form-group'));
echo $this->Form->input($user_display_field, array('label' => false, 'div' => 'col-lg-2	', 'class' => 'form-control input-sm','placeholder' => 'Name'));
echo $this->Form->button('Filter',array('type' => 'submit','class' => 'btn btn-primary btn-sm'));
echo $this->Html->useTag('tagend','div');

echo $this->Form->end();
	
?>
</div>
<table class="table table-bordered table-condensed table-striped">
<tr>
	<?php
	$column_count = 1;
	
	$headers = array($this->Paginator->sort($user_display_field, __d('acl', 'Name')));
	
	foreach($roles as $role)
	{
	    $headers[] = $role[$role_model_name][$role_display_field];
	    $column_count++;
	}
	
	echo $this->Html->tableHeaders($headers);
	
	?>
	
</tr>
<?php
foreach($users as $user)
{
    $style = isset($user['Aro']) ? '' : ' class="line_warning"';
    
    echo '<tr' . $style . '>';
    echo '  <td>' . $user[$user_model_name][$user_display_field] . '</td>';
    
    foreach($roles as $role)
	{
	   if(isset($user['Aro']) && $role[$role_model_name][$role_pk_name] == $user[$user_model_name][$role_fk_name])
	   {
	       echo '  <td>' . $this->Html->image('/acl/img/design/tick.png') . '</td>';
	   }
	   else
	   {
	   	   $title = __d('acl', 'Update the user role');
	       echo '  <td>' . $this->Html->link($this->Html->image('/acl/img/design/tick_disabled.png'), '/admin/acl/aros/update_user_role/user:' . $user[$user_model_name][$user_pk_name] . '/role:' . $role[$role_model_name][$role_pk_name], array('title' => $title, 'alt' => $title, 'escape' => false)) . '</td>';
	   }
	}
	
    //echo '  <td>' . (isset($user['Aro']) ? $this->Html->image('/acl/img/design/tick.png') : $this->Html->image('/acl/img/design/cross.png')) . '</td>';
    
    echo '</tr>';
}
?>
</table>

<ul class="pagination">
	 	<?php echo $this->Paginator->numbers(array('separater' => ''));?>
</ul>

<?php
if($missing_aro)
{
?>
    <div style="margin-top:20px">    
    <p class="warning"><?php echo __d('acl', 'Some users AROS are missing. Click on a role to assign one to a user.') ?></p>    
    </div>
<?php
}
?>

<?php
echo $this->element('design/footer');
?>