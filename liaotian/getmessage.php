<?php
    //出队操作
    include_once dirname(dirname(__FILE__)).'/Redis.class.php';
    $redis = new Redis_model();
    
    $content = $redis->RPOP('send_content');
    
    $content = unserialize($content);
    
    if(!empty($content))
    {
        $arr = array('0'=>'success','1'=>$content['time'],'2'=>$content['message']);
    }else
    {
        $arr = array('0'=>'fail');
    }
    
    echo json_encode($arr);
?>