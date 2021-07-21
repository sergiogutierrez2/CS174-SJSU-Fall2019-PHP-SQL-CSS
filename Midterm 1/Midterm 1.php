<?php
//Sergio Gutierrez midterm
//make sure to call this themidterm.php to make it work.
echo <<<_END
<html>
<head>
</head>
<body>
<form action="themidterm.php" method="post" enctype="multipart/form-data">
<label for="file">Filename:</label> <input type="file" name="file" id="file"/>
<input type="submit" value="Submit">
</form>
</body>
</html>
_END;

    if ($_FILES["file"]["error"] > 0)
    {
       echo "Error: " . $_FILES["file"]["error"] . "<br />";
    }
     elseif ($_FILES["file"]["type"] !== "text/plain")
   {
      echo "File must be a .txt";
    }

   else
   {
      $data = file_get_contents($_FILES["file"]["name"]);
      $data = str_replace("\n", '', $data);
	  $data = str_replace(" ", '', $data); 
	   
	  if (!(is_numeric($data))) 
	    {
            die("The file must only contain numeric values.");
        } 
	   
	  if (!(strlen($data) == 400))
	  {
		  die("The file must contain exactly 400 characters");
	  }	  
		  
	   $array = str_split($data);
	   splitter($array);
   }
	   
	   function splitter($array) 
	  {	   		   
	  $split = 20;
      $array2 = array_chunk($array, $split);
		   
	  tester_function($array2);	   
    }
 
// Function that obtains the maximum product 
// of four elements adjacent to each other  
function maximumProduct($arr) 
{ 
    $colsrows = 20; 
	$maximum = 0; 
	$product = 0; 
  
    // iterate through rows. 
    for ( $x = 0; $x < $colsrows; $x++)  
    { 
        // iterate through columns. 
        for ( $y = 0; $y < $colsrows; $y++)  
        { 
            // Get max product - horizontal row. 
            if (($y - 3) >= 0)  
            { 
$product = $arr[$x][$y] * $arr[$x][$y - 1] * $arr[$x][$y - 2] * $arr[$x][$y - 3]; 
                  
                if ($maximum < $product) 
                    $maximum = $product; 
            } 
            // Get max product - vertical row
            // and compare it to max in horizontal 
            if (($x - 3) >= 0)  
            { 
$product = $arr[$x][$y] * $arr[$x - 1][$y] * $arr[$x - 2][$y] * $arr[$x - 3][$y]; 
                  
                if ($maximum < $product) 
                    $maximum = $product; 
            } 
            // check one diagonal and compare
            // max product to current maximum value
            if (($x - 3) >= 0 && ($y - 3) >= 0)  
            { 
$product = $arr[$x][$y] * $arr[$x - 1][$y - 1] * $arr[$x - 2][$y - 2] * $arr[$x - 3][$y - 3]; 
                  
                if ($maximum < $product) 
                    $maximum = $product; 
            } 
			
			//check other diagonal
				if (($x - 3) >= 0 && $colsrows > ($y + 3))  
            { 
$product = $arr[$x][$y] * $arr[$x - 1][$y + 1] * $arr[$x - 2][$y + 2] * $arr[$x - 3][$y + 3]; 
                  
                if ($maximum < $product) 
                    $maximum = $product; 
            } 
        } 
    } 
    return $maximum; 
}

function tester_function($array2)
{
	echo "The maximum product, of all the adjacent directions is: ";
	echo maximumProduct($array2);
	echo "<br>";
	echo "<br>";
	
	$array3 = maximumFour($array2);
	
	echo "The maximum vertical product is: ";
	echo $array3[0];
	echo "<br>";
	
	echo "The maximum horizontal product is: ";
	echo $array3[1];
	echo "<br>";
	
	echo "The maximum diagonal 1 product is: ";
	echo $array3[2];
	echo "<br>";
	
	echo "The maximum diagonal 2 product is: ";
	echo $array3[3];
	
}


function maximumFour($arr) 
{ 
    $colsrows = 20; 
	$product = 0; 
	
	$vertical = 0; 
	$horizontal = 0; 
	$diagonal1 = 0;
	$diagonal2 = 0; 
  
    // iterate through rows. 
    for ( $x = 0; $x < $colsrows; $x++)  
    { 
        // iterate through columns. 
        for ( $y = 0; $y < $colsrows; $y++)  
        { 
            // Get max horizontal row. 
            if (($y - 3) >= 0)  
            { 
$product = $arr[$x][$y] * $arr[$x][$y - 1] * $arr[$x][$y - 2] * $arr[$x][$y - 3]; 
                  
                if ($horizontal < $product) 
                    $horizontal = $product; 
            } 
            // Get max vertical row 
            if (($x - 3) >= 0)  
            { 
$product = $arr[$x][$y] * $arr[$x - 1][$y] * $arr[$x - 2][$y] * $arr[$x - 3][$y]; 
                  
                if ($vertical < $product) 
                    $vertical = $product; 
            } 
            // Get max diagonal 1
            if (($x - 3) >= 0 && ($y - 3) >= 0)  
            { 
$product = $arr[$x][$y] * $arr[$x - 1][$y - 1] * $arr[$x - 2][$y - 2] * $arr[$x - 3][$y - 3]; 
                  
                if ($diagonal1 < $product) 
                    $diagonal1 = $product; 
            } 
			
			//Get max diagonal 2
				if (($x - 3) >= 0 && $colsrows > ($y + 3))  
            { 
$product = $arr[$x][$y] * $arr[$x - 1][$y + 1] * $arr[$x - 2][$y + 2] * $arr[$x - 3][$y + 3]; 
                  
                if ($diagonal2 < $product) 
                    $diagonal2 = $product; 
            } 
        } 
    } 
	
	$arrayD = array($vertical, $horizontal, $diagonal1, $diagonal2);
    return $arrayD;
}
?>