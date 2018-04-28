<?php

if (session_id() == '')
{
	session_start();
}

$_SESSION['token'] = md5(uniqid(rand(), true));

?>

<!DOCTYPE html>
<html>
<head>
	<title>Leonhard - Calcul du diamètre</title>
	<meta charset="utf-8">
	<meta name="token" content="<?php $_SESSION['token'] ?>">
	<link rel="stylesheet" type="text/css" href="public/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="public/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="public/css/app.css">
</head>
<body>

	<?php include 'public/views/diameter-calc.php' ?>

	<script type="text/javascript" src="public/js/jquery.min.js"></script>
	<script type="text/javascript" src="public/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="public/js/page-scroll.js"></script>
	<script type="text/javascript" src="public/js/sigma.min.js"></script>
	<script type="text/javascript" src="public/js/sigma.layout.forceAtlas2.min.js"></script>
	<script type="text/javascript" src="public/js/sigma.plugins.dragNodes.min.js"></script>
	<script type="text/javascript" src="public/js/app.js"></script>
	<script type="text/javascript" src="public/js/diameter-calc.js"></script>
</body>
</html>