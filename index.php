<!DOCTYPE html>
<html>
<head>
    <title>Quiz</title>
    <meta charset="utf-8"/>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <link href='//fonts.googleapis.com/css?family=Open+Sans:700,400,300&subset=latin,cyrillic' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="design/css/style.css">


</head>
<body>
<header>
    <div class="">
        Овозможено од
    </div>
    <h1>
        <a href="http://www.edukacijaanimacija.com/" target="_blank">
           АУТОДЕСК МАКЕДОНИЈА
        </a>
    </h1>
</header>
<div class="main">
    <div class="quiz_container">
        <div class="status_container">Прашање 1/20</div>
        <div class="qa_container">
	           <div class="question">
	                Шо е работава?
	           </div>
	           <div class="answers_container container-fluid">
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
	           		if($user_id) {
				
				      // We have a user ID, so probably a logged in user.
				      // If not, we'll get an exception, which we handle below.
				      try {
				
				        $user_profile = $facebook->api('/me?fields=id,name','GET');
				        $name = $user_profile['name'];
				        $fbid = $user_profile['id'];
				        
				       
				      	$u=new User();
						$userinfo=$u->getUserInfo($fbid);
						if($userinfo==NULL){
							
						}else{
							$u->setUserInfo($userinfo);
							$u->getNextQuestion();
							if(isset($_POST['questionId']) && isset($_POST['answer']));
							$u->validateAnswer('23432',1,3);
						}
						
				        
				        
				
				      } catch(FacebookApiException $e) {
				        // If the user is logged out, you can have a 
				        // user ID even though the access token is invalid.
				        // In this case, we'll get an exception, so we'll
				        // just ask the user to login again here.
				        $login_url = $facebook->getLoginUrl(); 
				        header("location:".$login_url);
				      
				        error_log($e->getType());
				        error_log($e->getMessage());
				        
				        
				      }   
				    } else {
				
				      // No user, print a link for the user to login
				      $login_url = $facebook->getLoginUrl();
					  header("location:".$login_url);
				      
				
				    }


	
					
					           		
	           ?>
	           </div>
        </div>
        <div class="submit_button">
            Одговори
        </div>
    </div>
</div>
<footer>

</footer>
</body>
</html>