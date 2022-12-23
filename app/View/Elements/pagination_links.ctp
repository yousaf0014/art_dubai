<?php
$pages = $this->Paginator->param('pageCount');

if($pages > 1) {
?>
<ul class="pagination">
	<?php 
	$class = isset($class) ? $class : '';
	echo $this->Paginator->numbers(array('tag' => 'li','separator' => '','currentClass' => 'active','currentTag' => 'a','class' => $class )); ?>
</ul>
<?php
}
?>