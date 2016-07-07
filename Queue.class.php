<?php
/**
 *
 * 任务队列实现
 *
 */
    
include_once 'mysql.php';

class Queue
{
      
    /**
     * 把任务扔到队列
     *
     * @param string $taskphp   执行任务的程序
     * @param string $param     执行任务程序所用的参数
      
     * 例如，群发消息加入队列：
     * $arr = array(
     *      "uid" => 4,//发信息的人的UID
     *      "uids" => array(6,234,34,67,7888,2355), //接收信息的人的UID
     *      "content" => 'xxxxx',//信息内容
     *  );
     * $cqueue = new Queue();
     * $cqueue->add("/app/send_msg.php", serialize($arr));
     *
     */
    public $db;
    
    public function __construct()
    {
        $db = new Mysqlconnect();
        
        $this->db = $db;
    }
    
    public function add($taskphp,$param)
    {
        //$param = mysql_real_escape_string($param);
        $param = $param;
       
        $sql = "insert into queue (taskphp, param) values('".$taskphp."', '".$param."')";
        $re = $this->db->query($sql);
        if ($re)
        {
            $pid = mysql_insert_id();
            return $pid;
        }
        else
        {
            return false;
        }
    }
      
      
    /**
     * 读取任务队列
     * 
     * @param string $limit 一次取多少条
     */
    //单进程方式
/*      public function getQueueTask($limit = 1000)
     {
        $limit = (int)$limit;
        $sql = "select id, taskphp, param from queue  where status = 0 order by id asc";
        $re = $this->db->getAll($sql);
        return $re;
     } */
     
     //多进程方式
     public function getQueueTask($total , $i , $limit = 1000)
     {
         $limit = (int)$limit;
         
         $j = $i - 1;
         
         if($j < 0)
         {
             $j = 0;
         }
         
         $sql = "select id, taskphp, param from queue  where status = 0 and id % $total =$j order by id asc limit ".$limit;
         $re = $this->db->getAll($sql);
         return $re;
     }
      
    /**
     * 更新任务状态
     * 
     * @param string $limit 一次取多少条
     */
     public function updateTaskByID($id)
     {
        $id = (int)$id;
        $mtime = time();
        $sql = "update queue  set status =1 where id = ".$id;
        $re = $this->db->query($sql);
        return $re;
     }
      
      
     public static function a2s($arr)
    {
        $str = "";
        foreach ($arr as $key => $value)
        {
            if (is_array($value))
            {
                foreach ($value as $value2)
                {
                    $str .= urlencode($key) . "[]=" . urlencode($value2) . "&";
                }
            }
            else
            {
                $str .= urlencode($key) . "=" . urlencode($value) . "&";
            }
        }
        return $str;
    }
      
    public static function s2a($str)
    {
        $arr = array();
        parse_str($str, $arr);
        return $arr;
    }
}
      
?>
