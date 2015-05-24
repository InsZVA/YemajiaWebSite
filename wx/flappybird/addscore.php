<?php
session_start();
require_once '../common.php';
addscore($_SESSION['openid'],$_SESSION['score']);
?>
<script>location.href=document.referrer</script>