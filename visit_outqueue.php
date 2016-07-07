<?php
//出队
include_once 'Redis.class.php';
include_once 'mysql.php';
include_once 'curl.class.php';

$conn = new Mysqlconnect();
//出队
$redis = new Redis_model();
$curl = new Curl();

$i = 10;
while($i > 0)
{
    $seal = $redis->RPOP('order_queue');
    
    if(!empty($seal))
    {
        $arr = unserialize($seal);
    
        $visit_id = $arr['visit_id'];
        
        $order_id = $arr['order_id'];
        
        $order_url = $arr['order_url'];
        
        //curl 访问
        $data = 'order_id='.urlencode($order_id);
        $url = $order_url;
        $result =$curl->curl_nav($url,$data,5);
        
        $current_visit_sql = "select visit_count from visit where id = ".$visit_id;
        
        if($result == 'success')
        {
            //代表用户收到请求并且执行成功
            $current_visit = $conn->getRow($current_visit_sql);
            
            if(!empty($current_visit))
            {
                $visit_newcount = $current_visit['visit_count'] + 1;
                $update_visit_sql = "update visit set visit_count = ".$visit_newcount.",status = 1 where id = ".$visit_id;
                $conn->query($update_visit_sql);
                
            }
        }else
        {
            //不响应或者响应错误信息，则继续添加到队列
            //查询当前url响应次数
            $current_visit = $conn->getRow($current_visit_sql);
            
            if(!empty($current_visit))
            {
                if($current_visit['visit_count'] <= 4)
                {
                    //满足继续添加到队列 先更新次数，再添加到队列
                    $visit_newcount = $current_visit['visit_count'] + 1;
                    $update_visit_sql = "update visit set visit_count = ".$visit_newcount." where id = ".$visit_id;
                    $update = $conn->query($update_visit_sql);
                    if($update)
                    {
                        //添加到队列
                        //组成新的数据插入队列
                        $new_queue = array(
                            'visit_id' => $visit_id,
                            'order_id' => $order_id,
                            'order_url' => $order_url,
                        );
                        
                        $queue_order = serialize($new_queue);
                        
                        $result = $redis->LPush('order_queue',$queue_order);
                    }
                    
                }
            }
        }
    }
    
    sleep(rand()%3);
    
    $i --;
}
?>