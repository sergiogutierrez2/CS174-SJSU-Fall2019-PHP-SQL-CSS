<?php

function intCalculator($int) 
{
   $factorial = 1;
   for ($i = $int; $i >= 1; $i--) 
   {
     $factorial = $factorial * $i;
   }
    return $factorial;
}


echo <<<_END
<html>
<body>

<form action="upload.php" method="post" enctype="multipart/form-data">
    Select the text to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>

</body>
</html>
_END;

function factorialMath($value) 
{
    $var = str_split($value);
    $one = $var[0];
    $two = $var[1];
    $three = $var[2];
    $four = $var[3];
    $five = $var[4];
    for($i=0;$i<count($var);$i++)
	{
      for($j=$i+1;$j<count($var);$j++)
	  {
        for($k=$j+1;$k<count($var);$k++)
	   {
         for($l=$k+1;$l<count($var);$l++)
	    {
          for($m=$l+1;$m<count($var);$m++)
	       {
            if($var[$i]*$var[$j]*$var[$k]*$var[$l]*$var[$m] > $one*$two*$three*$four*$five)
	        {
             $one = $var[$i];
             $two = $var[$j];
             $three = $var[$k];
             $four = $var[$l];
             $five = $var[$m];
            }
          }
        }
      }
     }
   }
	
  $sum = + intCalculator($one) + intCalculator($two) + intCalculator($three) + intCalculator($four) + intCalculator($five);
  return "1) The 5 adjacent numbers with the biggest product are: ".$one.",".$two .",".$three.",".$four.",".$five."<br/> 2) Sum of the factorial of each term of a largest product: ".$sum;
}

   if(isset($_POST['submit']))
   {
    $value = file_get_contents($_FILES["fileToUpload"]['tmp_name']);
    if(strlen($value) != 1000 || !is_numeric($value))
	{
      die('The file is not formatted correctly');
    }
     echo factorialMath($value);
   }
?>