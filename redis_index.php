<?php
$redis = new Redis();
$redis->connect('192.168.33.10', 6379);
//$redis->set('test','hello world!');
//print_r($redis->keys('user:1'));exit;
//var_dump($redis->keys('*'));exit;

//$redis->lPush("dsadsa",'baba'); 
//$redis->del("dsadsa");exit;
var_dump($redis->keys('*'));exit;
//var_dump($redis->get('test'));
/* $redis->lPush("lal-list",'baba');
$redis->lPush("lal-list",'mama');
$redis->lPush("lal-list",'laopo');  */

/* $first = $redis->RPop("lal-list");
echo $first;  */
/* $redis->del("lal-list");exit;
for ($i = 1;$i <= 10;$i++)
{
    $redis->lPush("lal-list",$i);
    //$redis->lPush("lal-list",$i);
} */
/* $j = 10;
while ($j > 0)
{
  
    echo $redis->rPop("lal-list");
    $j -- ;
}
exit; */
//$redis->blPop();

//$redis->del("lal-list");
// $arList = $redis->lrange("lal-list", 0 ,10);

//print_r($arList);exit; 


exit;
?>