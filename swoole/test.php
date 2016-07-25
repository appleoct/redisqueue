<?php
session_start();
$_SESSION['url'] = 'http://www.phpddt.com';
echo 'value:'.$_SESSION['url'];
echo "<a href='test1.php?".session_name()."=".session_id()."'>another</a>";
?>