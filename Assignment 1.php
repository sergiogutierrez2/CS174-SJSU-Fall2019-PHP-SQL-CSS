<?php
// This function will print the prime numbers
// up to the selected input number.
// @author Sergio Gutierrez
function prime($number)
{
     if ($number <= 1)
   {
     echo "none.";
   }

	else
    {
      $prime_arr = array_fill(0, $number+1, true);
     
		for ($prime = 2; $prime*$prime <= $number; $prime++)
     { 
	    if ($prime_arr[$prime] == true)
      {
       for ($i = $prime*$prime; $i <= $number; $i += $prime)
       $prime_arr[$i] = false;
      }
     }
    
      for ($prime = 2; $prime <= $number; $prime++)
      if ($prime_arr[$prime])
      echo $prime." ";
    }
	
}

     //Will test if function prime does its job.
     function tester_function()
{
    $number = 10;
	echo "Prime numbers expected for $number are: ";
	echo "2 3 5 7 <br>";	 
    echo "Prime numbers up to number $number are: ";
    prime($number);
	echo "<br>";
	echo "<br>";
		 
    $number = 17;
    echo "Prime numbers up to number $number are: ";
    prime($number);
	echo "<br>";
		 
    $number = 0;
    echo "Prime numbers up to number $number are: ";
    prime($number);
	echo "<br>";	 

    $number = 100;
    echo "Prime numbers up to number $number are: ";
    prime($number);
	echo "<br>";
}
?>