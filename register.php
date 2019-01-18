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

	$insert_prep = $conn->prepare("INSERT INTO Users (username, password, firstName, lastName) VALUES ('$username', '$hashed_password', '$first_name', '$last_name')");

	if(isset($raw_data)){
		$jsondata = json_decode($raw_data);
		$username = $jsondata->username;
		$password = $jsondata->password;
		$hashed_password = sha1($password);
		$first_name = $jsondata->firstName;
		$last_name = $jsondata->lastName;

		if($insert_prep->execute()){
			echo (json_encode("success"));
		} else {
			echo (json_encode("error"));
		}

	}
?>