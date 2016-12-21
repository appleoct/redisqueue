<?php

    echo phpinfo();exit;
    //连接本地的 Redis 服务
   $redis = new Redis();
   $redis->connect('192.168.33.10', 6379);
   echo "Connection to server sucessfully";
         //查看服务是否运行
   echo "Server is running: " . $redis->ping();
?>