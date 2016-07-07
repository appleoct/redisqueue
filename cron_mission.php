<?php

date_default_timezone_set('Asia/Shanghai');

$now = time();
$ymd = date('Y-m-d',$now);
$day = date('N',$now);
$hour = date('H',$now);
$minute = date('i',$now);
$second = date('s',$now);
$week = date('D',$now);

//print $now.'<br />'.$ymd."<br />".$day."<br />".$hour."<br />".$minute."<br />".$second."<br />".$week;

$phpcmd = exec("which php");

//$site_dir = dirname(__FILE__);

//每N分钟执行一次 队列任务
if($minute % 5 == 0)
{
    //单进程执行
    /*$cmd = $phpcmd ." do_queue.php >> doQueueMission".date('Y-m-d',time()).".log"; 
    echo date('Y-m-d H:i:s')."\t:".$cmd."\n";
    system($cmd);*/
    
    //多进程 10代表开启进程数
    for($i = 1; $i <= 10 ;$i ++)
    {
        $cmd = $phpcmd ." do_queue.php 10 $i >> doQueueMission".date('Y-m-d',time()).".log";
        echo date('Y-m-d H:i:s')."\t:".$cmd."\n";
        system($cmd);
    }
}
