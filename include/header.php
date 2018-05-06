<?php error_reporting( E_ERROR ); ?>
<?php session_start() ?>
<?php include_once("data.php") ?>
<?php include_once("functions.php") ?>
<?php
if (isset($_SESSION['user_id']) && !is_in_str($_SERVER['REQUEST_URI'], 'fullimage')) {
    include_once("connection.php");
    header('Location: ../upload.php');
} else if (!is_in_str($_SERVER['REQUEST_URI'], 'login') && !is_in_str($_SERVER['REQUEST_URI'], 'fullimage')) {
    include_once("data.php");
    include_once("functions.php");
    checkUploadDir($uploaddir);
    connectionDB($dbname, $host, $charset, $user, $pass);
    header('Location: ../login.php');
} else {
    include_once("connection.php");
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Andrukevich-Eugene-test-php</title>

	<!-- Favicon -->
	<link rel="shortcut icon" href="../image/favicon-logo-php.jpg">

	<!-- Developer CSS -->
	<link href="../css/style.css" rel="stylesheet">
</head>

<?php if (isset($_SESSION['user_id'])) : ?>

    <section class="info-user">
        <h2 class="cp-pull-left">Welcome, <span><?php

                $stmt = $pdo->prepare('SELECT name_user FROM users WHERE id = :id');
                $stmt->execute(array('id' => $_SESSION['user_id']));
                $row = $stmt->fetch();

                echo $row['name_user'];

                ?>! </span></h2>

        <h3 class="cp-pull-right"><a id="nodecor"  href="logout.php">Log out</a></h3>
    </section>
    <div class="cp-clearfix"></div>

<?php endif; ?>
