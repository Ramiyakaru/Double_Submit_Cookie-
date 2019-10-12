	
<!DOCTYPE html>
<html>
<head>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <title>Cross Site Request Forgery Protection</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body background="css/images/back.jpg">
    <h2 style="font-family:Calibri;" class="heading">Welcome</h2>
    <?php
		if(isset($_POST['submit']))
		{
    		//ob_end_clean(); 
    
    
    		if($_POST['user_name'] =="admin" && $_POST['user_pswd'] =="admin") //hard coded user credentials
    		{
				
				session_start();//start session in browser

				$sessionID = session_id(); //Setting and storing session ID
			
				
				if(empty($_SESSION['key']))
				{
					$_SESSION['key']=md5(uniqid(rand(),true));
				}
			
				$token = hash_hmac('sha256',$sessionID,$_SESSION['key']);//generate CSRF token

				//Setting 2 cookies
				setcookie("session_id_ass2",$sessionID,time()+3600,"/","localhost",false,true); //cookie terminates after 1 hour - HTTP only flag
                
    			setcookie("csrf_token",$token,time()+3600,"/","localhost",false,true); //csrf token cookie

				

				echo '
                    <div class="container">
                    <form  method="POST" action="server.php">
			           <div class="form-input">
                        <label class="uname">Username:</label>  
                        <input class="w3-input w3-border" type="text" name="user_name"  placeholder="Your name" style="width:300px;" autocomplete="off">
                        </div><br> 
                        
                        <input type="submit" name="submit" class="login_btn" value="Update"/>

					

						<div class="spacing"><input type="hidden" id="csToken" name="CSR" value="'.$token.'"/></div>
						
					</form>
                    </div>';
	
    		}
    		else
    		{
				header( "Location:other/errorlogin.html" );
    		}

		}


?>

</body>
</html>
