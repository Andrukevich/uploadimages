<?php
include_once("data.php");

function checkUploadDir($uploaddir)
{
    file_exists( "$uploaddir") ? null : mkdir("$uploaddir");
}

function connectionDB($dbname, $host, $charset, $user, $pass)
{
    $opt = array(
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    );
    $dsn = "mysql:host=$host;charset=$charset";
    try {
        $pdo = new PDO($dsn, $user, $pass, $opt);
        $pdo = checkTableDB($dbname, $host, $charset, $user, $pass, $opt);
    } catch (PDOException $e) {
        recordInLog($e->getMessage());
        header("Location: ../error/error.php?desc=connection_to_DB");
    }

    return $pdo;
}

function checkTableDb($dbname, $host, $charset, $user, $pass, $opt)
{
    $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
    try {
        $pdo = new PDO($dsn, $user, $pass, $opt);
    } catch (PDOException $e) {
        recordInLog($e->getMessage());
        $pdo = createTableDB($dbname, $host, $charset, $user, $pass, $opt);
//        header("Location: ../error/error.php?desc=error_checked_db");
    }

    return $pdo;
}

function createTableDB($dbname, $host, $charset, $user, $pass, $opt)
{

    $dsn = "mysql:host=$host;charset=$charset";
    $pdo = new PDO($dsn, $user, $pass, $opt);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS {$dbname}");
    $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
    $pdo = new PDO($dsn, $user, $pass, $opt);

    $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT(6) AUTO_INCREMENT PRIMARY KEY,
            name_user VARCHAR(80) NOT NULL,
            email VARCHAR(60) NOT NULL,
            password VARCHAR(70) NOT NULL,
            UNIQUE (email)
            );";

    $pdo->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS files (
            id INT(6) AUTO_INCREMENT PRIMARY KEY,
            user_id INT(6) NOT NULL,
            full_path TEXT NOT NULL,
            path TEXT NOT NULL,
            name_file TEXT NOT NULL,
            type_file VARCHAR(10) NOT NULL,
            FOREIGN KEY (user_id) REFERENCES users(id)
            );";

    $pdo->exec($sql);

    return $pdo;

}

function recordInLog($message)
{
    $fileName = 'log.txt';
    $handle = fopen('log/' . $fileName, 'a');
    fwrite($handle, date('Y-m-d H:i:s') . ': ' . $message . PHP_EOL);
    fclose($handle);
}

function isPost()
{
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function is_in_str($str,$substr)
{
    $result = strpos ($str, $substr);
    if ($result === FALSE)
        return false;
    else
        return true;
}

function checkFormat($type_file, $path, $name_file) {
	switch ($type_file) {
		case "jpg":
		case "JPG":
		case "jpeg":
		case "png":
		case "gif":
			break;
		default:
            try {
                throw new Exception('Check login and password');
            } catch (Exception $e) {
                recordInLog($e->getMessage());
                header("Location: ../error/error.php?desc=check_login_and_password");
            }
			break;
	}

	return ['path' => $path, 'name_file' => $name_file, 'type_file' => $type_file];

}


