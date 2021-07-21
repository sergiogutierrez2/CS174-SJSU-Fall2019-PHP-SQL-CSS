<?php

function mysql_db_conn($hn='localhost', $un='root', $pw='', $db='antivirus'){
    $conn = new mysqli($hn, $un, $pw, $db);
    if($conn->connect_error){
        die('<p>Something went wrong. Click <a href="">here<a> to try again</p>');
    }
    return $conn;
}

function hash_str($str, $salt1='qm&h*', $salt2='pg!@'){
    return hash('ripemd128', $salt1.$str.$salt2);
}

function get_value($arr, $key){
    $value = '';
    if(isset($arr[$key])){
        $value = trim($arr[$key]);
    }
    return $value;
}

function get_username_key(){
    return 'PHP_AUTH_USER';
}

function get_username(){
    global $_SERVER;
    return get_value($_SERVER, get_username_key());
}

function get_password_key(){
    return 'PHP_AUTH_PW';
}

function get_password(){
    global $_SERVER;
    return get_value($_SERVER, get_password_key());
}

function sanitizeString($var) {
    $var = stripslashes($var);
    $var = strip_tags($var);
    $var = htmlentities($var);
    return $var;
}

function sanitizeMySQL($conn, $var) {
    $var = $conn->real_escape_string($var);
    $var = sanitizeString($var);
    return $var;
}

function get_upload_bytes_seq($name='scan'){
    global $_FILES;
    $bytes = '';
    if(isset($_FILES[$name]['tmp_name'])){
        $path = $_FILES[$name]['tmp_name'];
        if(file_exists($path)){
            $size = min(20, filesize($path));
            $file = fopen($path, 'rb');
            $bytes = fread($file, $size);
            fclose($file);
        }
    }
    return $bytes;
}

function get_max_file_upload_size(){
    return '(Max '. ini_get('upload_max_filesize').')';
}

function mysql_esc_str($conn, $str){
    return $conn->real_escape_string($str);
}