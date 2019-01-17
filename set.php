<?php
	require_once './connect.php';
	$asd = "asd";
	$password = sha1($asd);

	$sql = "UPDATE Users SET password='$password' WHERE id=4";

	$conn->query($sql);
?>