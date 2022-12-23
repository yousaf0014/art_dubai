<div>
	<strong>Name:</strong>
	<span><?php echo ucwords($contact['Contact']['first_name'].' '.$contact['Contact']['last_name']); ?></span>
</div>
<div>
	<strong>Address:</strong>
	<span><?php echo ucwords($contact['Contact']['address']); ?></span>
</div>
<div>
	<strong>City:</strong>
	<span><?php echo ucfirst($contact['Contact']['city']); ?></span>
</div>
<div>
	<strong>Country:</strong>
	<span><?php echo ucfirst($contact['Contact']['country']); ?></span>
</div>
<?php

$code = '$(document).ready(function(){
	window.print();
});';
echo $this->Html->scriptBlock($code,array('block' => 'bottomScript'));

?>