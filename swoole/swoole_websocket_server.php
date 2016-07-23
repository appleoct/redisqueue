<?php
include_once 'user.php';

$server = new swoole_websocket_server("0.0.0.0", 9501);

$server->on('open', function (swoole_websocket_server $server, $request) {
    //echo "server: handshake success with fd{$request->fd}\n";
    
    echo PHP_EOL."服务端接收到客户端发送信息,客户端请求id为".$request->fd."\n";    
    
    user::getInstance()->set($request->fd,"client_id:{$request->fd}");
  
});

$server->on('message', function (swoole_websocket_server $server, $frame) {
   //echo PHP_EOL."receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
   
    
   $content =  $frame->data;
   
   $new_data = json_decode($content,true);
   
   
   //$all_user = user::getInstance()->getAll();
   
  // print_r($all_user);
   
   if(!empty($new_data))
   {
        
       $nickname = $new_data['nickname'];
        
       $message = $new_data['content_message'];
        echo $message;
      
       //echo "收到客户端 id号为:".$frame->fd." 信息为:".$frame->data." opcode:".$frame->opcode." fin:".$frame->finish."\n";
       //发送信息给客户端 frame->data为客户端发送过来的信息 重组加个时间
       $data = $nickname.date('Y-m-d H:i:s',time()).':'.$message;
       
       $all_user = user::getInstance()->getAll();
       
       foreach ($all_user as $key => $value)
       {
           $server->push($key, $data);
       }
   }
   
  
});

$server->on('close', function ($ser, $fd) {
    //关闭的话讲对应用户删除
    user::getInstance()->del($fd);
    echo "client {$fd} closed\n";
});

$server->start();
?>