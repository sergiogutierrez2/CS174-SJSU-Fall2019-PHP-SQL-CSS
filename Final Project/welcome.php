<?php
//Welcome
echo <<<_END
<html>
<body>
<h3> Welcome to the Cipher Final Assignment </h3>
<h3> Please either Log in, or Sign up.</h3>
<form action="welcome.php" method="post" enctype="multipart/form-data">
<button type="submit" name="button1" value="Sign up">Sign up</button>
<button type="submit" name="button2" value="Log in">Log in</button>
</form>
</body>
</html>
_END;


if (isset($_POST['button1']))
{
   header('Location: setupusers.php');
}

if (isset($_POST['button2']))
{
   header("Location: authenticate.php");
}

?>
