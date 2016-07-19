<?php
//订阅监听内容
include_once dirname(dirname(__FILE__)).'/Redis.class.php';
$redis = new Redis_model();

$redis->SUBSCRIBE(array('test'),function($rediss, $channel, $message){
    //监听到内容后将 内容放到list
    $redis = new Redis_model();
    
    $list = array(
        'time' => date('Y-m-d H:i:s',time()),
        'message' => $message
    );
    
    $send_content = serialize($list);
    $redis->LPush('send_content',$send_content);
    exit;
});
?>