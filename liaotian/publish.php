<?php

    $content = $_GET['content'];
    
    if(!empty($content))
    {
        include_once dirname(dirname(__FILE__)).'/Redis.class.php';
        
        $redis = new Redis_model();
        
        $redis->PUBLISH('test', $content);
        
        $arr = array('0'=>'success');
        
        echo json_encode($arr);
    }
?>