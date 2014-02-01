<?php
session_start();
require("twitter/twitteroauth.php");
require 'config/twconfig.php';
$twitteroauth = new TwitterOAuth(YOUR_CONSUMER_KEY, YOUR_CONSUMER_SECRET);
// Requesting authentication tokens, the parameter is the URL we will be redirected to
$request_token = $twitteroauth->getRequestToken('http://enochsystems.mastersoftwaresolutionsindia.com/Social-login/logintwitter.php');
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
<title>Social login Demo</title>
<div id="login">
<div class="col6">
	    <a href="<?php echo $url; ?>" id='twlogin' ><img src="TwitterLogin.png" style="margin-top: 15px; margin-left: 1px; width: 188px; height: 43px;"></a>
	</div>
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
	//$_SESSION['twname']=$user_info->name;
	//$_SESSION['twUname']=$user_info->screen_name;
	echo "<table border=1px><tr><th>Profile ID</th><th>Name</th><th>User Name</th><th>Logout</th></tr>";
	echo "<tr><td>".$user_info->id."</td>";
	echo "<td>".$user_info->name."</td>";
	echo "<td>".$user_info->screen_name."</td>";
	echo "<td><a href='twlogout.php'>Logout</a></td></tr>";
	echo "</table>";
	//print_r($user_info);
?>
	<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
	<script>
	//alert('ok working');
	$('#login').hide();
	//$('#Logingoogle').hide();
	//$('#twlogin').hide();
	</script>
<?php
}else{ ?>
<script>
	//alert('ok working');
	$('#login').show();
	//$('#Logingoogle').hide();
	//$('#twlogin').hide();
	</script>
<?php	
}
}
?>






