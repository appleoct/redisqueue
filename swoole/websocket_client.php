<?php
session_start();
define('title','聊天室');

if(!isset($_SESSION['nickname']))
{
    header("Location: http://192.168.33.10:8050/swoole/login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>首页</title>
    <script type="text/javascript" src="jquery-1.9.1.min.js"></script>
    <style>
        *{margin:0px; padding:0px;}
        #content{width:80%; margin:0px auto;}
        
    </style>
</head>
<body>
    <div id="content">
         <h1 style="margin:20px auto;text-align:center;">
            <?php echo title;?> welcome ! <?php echo $_SESSION['nickname'];?>
        </h1>
        
        <div style="border:1px solid red;height:300px; overflow:scroll; margin-bottom:20px;">
            <table id="message_table">
                
            </table>
        </div>
        
        <form>
            发送聊天内容:
            <textarea rows="5" cols="100" id="content_message"></textarea>
         <input type="button" id="send_message" value="发送" />
        </form>
    </div>

   
    
    <script>
    
    //websocket
    var exampleSocket = new WebSocket("ws://192.168.33.10:9501");
	  exampleSocket.onopen = function (event) {
	  };


	  exampleSocket.onmessage = function (event) {
		  //php 端收到信息之后再返回
	    //console.log(event.data);	    
	    $('#message_table').append("<tr><td>"+event.data+"</td></tr>");
	 }

		var nickname = "<?php echo $_SESSION['nickname'];?>";
	    
    	$('#send_message').click(function(){

          var content_message = $('#content_message').val();

          if(content_message == "")
          {
        	  alert('内容不能为空');
              return false;   			
          }else
          {
              var content = nickname + "," + content_message;
          	
    		  exampleSocket.send(content); 
    		  
    		  $('#content_message').val(''); 		 
    		  	 
          }
        });
    	
    </script>
</body>
</html>