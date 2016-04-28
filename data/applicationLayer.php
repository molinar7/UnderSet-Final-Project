<?php
	header('Content-type: application/json');
	require_once __DIR__ . '/dataLayer.php';
	
	$action = $_POST['action'];
	
	
	switch($action)
	{
		case 'REG':	registerAction();// Register a user
						break;

		case 'LOGIN':	loginAction(); // Login
						break;

		case 'COOKIE':	cookieAction();
		break;

		case 'DS':	deleteSession();
						break;

		case 'LS':	selectEvents();// Select an event in the requet page
						break;

		case 'SR':	sendRequest();// Send request to database
						break;

		case 'CS':	checkSession();// Check if the session exist and if the session user is an administrator
						break;

		case 'CE':	creatEvent();// Inserts a new event to the database
						break;

		case 'DE':	displayEvents();// Displays all the upcoming events on the page
						break;

		case 'DR':	displayRequests();// Displays all the requests of the user in the page.
						break;
							
							
		
	}

	function displayRequests(){
		$result = getRequests();

		echo json_encode($result);
		
	}

	function displayEvents(){
		$result = getupcomingE();

		for($k = 0 ; $k< sizeof($result); $k ++){		
				echo ("<tr>" ."<td>" . $result[$k]['eventName']. "</td>" . "<td>" . $result[$k]['eventDate']. "</td>". "<td>" . $result[$k]['eventLoc']. "</td>". "</tr>");
		 	}
	}

	function creatEvent(){
		$evN = $_POST['eN'];
		$evL = $_POST['eL'];
		$evD = $_POST['eD'];

		insertEvent($evN, $evL,  $evD);
		
	}

	function checkSession(){
		session_start();
		if(isset($_SESSION['login_user'])){
			$user = $_SESSION['login_user'];
			if ($user == 'admin') 
				echo 1;// the user is an admin
			else
				echo 2;

		}else{
			echo 0;
		}
	}

	function sendRequest(){// Send request to database

		session_start();

		if(isset($_SESSION['login_user'])){

			$user = $_SESSION['login_user'];
			$eNam = $_POST['eN'];
			$cNum = $_POST['cN'];
			$uReas = $_POST['uReason'];
			insertRequest($eNam, $cNum, $uReas, $user);
		}else{
			echo 3;// session does not exist
		}
		
	}


	function selectEvents(){
		$result = getEvent();
		

		for($k = 0 ; $k< sizeof($result); $k ++){		
				echo ("<option>". $result[$k]['eventName'].   '</option>' );
		 	}


	}


	function registerAction(){

		$firstN = $_POST['firstname'];
		$lastN = $_POST['lastname'];
		$userN = $_POST['username'];
		$userE = $_POST['email'];
		$userP = encryptPassword();

		$userG = $_POST['gender'];
		$userC = $_POST['country'];

		
		registerUser($firstN,$lastN,$userN,$userE,$userP,$userG,$userC);
	}

	function loginAction(){

		
		$userN = $_POST['username'];
		$userP = $_POST['password'];
		$cBox = $_POST['checkB'];

		$result = validateUser($userN);
		$encryptPassword = $result['password'];
		$decryptedPassword = decryptPassword($encryptPassword);

		$log= login($userN, $encryptPassword, $cBox);// This methods validates more and creates cookies and sections
		
		if($decryptedPassword == $userP && $log == 1 ){

			if($cBox == 1)  // Setting the cookies
		   			setcookie('usernameCookie', $userN, time() + 3600 * 720, '/');

		   echo 1;// Result must be '1' if username and password are correct

		}
			
		else
			echo 0;// result must be 0 if the username and password are incorrect

		
	}


	function cookieAction(){

		
		if (isset($_COOKIE['usernameCookie'])){
			echo json_encode(array("cookieValue" => $_COOKIE["usernameCookie"]));
			
		}
	
	else
	{
		
		die(json_encode(array('message' => 'Cookie not set')));
	}
}// end of coockieaction

	function deleteSession (){
		$response =1;
		session_start();

	
	if(isset($_SESSION['login_user']))
	{
		$response = 0;
		unset($_SESSION['login_user']);
		session_destroy();
		echo $response; 	    
	}
	else
	{	
		$response = 0;
		//header('HTTP/1.1 406 Session has expired, you will be redirected to the login');
		echo $response;
	}
}



function encryptPassword()
	{
		$userPassword = $_POST['password'];

	    $key = pack('H*', "bcb04b7e103a05afe34763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");
	    $key_size =  strlen($key);
	    
	    $plaintext = $userPassword;

	    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
	    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	    
	    $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $plaintext, MCRYPT_MODE_CBC, $iv);
	    $ciphertext = $iv . $ciphertext;
	    
	    $userPassword = base64_encode($ciphertext);

	    return $userPassword;
	}

	function decryptPassword($password)
	{
		$key = pack('H*', "bcb04b7e103a05afe34763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");
	    
	    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
	    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    	
	    $ciphertext_dec = base64_decode($password);
	    $iv_dec = substr($ciphertext_dec, 0, $iv_size);
	    $ciphertext_dec = substr($ciphertext_dec, $iv_size);

	    $password = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
	   	
	   	
	   	$count = 0;
	   	$length = strlen($password);

	    for ($i = $length - 1; $i >= 0; $i --)
	    {
	    	if (ord($password{$i}) === 0)
	    	{
	    		$count ++;
	    	}
	    }

	    $password = substr($password, 0,  $length - $count); 

	    return $password;
	}



	?>