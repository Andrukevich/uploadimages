<?php error_reporting( E_ERROR ); ?>
<?php session_start() ?>
<?php require_once "include/functions.php" ?>
<?php require_once "include/connection.php"; ?>
<?php
if (isPost()) {
    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = :email AND password = :password ');
    $stmt->execute(array('email' => $_POST['email'],
        'password' => $_POST['pass']));
    $row = $stmt->fetch();

    if(strlen($row['id'])!=0) {
        $_SESSION['user_id']=$row['id'];
        header("Location: upload.php");
    } else {
        try {
            throw new Exception('Check login and password');
        } catch (Exception $e) {
            recordInLog($e->getMessage());
            header("Location: ../error/error.php?desc=check_login_and_password");
        }
    }
}
?>

<?php include_once("include/header.php"); ?>

<body class="login">
<form name="register" action="" method="post">
	<h2 class="cp-text-center">Login for registered user</h2>
	<div class="cp-form-group">
			<input name="email" type="email" class="cp-form-control" id="inputEmail3" placeholder="Email" required>
	</div>
	<div class="cp-form-group">
			<input name="pass" type="password" class="cp-form-control" id="inputPassword3" placeholder="Password" required>
	</div>
	<div class="cp-form-group">
			<button type="submit" class="cp-btn cp-btn-success" name="login">Sign in</button>
	</div>
	<div class="cp-form-group">
			<h4>Not registered?&nbsp;&nbsp;&nbsp;<a href= "register.php">Sign up now!</a></h4>
	</div>
</form>
</body>

<?php include_once("include/footer.php"); ?>

