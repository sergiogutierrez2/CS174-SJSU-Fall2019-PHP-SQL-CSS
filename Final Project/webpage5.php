<?php //webpage5.php
require_once 'ciphers.php';

  session_start();
  if(isset($_SESSION['username']))
 { 
	 $username = $_SESSION['username'];

	echo "Welcome," . $username ."!";	
 
echo<<<_END
<html>
<body>
<br>
To encrypt/decrypt, either type a text or upload a text file
on the encryption/decryption fields, enter a key, 
and choose the encryption/decryption type desired.<br><br>

<form action="webpage8.php" method="post" enctype="multipart/form-data">
	Text to Encrypt: <input type="text" name="encrypted"> <br>
	Text to Decrypt: <input type="text" name="decrypted">
<br><br>
<label for="file1">Text file to Encrypt:</label> <input type="file" name="file1" id="file1"/>
<br>
<label for="file2">Text file to Decrypt:</label> <input type="file" name="file2" id="file2"/>
<br><br>Key: <input type="text" name="key"><br><br>

<select name="veg" size="1">
	<option value="Simple Substitution">Simple Substitution</option>
	<option value="RC4">RC4</option>
	<option value="Double Transposition">Double Transposition</option>
	<option value="DES">DES</option>
</select>

<input type="submit" value="Submit">
</form>
</body>
</html>
_END;


 if ( ($_FILES["file1"]["type"] == "text/plain") && ($_POST['encrypted']) )
{
 echo "You must choose between uploading a file, and using the input box to encrypt.";
}

else if ( ($_FILES["file2"]["type"] == "text/plain") && ($_POST['decrypted']) )
{
 echo "You must choose between uploading a file, and using the input box to decrypt.";
}

else if ( ($_FILES["file1"]["type"] == "text/plain") && ($_FILES["file2"]["type"] == "text/plain") )
{
 echo "You must choose between encrypting and decrypting";
}

else if ( ($_POST['encrypted']) && ($_POST['decrypted']) )
{
 echo "You must choose between encrypting and decrypting";
}


else if ( ($_POST['encrypted']) && ($_POST['key']) && (!($_POST['decrypted'])) && $_POST['veg']=='Simple Substitution')
{
	//works
	//echo "Encrypted Textbox and Key and Simple Substitution";
   $plaintext = $_POST['encrypted'];
   $key = $_POST['key'];
   $encrypted = simpleSubstitution::encrypt($plaintext, $key); 
   echo 'Encrypted text: ' . $encrypted;
}

else if ( ($_POST['encrypted']) && ($_POST['key']) && (!($_POST['decrypted'])) && $_POST['veg']=='RC4')
{
      //works
      //echo "Encrypted Textbox and Key and RC4";
  $plaintext = $_POST['encrypted'];
  $key = $_POST['key'];
  $encrypted = rc4($key, $plaintext);
  echo 'Encrypted text: ' . $encrypted;
}

else if ( ($_POST['encrypted']) && ($_POST['key']) && (!($_POST['decrypted'])) && $_POST['veg']=='Double Transposition')
{
 echo "Encrypted Textbox and Key and Double Transposition";
}

else if ( ($_POST['encrypted']) && ($_POST['key']) && (!($_POST['decrypted'])) && $_POST['veg']=='DES')
{
        //echo "Encrypted Textbox and Key and DES";
	//works
  $plaintext = $_POST['encrypted'];
  $key = $_POST['key'];
  $encrypted = DES($key, $plaintext);
  echo 'Encrypted text: ' . $encrypted;
}

else if ( ($_POST['decrypted']) && ($_POST['key']) && (!($_POST['encrypted'])) && $_POST['veg']=='Simple Substitution')
{
	//echo "Decrypted Textbox and Key and Simple Substitution";
	//works
   $plaintext = $_POST['decrypted'];
   $key = $_POST['key'];
   $decrypted = simpleSubstitution::decrypt($plaintext, $key);
   echo 'Decrypted text: ' . $decrypted;
}

else if ( ($_POST['decrypted']) && ($_POST['key']) && (!($_POST['encrypted'])) && $_POST['veg']=='RC4')
{
  //works
  //echo "Decrypted Textbox and Key and RC4";
  $plaintext = $_POST['decrypted'];
  $key = $_POST['key'];
  $decrypted = rc4($key, $plaintext);
  echo 'Decrypted text: ' . $decrypted;
}

else if ( ($_POST['decrypted']) && ($_POST['key']) && (!($_POST['encrypted'])) && $_POST['veg']=='Double Transposition')
{
 echo "Decrypted Textbox and Key and Double Transposition";
}

else if ( ($_POST['decrypted']) && ($_POST['key']) && (!($_POST['encrypted'])) && $_POST['veg']=='DES')
{
         //echo "Decrypted Textbox and Key and DES";
	//works
  $plaintext = $_POST['decrypted'];
  $key = $_POST['key'];
  $decrypted = DES($key, $plaintext);
  echo 'Decrypted text: ' . $decrypted;
}


else if ( ($_FILES["file1"]["type"] == "text/plain") && ($_POST['key']) && (!($_POST['decrypted'])) && $_POST['veg']=='Simple Substitution')
{
   //works
   // echo "Uploaded Text File to Encrypt and Key and Simple Substitution";
  $plaintext = file_get_contents($_FILES["file1"]["name"]);
  $key = $_POST['key'];
  $encrypted = simpleSubstitution::encrypt($plaintext, $key);
  echo 'Encrypted text: ' . $encrypted;
}

else if ( ($_FILES["file1"]["type"] == "text/plain") && ($_POST['key']) && (!($_POST['decrypted'])) && $_POST['veg']=='RC4')
{
	//works
	//echo "Uploaded Text File to Encrypt and Key and RC4";
  $plaintext = file_get_contents($_FILES["file1"]["name"]);
  $key = $_POST['key'];
  $encrypted = rc4($key, $plaintext);
  echo 'Encrypted text: ' . $encrypted;
}

else if ( ($_FILES["file1"]["type"] == "text/plain") && ($_POST['key']) && (!($_POST['decrypted'])) && $_POST['veg']=='Double Transposition')
{
 echo "Uploaded Text File to Encrypt and Key and Double Transposition";
}

else if ( ($_FILES["file1"]["type"] == "text/plain") && ($_POST['key']) && (!($_POST['decrypted'])) && $_POST['veg']=='DES')
{
         //echo "Uploaded text file to Encrypt and Key and DES";
	//works
  $plaintext = file_get_contents($_FILES["file1"]["name"]);
  $key = $_POST['key'];
  $encrypted = DES($key, $plaintext);
  echo 'Encrypted text: ' . $encrypted;
}



else if ( ($_FILES["file2"]["type"] == "text/plain") && ($_POST['key']) && (!($_POST['encrypted'])) && $_POST['veg']=='Simple Substitution')
{
   //works
   //echo "Uploaded Text File to Decrypt and Key and Simple Substitution";
   $plaintext = file_get_contents($_FILES["file2"]["name"]);
   $key = $_POST['key'];
   $decrypted = simpleSubstitution::decrypt($plaintext, $key);
   echo 'Decrypted text: ' . $decrypted;
}

else if ( ($_FILES["file2"]["type"] == "text/plain") && ($_POST['key']) && (!($_POST['encrypted'])) && $_POST['veg']=='RC4')
{
        //works	
	//echo "Uploaded Text File to Decrypt and Key and RC4";
  $plaintext = file_get_contents($_FILES["file2"]["name"]);
  $key = $_POST['key'];
  $decrypted = rc4($key, $plaintext);
  echo 'Decrypted text: ' . $decrypted;
}

else if ( ($_FILES["file2"]["type"] == "text/plain") && ($_POST['key']) && (!($_POST['encrypted'])) && $_POST['veg']=='Double Transposition')
{
 echo "Uploaded Text File to Decrypt and Key and Double Transposition";
}

else if ( ($_FILES["file2"]["type"] == "text/plain") && ($_POST['key']) && (!($_POST['encrypted'])) && $_POST['veg']=='DES')
{
          //echo "Uploaded text file to Decrypt and Key and DES";
	//works
  $plaintext = file_get_contents($_FILES["file2"]["name"]);
  $key = $_POST['key'];
  $decrypted = DES($key, $plaintext);
  echo 'Decrypted text: ' . $decrypted;
}

else if (($_FILES["file1"]["type"] !== "text/plain") || ($_FILES["file2"]["type"] !== "text/plain"))
{
  echo "Any uploaded file must be .txt";
}


  }



  else echo "Please <a href='welcome.php'>click here</a> to log in.";


