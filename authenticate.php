<?php
	require_once './connect.php';

	if(isset($_SERVER['HTTP_ORIGIN'])){
		//header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
		//Allow access using wildcard
		header('Access-Control-Allow-Origin: *');
		header('Content-type: application/json');
		header('Access-Control-Allow-Credentials: true');
		header('Access-Control-Max-Age: 86400');
	}

	if($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
		if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])){
			header("Access-Control-Allow-Method: GET, POST, OPTIONS");
		}
		if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])){
			header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
		}

		exit(0);

	}

	$raw_data = file_get_contents("php://input");

	function check_username($username){
		global $conn;
		$check_username = "SELECT COUNT(*) FROM Users WHERE username='$username'";
		if ($query_result = $conn->query($check_username)) {
			// var_dump($query_result->fetchColumn());
			if($query_result->fetchColumn() > 0){
				// echo "match";
				$fetch_prep = $conn->prepare("SELECT * FROM Users WHERE username='$username'");
				$fetch_prep->execute();
				$user_details = $fetch_prep->fetch(PDO::FETCH_ASSOC);
				return $user_details;
			} else {
				return FALSE;
			}
		}
	}

	if(isset($raw_data)) {
		$jsondata = json_decode($raw_data);
		$username = $jsondata->username;
		if(isset($jsondata->password)){
			$password = $jsondata->password;
			$hashed_password = sha1($password);
			if($container = check_username($username)){
				$hashed_upassword = $container['password'];
				if($hashed_password == $hashed_upassword){
					echo (json_encode($container));
				} else {
					echo (json_encode("wrong password"));
				}
			}
		} else {
			if($container = check_username($username)){
				echo (json_encode("match"));
			} else {
				echo (json_encode("nomatch"));
			}
		}
	} else {
		echo (json_encode("error"));
	}
?>