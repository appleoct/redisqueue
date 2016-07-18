<?php
//发布信息
include_once 'Redis.class.php';
$redis = new Redis_model();

$redis->PUBLISH('test', '2222'); 

?>