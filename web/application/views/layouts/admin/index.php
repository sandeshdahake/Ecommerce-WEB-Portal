<!DOCTYPE html>
<html>
	<head>
		<title>Compare Dunia</title>
		<!-- my script and syles goes here
		<title>Free Home Shoppe Website Template | Home </title>
		<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
		<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>  -->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link href="<?= base_url() .'assets/css/style.css' ?>" rel="stylesheet" type="text/css" media="all"/>
		<script type="text/javascript" src="<?= base_url() .'assets/js/jquery-1.7.2.min.js' ?>"></script>
	</head>
	<body>
		<?php if($header) echo $header ;?>
		<?php //  if($left) echo $left ;?>
		<?php if(isset($middle) && $middle != "") echo $middle ;?>
		<?php if($footer) echo $footer ;?>
	</body>
</html>