<?php 	//authenticate.php
require_once 'login.php';
require_once 'sanitize.php';

	$connection = new mysqli($hn, $un, $pw, $db);
	if ($connection->connect_error) die($connection->connect_error);

	if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
		$un_temp = mysql_entities_fix_string($connection, $_SERVER['PHP_AUTH_USER']);
		$pw_temp = mysql_entities_fix_string($connection, $_SERVER['PHP_AUTH_PW']);

		$query = "SELECT * FROM users WHERE username='$un_temp'";
		$result = $connection->query($query); 

		$query = "SELECT * FROM users WHERE password='$pw_temp'";
		$resulttwo = $connection->query($query);

		if (!($result) || !($resulttwo)) die($connection->error);
		elseif ($result->num_rows) {
			$row = $result->fetch_array(MYSQLI_NUM);
			$result->close();
			$resulttwo->close();
			$salt1 = "qm&h*"; $salt2 = "pg!@";
			$token = hash('ripemd128', "$salt1$pw_temp$salt2");

if ($token == $row[3]) {
				session_start();
				$_SESSION['username'] = $un_temp;
				$_SESSION['password'] = $pw_temp;
				echo "Hello, you are now logged in as '$un_temp'";
				die ("<p><a href=webpage5.php>Click here to continue</a></p>");
			}
			else die("Invalid username/password combination");
		}
		else die("Invalid username/password combination");
	}
	else 	{
		header('WWW-Authenticate: Basic realm="Restricted Section"');
		header('HTTP/1.0 401 Unauthorized');
		die ("Please enter your username and password");
	}
	$connection->close();
?>


