<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Jumbo URB</title>
		
		<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="<?php echo $view['assets']->getUrl('css/normalize.css') ?>">
		<link rel="stylesheet" href="<?php echo $view['assets']->getUrl('css/font-awesome.min.css') ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo $view['assets']->getUrl('css/main.css') ?>">	
	</head>
	<body>
    	<?php echo $content ?>
    	
    	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="<?php echo $view['assets']->getUrl('js/vendor/jquery.validate.min.js') ?>"></script>
		<script src="<?php echo $view['assets']->getUrl('js/main.js') ?>"></script>
	</body>
</html>