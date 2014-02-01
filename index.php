 <?php
@session_start();
//echo "<pre>";
//print_r($_SESSION) ;

?>
<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<title>Social login Demo</title>
<div id="login">

             
     <div class="col6">	
		  <a href='javascript:void(0);' id='Logingoogle' onclick='login()'><img style="width: 180px;margin-left: 7px;" alt="Login with google" src='sign-in-with-google.png'></a>
	   </div>
	
	
</div>	


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
$('#login').hide();
//$('#Logingoogle').hide();
//$('#twlogin').hide();
</script>
<?php }else{ ?>

<script>
//$('#login').show();
//$('#Logingoogle').show();
//$('#twlogin').show();
</script>

<?php } ?>

