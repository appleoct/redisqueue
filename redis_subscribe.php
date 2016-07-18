<?php
//订阅demo
include_once 'Redis.class.php';
$redis = new Redis_model();
$redis->SUBSCRIBE(array('test'),function($redis, $channel, $message){
    echo $message;exit;
}); 

?>