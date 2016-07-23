<?php
session_start();
//设置用户

if(!empty($_POST['nickname']))
{
    //将用户信息存入session中号了

    
    $_SESSION['nickname'] = trim($_POST['nickname']);
    
    header("Location:websocket_client.php");
}
        
?>