<?php
	require_once './connect.php';

	$raw_data = file_get_contents("php://input");

	function check_username($username){
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
					echo "login success";
				} else {
					echo "wrong password";
				}
			}
		} else {
			$check_username = "SELECT COUNT(*) FROM Users WHERE username='$username'";
			if ($query_result = $conn->query($check_username)) {
				// var_dump($query_result->fetchColumn());
				if($query_result->fetchColumn() > 0){
					// echo "match";
					$fetch_prep = $conn->prepare("SELECT * FROM Users WHERE username='$username'");
					$fetch_prep->execute();

					// echo (json_encode($fetch_prep->fetch(PDO::FETCH_ASSOC)));
					echo "match"
				} else {
					echo "nomatch";
				}
			}
		}
	} else {
		echo "error";
	}
?>