<?php
session_start();
require_once "include/functions.php";
require_once "include/connection.php";

//Прием данных и создание пользователя в БД в случае валидных данных
if (isPost()) {

	$stmt = $pdo->prepare("INSERT INTO users (name_user, email, password) VALUES (:name_user, :email, :password)");
	$stmt->bindParam(':name_user', $_POST['name_user']);
	$stmt->bindParam(':email', $_POST['email']);
	$stmt->bindParam(':password', $_POST['pass']);
	$stmt->execute();

	$stmt = $pdo->prepare('SELECT id FROM users WHERE email = :email AND password = :password ');
	$stmt->execute(array('email' => $_POST['email'],
		'password' => $_POST['pass']));
	$row = $stmt->fetch();

	if(strlen($row['id'])!=0) {
		$_SESSION['user_id']=$row['id'];
		header("Location: upload.php");
	} else {
		require_once("errors/repeatemail.php");
	}

}


?>

<?php include_once("include/header.php"); ?>

<body class="register">

<!--Форма отправки данных пользователя для регистрации-->
<form name="register" action="" method="post">
    <h2 class="cp-text-center">Registration</h2>
	<div class="cp-form-group">
			<input name="name_user" type="name" class="cp-form-control" id="inputName3" placeholder="Name" required>
	</div>
	<div class="cp-form-group">
			<input name="email" type="email" class="cp-form-control" id="inputEmail3" placeholder="Email" required>
	</div>
	<div class="cp-form-group">
			<input name="pass" type="password" class="cp-form-control" id="inputPassword3" placeholder="Password more than 8 symbols" pattern="\w{8,}" required>
	</div>
	<div class="cp-form-group">
			<button type="submit" class="cp-btn cp-btn-success" name="login">Sign up</button>
	</div>
	<div class="cp-form-group">
			<h4>Already registered?&nbsp;&nbsp;&nbsp;<a href= "login.php">Log in!</a>!</h4>
	</div>
</form>


</body>

<?php include_once("include/footer.php"); ?>

