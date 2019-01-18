<?php require_once './connect.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<title>Test</title>
</head>
<body>
	<?php echo "test"; ?>
	<?php 
		global $conn;
		$username = "juancho";
		$check_username = "SELECT COUNT(*) FROM Users WHERE username='$username'";
			if ($query_result = $conn->query($check_username)) {
				// var_dump($query_result->fetchColumn());
				if($query_result->fetchColumn() > 0){
					// echo "match";
					$fetch_prep = $conn->prepare("SELECT * FROM Users WHERE username='$username'");
					$fetch_prep->execute();
					$user_details = $fetch_prep->fetch(PDO::FETCH_ASSOC);
					var_dump($user_details);
				}
			}
	?>
</body>
</html>