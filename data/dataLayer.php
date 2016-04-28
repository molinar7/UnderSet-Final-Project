<?php

	function connect()
	{
		$servername = "localhost";
		$username = "root";
		$password = "root";
		$dbname = "UnderSet";


		$connection = new mysqli($servername, $username, $password, $dbname);
	
		// Check connection
		if ($connection->connect_error) 
		{
		    return null;
		}
		else
		{
			return $connection;
		}
	}

	function errors($type)
	{
		$header = "HTTP/1.1 ";

		switch($type)
		{
			case 500:	$header .= "500 Bad connection to Database";
						break;
			case 206:	$header .= "206 Wrong Credentials";
						break;
			case 406:	$header .= "406 User Not Found";
						break;
			case 417:	$header .= "417 No content set in the cookie/session";
						break;
			default:	$header .= "404 Request Not Found";
		}

		header($header);
		return array('message' => 'ERROR', 'code' => $type);
	}

	function getRequests(){

		$conn = connect();
			
			if($conn != null){

    			$sql ="SELECT ID , username, cNumber, reason FROM Requests "; 
			 	$result = $conn->query($sql);

			 	$storeArray = Array();
			 	
				while($row = $result->fetch_assoc()) {
		       		
				$response = array('eventID'=>$row['ID'], 'user'=> $row['username'],'contactN'=> $row['cNumber'],'uReason'=> $row['reason']);
				array_push($storeArray , $response );
		    	}
		    	return $storeArray;
		   }
		    
	}

	function getupcomingE(){

		$conn = connect();


    	if($conn != null){

    			$sql ="SELECT eName , eDate, eLocation FROM Events "; 
			 	$result = $conn->query($sql);

			 	$storeArray = Array();
			 	
				while($row = $result->fetch_assoc()) {
		       		
				$response = array('eventName'=>$row['eName'], 'eventDate'=> $row['eDate'],'eventLoc'=> $row['eLocation']);
				array_push($storeArray , $response );
		    	}
		    	return $storeArray;
		    }

	}

	function checkifeventexists($evN,  $evD){// No puede haber otro evento con el mismo nombre en la misma fecha
		$conn = connect();
		 if ($conn != null)
        {
        	$sql ="SELECT eName FROM Events WHERE eDate = '$evD' AND eName = '$evN'";
			$result = $conn->query($sql);
			if ($result->num_rows > 0)
				return 1;
			else
				return 0;
			
   		 }

	}

	function insertEvent($evN, $evL, $evD){

		$check = checkifeventexists($evN,  $evD);// 0= does not exist, 1= event already exists
		
		$conn = connect();
		if($conn != null && $check == 0){

    		$sql = "INSERT INTO Events ( eName,eDate, eLocation)VALUES
				('$evN','$evD', '$evL')";

			if ($conn->query($sql) === TRUE) 
				echo 1;
			
		
		}
		else
				echo 2;// The event already exists
	}

	

	function getEventID($eNam){
		$conn = connect();
		 if ($conn != null)
        {
        	$sql ="SELECT ID FROM Events WHERE eName = '$eNam'";
			$result = $conn->query($sql);
			if ($result->num_rows > 0)
				while($row = $result->fetch_assoc()) 
					return $row['ID'];
			
   		 }

	}// End of getEventID

	function insertRequest($eNam, $cNum, $uReas, $user){

		$eID = getEventID($eNam);// This gets the event id
		$conn = connect();

		if($conn != null){

    		$sql = "INSERT INTO Requests (ID,eName,username,cNumber, reason, AD)VALUES
				('$eID','$eNam', '$user', '$cNum', '$uReas', ' ')";

			if ($conn->query($sql) === TRUE) 
				echo 1;
			else
				echo 2;// The request had already been sent
		
		}
	}

	function registerUser($firstN,$lastN,$userN,$userE,$userP,$userG,$userC){
    	$conn = connect();

    	if($conn != null){

    		$sql = "INSERT INTO Users (fName, lName, username, passwrd, eMail,gender,country)
			VALUES ('$firstN', '$lastN', '$userN', '$userP', '$userE', '$userG','$userC')";

			if ($conn->query($sql) === TRUE) {
				echo 1;

				startSession($userN);// Si lo ponia en applicationLayer no me funcionaba y aqui si!

			}
			else
				echo 0;
    	}
    }// end of register user

    function login($username, $userP, $cBox)
    {

        $conn = connect();
		
        if ($conn != null)
        {
        	$sql ="SELECT fName, passwrd FROM Users WHERE username = '$username' AND passwrd = '$userP'";
			$result = $conn->query($sql);

			if ($result->num_rows > 0)
			{
				startSession($username);// Si lo hacia llamar en applicationLayer no jalaba!!!!! y en dataLayer si!!!PS AHora no jala en ni una

				$response =1;// La constraseña y el usuario si coincidieron con uno de la base de datos
			    return $response;
			} else {
			    $response = 0;// Username or password are incorrect
				return $response;

			}
    }
}// end of function login



function getEvent(){
	$conn = connect();


    	if($conn != null){

    			$sql ="SELECT eName , eDate FROM Events "; 
			 	$result = $conn->query($sql);

			 	$storeArray = Array();
			 	
				while($row = $result->fetch_assoc()) {
		       		
				$response = array('eventName'=>$row['eName'], 'eventDate'=> $row['eDate']);
				array_push($storeArray , $response );
		    	}
		    	return $storeArray;
		    }


}

function startSession($userN)
    {

		// Starting the session
	    session_start();

	   
		$_SESSION['login_user']= $userN;
		
		//print_r($_SESSION);

    }

        function validateUser($userName)
    {
        # Open and validate the Database connection
    	$conn = connect();

        if ($conn != null)
        {
        	$sql = "SELECT * FROM Users WHERE username = '$userName'";
			$result = $conn->query($sql);
			
			# The current user exists
			if ($result->num_rows > 0)
			{
				while($row = $result->fetch_assoc()) 
		    	{
					$conn->close();
					return array("status" => "COMPLETE", "fName" => $row['fName'], "lName" => $row['lName'], "password" => $row['passwrd']);
				}
			}
			else
			{
				# The user doesn't exists in the Database
				$conn->close();
				return array("status" => "ERROR");
			}
        }
        else
        {
        	# Connection to Database was not successful
        	$conn->close();
        	return array("status" => "ERROR");
        }
    }


?>