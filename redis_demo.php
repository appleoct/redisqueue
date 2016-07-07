<?php
//入队操作

include_once 'Redis.class.php';
include_once 'mysql.php';

$conn = new Mysqlconnect();
//先尝试一条
$user_sql = "select id,mobile from demo_user limit 20";

$result = $conn->getAll($user_sql);

$redis = new Redis_model();

if(!empty($result))
{
    foreach ($result as $key => $value)
    {
        $arr = array();
        
        array_push($arr, $value['id']);
        array_push($arr, $value['mobile']);
        
        $content = '我是用redis的测试短信';
        array_push($arr, $content);
        
       // print_r($arr);exit;
       // echo serialize($arr);
        
        $redis->LPush('mobile_message',serialize($arr));
        
        echo $key;
        
    }
}



?>