<?php
ob_start();
require("twitter/twitteroauth.php");
require 'config/twconfig.php';
require 'config/functions.php';
session_start();
echo '<pre>';
$secret=$_SESSION['oauth_token_secret'];
$token=$_REQUEST['oauth_token'];
$verifier=$_REQUEST['oauth_verifier'];
if (!empty($verifier) && !empty($token) && !empty($secret)) {
    $twitteroauth = new TwitterOAuth(YOUR_CONSUMER_KEY, YOUR_CONSUMER_SECRET, $token, $secret);
    $access_token = $twitteroauth->getAccessToken($verifier);
    $user_info = $twitteroauth->get('account/verify_credentials');
	$content=$twitteroauth->get('statuses/home_timeline');
    echo '<pre>';
	print_r($user_info);
	echo $user_info->id."<br>";
	echo $user_info->name."<br>";
	echo $user_info->screen_name."<br>";
	echo '</pre><br/>';	
}
?>
