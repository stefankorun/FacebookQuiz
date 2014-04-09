<?php

require_once("fb-sdk/src/facebook.php");
require_once 'classes/User.php';

$config = array(
    'appId' => '649697948411720',
    'secret' => '64cbda50eb4afdda6ab07acea8189164',
    'allowSignedRequest' => false // optional but should be set to false for non-canvas apps
);

$facebook = new Facebook($config);
$user_id = $facebook->getUser();
?>
<html>
<head>
    <meta charset="utf-8"/>
</head>
<body>

<?php
if($user_id) {

      // We have a user ID, so probably a logged in user.
      // If not, we'll get an exception, which we handle below.
      try {

        $user_profile = $facebook->api('/me?fields=id,name','GET');
        $name = $user_profile['name'];
        $fbid = $user_profile['id'];
        
        $user = new User();
        $user_info = $user->getUserInfo($fbid);
        if($user_info != NULL){
        	$user->setUserInfo($user_info);
        }
        else{
        	$user->addUser($fbid, $name, "email@gmail.com", "077111222");
        }
        print_r($user->getInfo());
        
        
        /*$params = array( 'next' => 'http://localhost/FacebookQuiz/fb.php' );
        $logout_url = $facebook->getLogoutUrl($params);
        echo '<a href="'.$logout_url.'">logout</a>';*/
        
        if(isset($_GET['logout'])){
        	if($_GET['logout']){
        		echo "LOGOUTTTT";
        		$facebook->destroySession();
        	}
        }

      } catch(FacebookApiException $e) {
        // If the user is logged out, you can have a 
        // user ID even though the access token is invalid.
        // In this case, we'll get an exception, so we'll
        // just ask the user to login again here.
        $login_url = $facebook->getLoginUrl(); 
        echo 'Please <a href="' . $login_url . '">login.</a>';
        error_log($e->getType());
        error_log($e->getMessage());
        
        
      }   
    } else {

      // No user, print a link for the user to login
      $login_url = $facebook->getLoginUrl();
      echo 'Please <a href="' . $login_url . '">login.</a>';

    }

?>

<form action="" method="get">
	<input type="submit" value="logout" name="logout">
</form>

</body>
</html>