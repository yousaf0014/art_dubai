<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?php
		echo $this->Html->meta('icon');

		echo $this->fetch('meta');

		echo $this->fetch('css');
		echo $this->Html->css(array('bootstrap.min','style'),array('media' => 'print'));
		
		echo $this->Html->script(array('jquery-1.10.2.min','bootstrap.min'));
		echo $this->fetch('script');
	?>
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <?php echo $this->Html->script(array('html5shiv','respond.min')); ?>
    <![endif]-->
    <script type="text/javascript">
    	var basePath = '<?php echo $this->base ?>';
    </script>
</head>
<body>
	<div id="container" class="visible-print">
		<div id="header">
			<?php //echo $this->element('header'); ?>
		</div>
		<div class="clearfix"></div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div class="clearfix"></div>
		<div id="footer">
			<?php echo $this->element('footer'); ?>
		</div>
	</div>
	<?php echo $this->fetch('bottomScript'); ?>
	<?php //echo $this->element('sql_dump'); ?>
</body>
</html>