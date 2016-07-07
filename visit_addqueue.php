<?php
//入队请求
include_once 'Redis.class.php';
include_once 'mysql.php';

/*
 * 模拟订单数据
 * $array = array(
 *          'order_id' => '123', 订单号
 *          'order_url' => 'http://localhost', 订单回掉地址
 * )*/

$conn = new Mysqlconnect();

$redis = new Redis_model();


$order_arr = array(
    'order_id' => '1234',
    'order_url' => 'http://192.168.33.10:8050/test_curl.php',
);
//添加数据到数据库记录
$sql = "insert into visit (order_id, order_url ) values('".$order_arr['order_id']."', '".$order_arr['order_url']."')";

$re = $conn->query($sql);

 if ($re)
{
    $pid = mysql_insert_id();
    
    //组成新的数据插入队列
    $new_queue = array(
        'visit_id' => $pid,
        'order_id' => $order_arr['order_id'],
        'order_url' => $order_arr['order_url'],
    );
    
    $queue_order = serialize($new_queue);
    
    $result = $redis->LPush('order_queue',$queue_order);
    
    var_dump($result);exit;
}






?>