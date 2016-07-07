<?php
class Redis_model
{
    
    public $redis;
    public function __construct()
    {
        $this->redis = new Redis();       
        $this->redis->connect('192.168.33.10', 6379);
        //$this->redis->connect('127.0.0.1', 6379);
    }
    
    public function SET($key)
    {
        //设置redis 键值为key的内容 只能操作字符串
        return $this->redis->set($key);
    }
    
    public function GET($key)
    {
        //获取redis 键值为key的内容 只能操作字符串
        return $this->redis->get($key);
    }
    
    public function LPush($key , $value = '')
    {
        //操作列表 将value内容存入到键值为key的列表中
        return $this->redis->lPush($key,$value);
    }
    
    public function RPush($key , $value = '')
    {
        //操作列表 将value内容存入到键值为key的列表中
        return $this->redis->rPush($key,$value);
    }
     
    public function LPOP($key)
    {
        //移出并获取列表的第一个元素 
        return $this->redis->LPOP($key);
    }
    
    public function RPOP($key)
    {
        //移出并获取列表的最后一个元素 
        return $this->redis->RPOP($key);
    }
    
    public function BLPOP($key , $timeout = 0)
    {
        //移出并获取列表的第一个元素， 如果列表没有元素会阻塞列表直到等待超时或发现可弹出元素为止。
        return $this->redis->blPop($key , $timeout);
    }
    
    public function BRPOP($key , $timeout = 0)
    {
        //移出并获取列表的最后一个元素， 如果列表没有元素会阻塞列表直到等待超时或发现可弹出元素为止。
        return $this->redis->brPop($key , $timeout);
    }
    
    public function LRANGE($key,$start = 0 , $count = 0)
    {
        //获取列表指定范围内的元素 从第start开始向后去count 个
        return $this->redis->lrange($key ,$start ,$count);
    } 
}
?>