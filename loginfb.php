 <?php
 @session_start();
 ?>
 <title>Social login Demo</title>
 <div id="login">
 <div class="col6">
		   <a href='javascript:void(0);' id='Loginfb' onclick='fbLogin()'><img style='width:200px' alt="Login with Facebook" src='fb-login.png'></a>
</div>	
</div>


 <!-------Facebook---->
 	  <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
	  <script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '256586367851758', // Set YOUR APP ID
      channelUrl : '<?php echo $_SERVER['HTTP_HOST'].'/users/'; ?>', // Channel File
      status     : true, // check login status
      cookie     : true, // enable cookies to allow the server to access the session
      xfbml      : true  // parse XFBML
    });
 
    FB.Event.subscribe('auth.authResponseChange', function(response) 
    {
     if (response.status === 'connected') 
    {
   //     document.getElementById("message").innerHTML +=  "<br>Connected to Facebook";
        //SUCCESS
 
    }    
    else if (response.status === 'not_authorized') 
    {
        document.getElementById("message").innerHTML +=  "<br>Failed to Connect";
 
        //FAILED
    } else 
    {
        document.getElementById("message").innerHTML +=  "<br>Logged Out";
 
        //UNKNOWN ERROR
    }
    }); 
 
    };
 
    function fbLogin()
    {
 
        FB.login(function(response) {
           if (response.authResponse) 
           {
                getUserInfo1();
            } else 
            {
             console.log('User cancelled login or did not fully authorize.');
            }
         },{scope: 'email,user_photos,user_videos'});
 
    }
 
  function getUserInfo1() {
        FB.api('/me', function(response) {console.log(response);
        $('#status').append("<tr><td>"+response.id+"</td><td>"+response.name+"</td><td>"+response.email+"</td></tr>");
		console.log(response);
		  $.ajax({async:true, 
				contentType:'application/json;Charset=UTF-8' ,
				data:response,
				type:'POST',	
				url:'user-info.php?data='+encodeURIComponent(JSON.stringify(response)),
				
				success:function (data, textStatus) {
				location.reload(); 
				if(data=='authenticateuser')
				{
				// location.href="contests";
				}
				
				}, 
				});
				
      var str="<b>Name</b> : "+response.name+"<br>";
          str +="<b>Link: </b>"+response.link+"<br>";
          str +="<b>Username:</b> "+response.username+"<br>";
          str +="<b>id: </b>"+response.id+"<br>";
          str +="<b>Email:</b> "+response.email+"<br>";
    
          str +="<input type='button' value='Logout' onclick='Logout();'/>";
       //   document.getElementById("status").innerHTML=str;
 
    });
    }
  
    function Logout()
    {
        FB.logout(function(){document.location.reload();});
    }
 
  // Load the SDK asynchronously
  (function(d){
     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/en_US/all.js";
     ref.parentNode.insertBefore(js, ref);
   }(document));
 
</script>





<?php if(!empty($_SESSION['data'])) { ?>
<table border=1px>
	<tr>
		<th>Profile Id</th>
		<th>User Email</th>
		<th>User Name</th>		
		<th>Logout</th>
	</tr>
		<tr>
			<td><?php echo $_SESSION['data']->id ;?></td>
			<td><?php echo $_SESSION['data']->email ;?></td>
			<td><?php echo $_SESSION['data']->name ;?></td>
			<td><a href="fblogout.php">Logout</a></td>
		</tr>		
</table>
<script>
$('#login').hide();
//$('#Logingoogle').hide();
//$('#twlogin').hide();
</script>
<?php }else{ ?>

<script>
$('#login').show();
//$('#Logingoogle').show();
//$('#twlogin').show();
</script>

<?php } ?>
