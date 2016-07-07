<?php
include_once 'Queue.class.php';
/* $arr = array(
    "uid" => 4,
    "uids" => array(6,234,34,67,7888,2355), //接收信息的人的UID
    "content" => 'esd',
);
$queue = new Queue();
$queue->add("/vagrant/timer/send_msg.php", serialize($arr)); */

include_once 'mysql.php';

$connect = new Mysqlconnect();

$all_demo_user_sql = "select id,mobile from demo_user";
$user_result = $connect->getAll($all_demo_user_sql);

$queue = new Queue();
foreach ($user_result as $key => $value)
{
    $arr = array(
        'user_id' => $value['id'],
        'mobile' => $value['mobile'],
        'content' => '恭喜你收到短信', 
    ); 
    
    $queue->add("/vagrant/timer/send_msg.php", serialize($arr)); 
}

//生成队列




?>