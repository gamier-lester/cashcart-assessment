<?php
	// define("DBUSER", "root");
	// define("DBPASS", "");
	// define("DBHOST", "localhost");
	// define("DBNAME", "assessment-db");
	define("DBUSER", "juancho");
	define("DBPASS", "foreverinlov3");
	define("DBHOST", "todoapponetwo");
	define("DBNAME", "db4free.net");
	
	if(isset($_SERVER['HTTP_ORIGIN'])){
		header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
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
?>