<?php
session_start();

require_once "include/data.php";
require_once "include/functions.php";
require_once "include/connection.php";
//Добавление файла в БД с привязкой к текущему пользователю
if(isPost()){
	$stmt = $pdo->prepare("INSERT INTO files(user_id, full_path, path, name_file, type_file) 
							VALUES (:user, :full_path, :path, :name_file, :type_file)");
	$stmt->bindParam(':user', $user);
	$stmt->bindParam(':full_path', $full_path);
	$stmt->bindParam(':path', $path);
	$stmt->bindParam(':name_file', $name_file);
	$stmt->bindParam(':type_file', $type_file);

	$user = $_SESSION['user_id'];
	$full_name = strtotime('now') . '_' . $_FILES['file']['name'];
	$full_path = __DIR__  . "\\{$uploaddir}" . "\\{$full_name}";
	$path = "\\{$uploaddir}" . "\\{$full_name}";
	$arr = explode(".", $full_name);
	$name_file = $arr[0];
	$type_file = $arr[1];
    if ($type_file != "jpg" && $type_file != "JPG" && $type_file != "png" && $type_file != "gif" && $type_file != "jpeg") {
        recordInLog('upload_only_image');
        header("Location: error/error.php?desc=upload_only_image");
    } else {
        $stmt->execute();
        move_uploaded_file($_FILES['file']['tmp_name'], $full_path);
    }

}

?>


<?php include_once("include/header.php"); ?>

<body>

<section class="cp-text-center">
	<form enctype = 'multipart/form-data' method="post" action="<?= $_SERVER['REQUEST_URI'] ?>">
		<div class="cp-form-group">
			<label for="file"><h3>Upload image</h3></label>
			<input name="file" type="file" id="file" multiple>
		</div>
		<button type="submit" class="cp-btn cp-btn-success btn-lg">Upload</button>
	</form>
</section>

<section>

	<div class="col-50-percent">
		<h2>Your uploaded images</h2>
		<?php
		$stmt = $pdo->prepare('SELECT id, path, name_file, type_file FROM files WHERE user_id=:user_id ORDER BY id DESC');
		$stmt->execute(array('user_id' => $_SESSION['user_id']));
		$count = 0;
		while ($row = $stmt->fetch()) : ?>
			<?php
			$count += 1;
			$check_format = checkFormat($row['type_file'], $row['path'], $row['name_file']);
            ?>
			<div class="" style="display: inline-block; margin: 10px;">
                <a target="_blank" href="fullimage.php?img=<?php echo $check_format['name_file']. '.' . $check_format['type_file'] ?>">
                    <div style="text-align: center">
                        <img width="100" height="100" class="otstup" src="<?= $check_format['path'] ?>" alt="<?= $check_format['name_file'] ?>">
                    </div>
                    <div class="cp-clearfix"></div>
                    <span class="text-center"><?= $check_format['name_file'] ?></span>
                </a>
			</div>
		<?php endwhile; ?>
		<?php if($count == 0) : ?>
			<h3 class="bg-info">You have not uploaded files yet</h3>
		<?php endif; ?>
	</div>

<!--	Вывод файлов всех пользователей-->
	<div class="col-50-percent">
		<h2>Uploaded images all users</h2>
		<?php
		$stmt = $pdo->query('SELECT id, path, name_file, type_file FROM files ORDER BY id DESC');
		static $countcolumnusers = 0;
		$chechclearfix = "";
		$count = 0;
		while ($row = $stmt->fetch()) : ?>
			<?php
			$count += 1;
			$check_format = checkFormat($row['type_file'], $row['path'], $row['name_file']);
			$countcolumnusers += $occupetedcolumn;
			?>
            <div class="" style="display: inline-block; margin: 10px;">
                <a target="_blank" href="fullimage.php?img=<?php echo $check_format['name_file']. '.' . $check_format['type_file'] ?>">
                    <div style="text-align: center">
                        <img width="100" height="100" class="otstup" src="<?= $check_format['path'] ?>" alt="<?= $check_format['name_file'] ?>">
                    </div>
                    <div class="cp-clearfix"></div>
                    <span class="text-center"><?= $check_format['name_file'] ?></span>
                </a>
            </div>
		<?php endwhile; ?>
		<?php if($count == 0) : ?>
			<h3 class="bg-info">Nobody have not uploaded files yet</h3>
		<?php endif; ?>

	</div>

</section>

<?php include_once("include/footer.php"); ?>

