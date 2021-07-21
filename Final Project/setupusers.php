<?php //setupusers.php
	
	    require_once 'sanitize.php';
	    require_once 'login.php';
	   
	    $connection = new mysqli($hn, $un, $pw, $db);
	    if ($connection->connect_error) die($connection->connect_error);
	
	
	    echo <<<_END
	    <html>
	<head>
	<title>Sign Up Page</title>
	
	<script>
	
	function checkIfValid() {
	
	                username = document.forms["signup"]["username"];
	                password = document.forms["signup"]["password"];
	                email = document.forms["signup"]["email"];
	               
	                reg_email = /^\w+@[a-z]+\.(edu|com)$/;
	                reg_filter = /^[\w_-]+$/;
	                 
	                if(!reg_filter.test(username.value) || !reg_email.test(email.value) || !reg_filter.test(password.value)) {
	                   
	                    if(!reg_filter.test(username.value)){
	                        window.alert("username is not valid. Please re-enter\n");
	                    }
	               
	                    if(!reg_email.test(email.value)) {
	                        window.alert("Email is not valid. Please re-enter\n");
	                    }
	               
	                    if(!reg_filter.test(password.value)){
	                         window.alert("Password is not valid. Please re-enter\n");
	                    }
	                       
	                    return false;
	                }
	                return true;
	            }
	           
	</script>
	</head>
	<body>
	        <form id='signup' method='POST' action='setupusers.php' name='form' onsubmit="return CheckIfValid();">
	            <div class="container">
	                <h1>Sign Up</h1>
	                <p>Please fill in this form to create an account.</p>
	                <hr>
	               
	                <label for="username"><b>Enter Username:</b></label>
	                <input type="text" placeholder="Enter Username" name="username" required>
	                <br><br>
	           
	                <label for="email"><b>Enter Email:</b></label>
	                <input type="text" placeholder="Enter Email" name="email" required>
	                <br><br>
	               
	                <label for="psw"><b>Enter Password:</b></label>
	                <input type="password" placeholder="Enter Password" name="password" required>
	                <br><br>
	               
	                <div class="clearfix">
	                    <button type="submit" name = "submit" class="signupbtn">Sign Up</button>
	                    <button type="button" class="cancelbtn">Cancel</button>
	                </div>
	            </div>
	        </form>
	           
	_END;
	
	
	
	   
	    $query = "CREATE TABLE IF NOT EXISTS users (
	             username VARCHAR(32) NOT NULL UNIQUE,
	             password VARCHAR(32) NOT NULL,
	             email VARCHAR(50) NOT NULL UNIQUE,
	             cipher VARCHAR(32) NOT NULL,
	             timestamp TIMESTAMP NOT NULL,
	             data_encoded VARCHAR(255) NOT NULL,
	             data_decoded VARCHAR(255) NOT NULL
	            )";
	   
	    $result = $connection->query($query);
	    if (!$result) die($connection->error);
	   
	   
	    // we would probably need to wrap it like this
	    if (isset ($_POST['submit']))
	    {
	   
	        //sanitize using function in sanitize.php
	        $username = sanitizeMySQL($connect,$_POST['username']);
	        $password = sanitizeMySQL($connect,$_POST['password']);
	        $email = sanitizeMySQL($connect,$_POST['email']);
	       
	        //if the filter for the inputs are valid
	        if(checkInput($username, $password, $email) == true)
	        {
	            $salt1 = "qm&h*";
	            $salt2 = "pg!@";
	       
	            $token = hash('ripemd128', "$salt1$password$salt2");
	       
	            add_user($connect, $username, $token, $email);
	       
	            echo "Successfully signed in with<br>
	                    Username: '$username' <br>
	                    Email: '$email' <br>";
	
	            die ("<p><a href=login.php>Go back to login page.</a></p>");
	
	            $result->close();
	
	            $connection->close();
	        }
	   
	    }
	
	    function checkIfValid($username, $password, $email)
	    {
	        $reg_filter = "/^[\w_-]+$/";
	       
	        if(!preg_match($reg_email, $email) || !preg_match($reg_filter, $username) || !preg_match($reg_filter, $password))
	        {
	           
	            if(!preg_match(reg_filter, $username)) {
	                echo "Username is not valid. Please re-enter<br>";
	            }
	           
	            if(!preg_match(reg_filter, $password)) {
	                echo "Password is not valid. Please re-enter<br>";
	            }
	           
	            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	                echo "Email is not valid. Please re-enter<br>";
	            }
	           
	            return false;
	        }
	       
	        return true;
	    }
	   
	    function add_user($connection, $fn, $sn, $un, $pw)
	    {
	        $query = "INSERT INTO users VALUES('$fn', '$sn', '$un', '$pw')";
	        $result = $connection->query($query);
	        if (!$result) die($connection->error);
	    }
	
	?>