<?php session_start(); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>退出。。。</title>
</head>

<body>
<?php
session_destroy();
echo "<script> window.location.href='login.php';</script>";
?>

</body>
</html>