<?php

require_once 'util.php';
foreach(array('admin123','321#admin') as $pswd){
    echo hash_str($pswd), PHP_EOL;
}