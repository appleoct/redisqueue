<?php
include_once 'Queue.class.php';

include_once 'Message.php';

$para = $argv[1]; //命令行方式获取传过来的参数值
$arr = unserialize($para);

$message = new Message();


$message->send($arr['user_id'], $arr['mobile'], $arr['content']);



//模拟发信息

?>