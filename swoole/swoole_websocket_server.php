<?php
include_once 'user.php';
include_once 'Redis.class.php';

$server = new swoole_websocket_server("0.0.0.0", 9501);

$server->on('open', function (swoole_websocket_server $server, $request) {
    //echo "server: handshake success with fd{$request->fd}\n";  
    
    echo "建立client链接".$request->fd."\n";
    
    user::getInstance()->set($request->fd,array());
    
  
});

$server->on('message', function (swoole_websocket_server $server, $frame) {
   //echo PHP_EOL."receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
    $redis = new Redis_model();
    
   $content =  $frame->data;

   $new_data = json_decode($content,true);
   
   
   $all_user = user::getInstance()->getAll();
   
   
   if(!empty($new_data))
   {
       $type = $new_data['type'];
       
       $nickname = $new_data['nickname'];
       
       if($type == 'connect')
       {
           //获取聊天记录
           $liaotian_history_count = $redis->LLEN('liaotian_history');
           
           if($liaotian_history_count <= 50)
           {
               $histories = $redis->LRANGE('liaotian_history',0,$liaotian_history_count-1);
           }else 
           {
               $beign = $liaotian_history_count - 50;
               
               $histories = $redis->LRANGE('liaotian_history',$beign,$liaotian_history_count-1);
               
           }
            
           if(!empty($histories))
           {
               foreach ($histories as $k => $va)
               {
                   //给刚上线的那位发送
                  $server->push($frame->fd, $va);         
               }
           }
           
           
           //提示上线
           user::getInstance()->set($frame->fd,array('nickname'=>$nickname));
           foreach ($all_user as $key => $value)
           {
               //              
               if($key !== $frame->fd)
               {
                  $last_data ="<span style='color:blue'>【系统消息】</span>".$nickname.'上线了';
                  $server->push($key, $last_data);
               }
           }
           
       }else
       {
           
           
           $message = $new_data['content_message'];
           
           $time = date('Y-m-d H:i:s',time());
           
           //记录历史记录
           $history = "<span style='color:green'>【历史记录】</span>".$nickname."对大家说:".$message.$time;
            
           $redis->RPush('liaotian_history',$history);
            
           foreach ($all_user as $key => $value)
           {
               //
               if($key == $frame->fd)
               {
                   $data = "<span style='color:red;'>我对大家说</span>:";
               }else
               {
                   $data = "<span style='color:red;'>".$nickname."对大家说</span>:";
               }
               
              
                
               $last_data = $data.$message.$time;     
                
               $server->push($key, $last_data);
           }
       } 
   }
   
  
});

$server->on('close', function ($ser, $fd) {
    //关闭的话讲对应用户删除
    
    $close_user = user::getInstance()->get($fd);
    
    
    user::getInstance()->del($fd);
    
    $all_user = user::getInstance()->getAll();
  
    if(!empty($all_user))
    {
        foreach ($all_user as $key => $value)
        {
            $last_data ="<span style='color:blue'>【系统消息】</span>".$close_user['nickname'].'下线了';
            $ser->push($key, $last_data);
        } 
    }
    
   
});

$server->start();
?>