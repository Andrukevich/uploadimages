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
<body class="center">
<div class="animated rollIn" style="text-align: center; margin-top: 200px;">
    <h1 class="text-center text-danger">ERROR</h1>
    <h1 class="text-center text-danger"><?php echo strtoupper(str_replace('_', ' ', $_GET['desc'])); ?></h1>
</div>
</body>
<footer>
</footer>
<!-- JavaScript files placed at the end of the document so the pages load faster -->
<!-- Developer js -->
<script type="text/javascript" src="../js/dev.js"></script>
</html>