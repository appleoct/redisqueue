<?php
session_start();
define('title','聊天室');

if(!isset($_SESSION['nickname']))
{
    header("Location:login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>首页</title>
    <script type="text/javascript" src="jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="jquery.qqFace.js"></script>
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
        
      
            发送聊天内容:
            <div id="content_message" style="width:500px;height:200px; border:1px solid red;" contenteditable="true">
                
            </div>
            
             <div class="emotion">表情</div>
            <input type="button" id="send_message" value="发送" />
     
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


		//打开页面直接发送一条信息
		

		  $(function(){
	 	    	$('.emotion').qqFace({
		    		id : 'facebox', //表情盒子的ID
		    		assign:'content_message', //给那个控件赋值
		    		path:'face/'	//表情存放的路径
		    	}); 

		    	$('#send_message').click(function(){

		            var content_message = $('#content_message').html();

		            if(content_message == "")
		            {
		          	  alert('内容不能为空');
		                return false;   			
		            }else
		            {
		                var content = nickname + "," + content_message;
		            	
		      		  exampleSocket.send(content); 
		      		  
		      		  $('#content_message').html(''); 		 
		      		  	 
		            }
		          });
		    	
		    });
		 
		 
	
	    
    	
    	
    </script>
</body>
</html>