<?php 
class Mysqlconnect
{
    private function connect()
    {
        $array = include 'db_config.php';
        	
        $con = mysql_connect($array['DB_HOST'],$array['DB_USER'],$array['DB_PWD']) or die('链接数据库失败');
        	
        mysql_select_db($array['DB_NAME'],$con) or die("没该数据库：".$array['DB_NAME']);
        	
        mysql_query("SET NAMES UTF8");
    }

    public function query($sql) {
        $this->connect();
        return mysql_query($sql);
    }
    
    public function affected_rows()
    {     
        return mysql_affected_rows();
    }

    public function getRow($sql, $limited = false)
    {
        if ($limited == true)
        {
            $sql = trim($sql . ' LIMIT 1');
        }

        $res = $this->query($sql);
        if ($res !== false)
        {
            return mysql_fetch_assoc($res);
        }
        else
        {
            return false;
        }
    }

    public function getAll($sql)
    {
        $res = $this->query($sql);
        if ($res !== false)
        {
            $arr = array();
            while ($row = mysql_fetch_assoc($res))
            {
                $arr[] = $row;
            }

            return $arr;
        }
        else
        {
            return false;
        }
    }
}
?>