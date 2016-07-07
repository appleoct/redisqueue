<?php
class Curl
{
    //url 请求地址 data 请求所带参数
    /*
     * $data = "Order_sn=".urlencode($no_order)
						."&TranAmt=".urlencode($money)
						."&LoginName=".urlencode('nbb')
						."&Password=".urlencode('bmJiMTIzNDU2')
						."&call_back=".urlencode($call_back);*/
    public function curl_nav($curl,$data ,$timeout = 5)
    {
        if($curl == "" || $timeout <= 0){
            
            return false;
        }
        
        $url = $curl.'?'.$data;
       
        $con = curl_init((string)$url);
        curl_setopt($con, CURLOPT_HEADER, false);
        curl_setopt($con, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($con, CURLOPT_TIMEOUT, (int)$timeout);
    	$return = curl_exec ( $con );
    	curl_close ( $con );     	
    	return $return;
    }
}
?>