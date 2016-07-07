<?php

include_once 'mysql.php';
class Message
{
    public $db;
    
    public function __construct()
    {
        $db = new Mysqlconnect();
    
        $this->db = $db;
    }
    
    /*
     * 
     * @param unknown $user_id 用户id
     * @param unknown $mobile 手机号
     * @param unknown $content 信息内容*/
    
    public function send($user_id , $mobile , $content)
    {
         $sql = "insert into message (user_id, mobile ,content) values('".$user_id."', '".$mobile."' , '".$content."')";
        
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
}
?>