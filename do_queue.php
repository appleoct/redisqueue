<?php
include_once 'Queue.class.php';

$queue = new Queue();

//多进程形式
$total = $argv[1]; //命令行方式获取传过来的参数值 进程总数
$i = $argv[2];//命令行方式获取传过来的参数值  当前进程数

//单进程形式处理
//$tasks = $queue->getQueueTask(200);

//多进程形式处理
$tasks = $queue->getQueueTask($total , $i , 200);

$phpcmd = exec("which php");//获取linux php命令路径
foreach ($tasks as $t)
{
    $id = $t['id'];
    $taskphp = $t['taskphp'];
    $param = $t['param'];
    $job = $phpcmd . " " . escapeshellarg($taskphp) . " " . escapeshellarg($param);
    echo date('Y-m-d H:i:s')."\t:".$job."\n";
    system($job);
    $queue->updateTaskByID($id);
}

?>