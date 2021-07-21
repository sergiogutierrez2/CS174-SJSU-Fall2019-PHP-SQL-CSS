<?php //sanitize.php
    
    // sanitizing functions, error functions, file handling, etc.
    

    function mysql_entities_fix_string($conn, $string)
    {
        return htmlentities(mysql_fix_string($conn, $string));
    }
    
    function mysql_fix_string($conn, $string)
    {
        if (get_magic_quotes_gpc()) $string = stripslashes($string);
        return $conn->real_escape_string($string);
    }
    
    function sanitizeString($var) {
        $var = stripslashes($var);
        $var = strip_tags($var);
        $var = htmlentities($var);
        return $var;
    }
    
    function sanitizeMySQL($connection, $var) {
        $var = $connection->real_escape_string($var);
        $var = sanitizeString($var);
        return $var;
    }
    
    // in case we can't connect to mysql
    function mysql_fatal_error($msg, $conn){
        $msg2 = mysqli_error($conn);
        echo <<<_END
<pre>
Something unexpected happened.
Please reload the page and try again.
Error message:
        <p>$msg: $msg2</p>
If it helps, here's an ASCII dog I found online:
     |\_/|                  
     | @ @   Woof! 
     |   <>              _  
     |  _/\------____ ((| |))
     |               `--' |   
 ____|_       ___|   |___.' 
/_/_____/____/_______|
</pre>
_END;
    }
    
?>