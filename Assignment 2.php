<?php
// This program will convert modern hindu - arabic numbers
// into Roman numerals.
// @author Sergio Gutierrez

   function Roman_val($value)
{
  if ($value == 'I')
  return 1;
	   
  elseif ($value == 'V')
  return 5;
	   
  elseif ($value == 'X')
  return 10;
	   
  elseif ($value == 'L')
  return 50;
	   
  elseif ($value == 'C')
  return 100;
	   
  elseif ($value == 'D')
  return 500;
	   
  elseif ($value == 'M')
  return 1000;
	   
  else
  echo "Error, invalid input: ";	   
}

        function Roman_numeral($input)
     {
       $number = 0;
  
	  for ($i = 0; $i < strlen($input); $i++) //strlen() returns the number of bytes
    {
          $letter1 = Roman_val($input[$i]);
          if ($i+1 < strlen($input))
        {
           $letter2 = Roman_val($input[$i + 1]);
            if ($letter1 >= $letter2)
          {
            $number = $number + $letter1;
          }
            else
          {
            $number = $number + $letter2 - $letter1;
            $i++;
          }
        }
            else
        {
           $number = $number + $letter1;
           $i++;
        }
    }
       return $number;
    }

     //Test function to see if program works.
     function testing_function()
{
    $input = "VI";
	echo "Roman Numeral VI equals to: ";	 
    echo Roman_numeral($input)."<br>";
	
	$input = "IV";
	echo "Roman Numeral IV equals to: ";	 
    echo Roman_numeral($input)."<br>";
		 
	$input = "MCMXC";
	echo "Roman Numeral MCMXC equals to: ";	 
    echo Roman_numeral($input)."<br>";
		 
    $input = "IX";
	echo "Roman Numeral IX equals to: ";	 
    echo Roman_numeral($input)."<br>";
		 
	$input = "MMM";
	echo "Roman Numeral MMM equals to: ";	 
    echo Roman_numeral($input)."<br>";	 
		 
	$input = "MMMCMXCIX";
	echo "Roman Numeral MMMCMXCIX equals to: ";	 
    echo Roman_numeral($input)."<br>";
		 
	$input = "Z";
	echo "Invalid input Z equals to: ";	 
    echo Roman_numeral($input);
		 
	// Roman numerals traditionally don't have negatives or zeros
}
testing_function();


/* Output obtained:
Roman Numeral VI equals to: 6
Roman Numeral IV equals to: 4
Roman Numeral MCMXC equals to: 1990
Roman Numeral IX equals to: 9
Roman Numeral MMM equals to: 3000
Roman Numeral MMMCMXCIX equals to: 3999
Invalid input Z equals to: Error, invalid input: 0
*/

?>