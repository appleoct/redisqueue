<?php
define('title','聊天室');
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
            <?php echo title;?>
        </h1>
        
        <div style="border:1px solid red;height:300px; overflow:scroll; margin-bottom:20px;">
            <table id="message_table">
                
            </table>
        </div>
        
        <form>
            发送聊天内容:
            <textarea rows="5" cols="100" id="content_message">
            
            </textarea>
         <input type="button" id="send_message" value="发送" />
        </form>
    </div>

   
    
    <script>
		function getMessage()
		{
			//alert('1111');
			$.getJSON('getmessage.php',function(data){
				if(data['0'] == 'success')
				{
					console.log('success');

					$('#message_table').append("<tr><td>"+ data['1'] +"</td><td>"+data['2']+"</td></tr>");
				}
			});
		};
    
		$(function(){			
			$("#send_message").click(function(){
				var content = $('#content_message').val();				
				//将内容发布到频道				
				$.getJSON('publish.php',{content:content},function(data){
					if(data['0'] == 'success')
					{
						console.log('success');
						$('#content_message').val('');
					}
				});
			});

			setInterval(getMessage,1000);
		});	
    </script>
</body>
</html>