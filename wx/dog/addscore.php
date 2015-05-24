<?php
session_start();
require_once '../common.php';
addscore2($_GET['openid'],$_GET['score']);
?>
<script>location.href=document.referrer</script>