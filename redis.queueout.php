<?php
//出队操作
include_once 'Message.php';
include_once 'Redis.class.php';

$redis = new Redis_model();
$message = new Message();

$i = 10;
while($i > 0)
{
    $seal = $redis->RPOP('mobile_message');
    
    if(!empty($seal))
    {
        $arr = unserialize($seal);
        
        $message->send($arr['0'], $arr['1'], $arr['2']);
    }
    
    sleep(rand()%3);
    
    $i --;
}
?>