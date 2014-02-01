 <?php
@session_start();
//echo "<pre>";
//print_r($_SESSION) ;
require("twitter/twitteroauth.php");
require 'config/twconfig.php';
//session_start();
$twitteroauth = new TwitterOAuth(YOUR_CONSUMER_KEY, YOUR_CONSUMER_SECRET);
// Requesting authentication tokens, the parameter is the URL we will be redirected to
$request_token = $twitteroauth->getRequestToken('http://enochsystems.mastersoftwaresolutionsindia.com/google/cont/socialLoginJS.php');
// Saving them into the session
$_SESSION['oauth_token'] = $request_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

// If everything goes well..
if ($twitteroauth->http_code == 200) {
    // Let's generate the URL and redirect
    $url = $twitteroauth->getAuthorizeURL($request_token['oauth_token']);

} else {
    // It's a bad idea to kill the script, but we've got to know when there's an error.
    die('Something wrong happened.');
}
?>
<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<title>Social login Demo</title>
 <div class="col6">
		   <a href='javascript:void(0);' id='Loginfb' onclick='fbLogin()'><img style='width:200px' alt="Login with Facebook" src='fb-login.png'></a>
</div>	
             
     <div class="col6">	
		  <a href='javascript:void(0);' id='Logingoogle' onclick='login()'><img style="width: 180px;margin-left: 7px;" alt="Login with google" src='sign-in-with-google.png'></a>
	   </div>
	<div class="col6">
	    <a href='javascript:void(0);' id='twlogin' onclick="window.open('<?php echo $url; ?>','myWindow','width=500,height=300')"><img style="height: 36px; width: 178px; margin-left: 7px; margin-top: 19px;" src="TwitterLogin.png"></a>
	</div>
	
	
<?php
//ob_start();
//require("twitter/twitteroauth.php");
//require 'config/twconfig.php';
//require 'config/functions.php';
//session_start();
//echo '<pre>';
$secret=$_SESSION['oauth_token_secret'];
$token=$_REQUEST['oauth_token'];
$verifier=$_REQUEST['oauth_verifier'];
if (!empty($verifier) && !empty($token) && !empty($secret)) {
    $twitteroauth = new TwitterOAuth(YOUR_CONSUMER_KEY, YOUR_CONSUMER_SECRET, $token, $secret);
    $access_token = $twitteroauth->getAccessToken($verifier);
    $user_info = $twitteroauth->get('account/verify_credentials');
	$content=$twitteroauth->get('statuses/home_timeline');
    echo '<pre>';
	//print_r($user_info);
	if($user_info){
	$_SESSION['twid']=$user_info->id;
	$_SESSION['twname']=$user_info->name;
	$_SESSION['twUname']=$user_info->screen_name;
	if(isset($_SESSION['twid']))	{?>
	<script type="text/javascript">
	//alert('ok working');
	window.close();
	</script>
	
<?php }
	if($_SESSION['twname']){?>
	<script type="text/javascript">
	alert('ok working!!!');
	location.reload();
	</script>
<?php	}

}else{

}
}
?>

 <script>
        var OAUTHURL    =   'https://accounts.google.com/o/oauth2/auth?';
        var VALIDURL    =   'https://www.googleapis.com/oauth2/v1/tokeninfo?access_token=';
        var SCOPE       =   'https://www.googleapis.com/auth/plus.me https://www.googleapis.com/auth/analytics.readonly https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile';
        var CLIENTID    =   '260127444904.apps.googleusercontent.com';
        var REDIRECT    =   'http://enochsystems.mastersoftwaresolutionsindia.com/google/cont/' ;
        var LOGOUT      =   'http://accounts.google.com/Logout';
        var TYPE        =   'token';
        var _url        =   OAUTHURL + 'scope=' + SCOPE + '&client_id=' + CLIENTID + '&redirect_uri=' + REDIRECT + '&response_type=' + TYPE;
        var acToken;
        var tokenType;
        var expiresIn;
        var user;
        var loggedIn    =   false;
    
        function login() {
            var win         =   window.open(_url, "windowname1", 'width=800, height=600'); 
            var pollTimer   =   window.setInterval(function() { 
                try {
                    console.log(win.document.URL);
                    if (win.document.URL.indexOf(REDIRECT) != -1) {
                        window.clearInterval(pollTimer);
                        var url =   win.document.URL;
                        acToken =   gup(url, 'access_token');
                        tokenType = gup(url, 'token_type');
                        expiresIn = gup(url, 'expires_in');
                        win.close();

                        validateToken(acToken);
                    }
                } catch(e) {
                }
            }, 500);
        }

        function validateToken(token) {
            $.ajax({
                url: VALIDURL + token,
                data: null,
                success: function(responseText){  
                    getUserInfo();
                    loggedIn = true;
                    $('#loginText').hide();
                    $('#logoutText').show();
                },  
                dataType: "jsonp"  
            });
        }

        function getUserInfo() {
            $.ajax({
                url: 'https://www.googleapis.com/oauth2/v1/userinfo?access_token=' + acToken,
                data: null,
                success: function(resp) { console.log(resp);
                //$('#status').append("<tr><td>"+resp.id+"</td><td>"+resp.name+"</td><td>"+resp.email+"</td></tr>");
                  /*  user    =   resp;
                    console.log(user);
                    $('#uName').text('Welcome ' + user.name);
                    $('#imgHolder').attr('src', user.picture);*/
					  $.ajax({async:true, /*complete:function (XMLHttpRequest, textStatus){
					check_end();}, */
				//data:$("#Question_FormIndexForm").serialize(), 
				//type:"POST", 
				contentType:'application/json;Charset=UTF-8' ,
					
				url:'user-info.php?data='+encodeURIComponent(JSON.stringify(resp)),
			//	dataType:"html", 
			//data:  encodeURIComponent(JSON.stringify(resp)) ,
				success:function (data, textStatus) {
				location.reload();
				if(data=='authenticateuser')
				{
			 	
				 //location.href="contests";
				}
				//alert("success"); alert(encodeURIComponent(JSON.stringify(resp)));
					/*if(nextQuestion==""){
						calculateResponse();
				}else{
						$("#question").html(data);
				}*/
				}, 
				});
                },
                dataType: "jsonp"
            });
        }

        //credits: http://www.netlobo.com/url_query_string_javascript.html
        function gup(url, name) {
            name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
            var regexS = "[\\#&]"+name+"=([^&#]*)";
            var regex = new RegExp( regexS );
            var results = regex.exec( url );
            if( results == null )
                return "";
            else
                return results[1];
        }

        function startLogoutPolling() {
            $('#loginText').show();
            $('#logoutText').hide();
            loggedIn = false;
            $('#uName').text('Welcome ');
            $('#imgHolder').attr('src', 'none.jpg');
        }

    </script>
	 
	 
	 <!-------Facebook---->
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
			<td><a href="session_chk.php">Logout</a></td>
		</tr>		
</table>
<script>
$('#Loginfb').hide();
$('#Logingoogle').hide();
$('#twlogin').hide();
</script>
<?php }else{ ?>

<script>
$('#Loginfb').show();
$('#Logingoogle').show();
$('#twlogin').show();
</script>

<?php } ?>

