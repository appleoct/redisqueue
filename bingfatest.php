<?php
include_once 'mysql.php';

$connect = new Mysqlconnect();

$good_id = 1;

//$connect->query('START TRANSACTION');

//$good_sql = "select * from good where id = ".$good_id." for update";

$good_sql = "select * from good where id = ".$good_id;

try{
    
    $current_good = $connect->getRow($good_sql);
    
    if(!empty($current_good))
    {
        $goods_num = $current_good['goods_num'];
    
        $version = $current_good['version'];
    
        if($goods_num > 0)
        {
            //
            $new_num = $goods_num - 1;
            $new_version = $version + 1;
    
            //更新产品
            $update_sql = "update good set goods_num = ".$new_num.",version = ".$new_version." where id = ".$good_id." and version = ".$version;
            
           // $update_sql = "update good set goods_num = ".$new_num.",version = version + 1 where id = ".$good_id." and version = ".$version;
            //$update_sql = "update good set goods_num = ".$new_num." where id = ".$good_id;
            
            $update = $connect->query($update_sql);
       
            $affected_rows =  $connect->affected_rows();
            
            if($update && $affected_rows)
            {
                
                $insert_sql = "insert into buy_log(info,add_time) values('购买','".date('Y-m-d H:i:s',time())."')";
    
                $insert = $connect->query($insert_sql);
    
                //$connect->query ( 'COMMIT' );
            }else
            {
                throw new Exception ( "33" );
            }
        }else
        {
            throw new Exception ( "22" );
        }
    
    }else
    {
        throw new Exception ( "11" );
    }
    
    
}catch (Exception $e){
    
    //$connect->query('ROLLBACK');
    
    echo $e->getMessage();
}


?>