<?php
    require_once 'util.php';
    $html = '';
    $headers = array('WWW-Authenticate: Basic realm="Restricted Section"','HTTP/1.0 401 Unauthorized');
    $error = '';
    if(!get_username() || !get_password()){
        $error = 'Restricted Area.';
    } else {
        $conn = mysql_db_conn();
        $pswd = sanitizeMySQL($conn, hash_str(get_password()));
        $user = sanitizeMySQL($conn, get_username());
        $sql = 'select 1 from admin where binary username=? and binary password=? limit 1';
        $stm = $conn->prepare($sql);
        if(!$stm || $conn->error){
            $error = 'Authentication query failed.';
        } else {
            $stm->bind_param('ss', $user, $pswd);
            $stm->execute();
            $num = $stm->get_result()->num_rows;
            $stm->close();
            if(0 === $num){
                $error = 'Invalid username/password.';
            } else {
                $headers = array();
                $sql = 'select id, name from malware_type';
                $res = $conn->query($sql);
                $html='
                    <h1>Upload malware file to add in list of malwares</h1>
                    <form method="post" enctype="multipart/form-data">
                        <div><input name="scan" type="file" required=""/> ';
                $html .= get_max_file_upload_size().'</div>';
                $html .= '<div>Malware Type: <select name="type" required="">';
                $html .= '<option value="">Select</option>';
                while($row = $res->fetch_assoc()){
                    $html .= '<option value='.$row['id'].'>'.$row['name'].'</option>';
                }
                $html .= '</select></div>
                        <div>
                            Malware Name: <input name="name" required="" maxlength="50"/>
                        </div>
                        <input type="submit"/>
                    </form>
                ';
                $type = intval(sanitizeMySQL($conn, get_value($_POST, 'type')));
                $name = sanitizeMySQL($conn, get_value($_POST, 'name'));
                $byte = mysql_esc_str($conn, get_upload_bytes_seq());
                if($type && $name && $byte){
                    $sql = 'insert into malware ('malware_type_id', 'name', 'bytes') values (?,?,?)';
                    $stm = $conn->prepare($sql);
                    $stm->bind_param('dss', $type, $name, $byte);
                    $stm->execute();
                    $num = $stm->affected_rows;
                    if(0 < $num){
                        $html .= '<p class="success">Malware file was added</p>';
                    } else {
                        $html .= '<p class="warn">Failed to add malware file</p>';
                    }
                    $stm->close();
                }
                $sql = 'SELECT m.'name', mt.'name' as 'type' FROM 'malware' m inner JOIN 
                'malware_type' mt ON m.'malware_type_id' = mt.'id'';
                $res = $conn->query($sql);
                if(0 === $res->num_rows){
                    $html .= '<p class="warn">No malwares added yet.</p>';
                } else {
                    $html .= '<table border="1" cellpadding="4" cellspacing="0">';
                    $html .= '<tr><th>Malware Name</th><th>Malware Type</th></tr>';
                    while($row = $res->fetch_assoc()){
                        $html .= '<tr><td>'.$row['name'].'</td><td>'.$row['type'].'</td></tr>';
                    }
                    $html .= '</table>';
                }
            }
        }
        $conn->close();
    }

    if($error){
        $html = '<p class="error">'.$error.'</p>';
        $html .= '<p class="info">Click <a href="">here</a> to retry.</p>';
        unset($_SERVER[get_username_key()], $_SERVER[get_password_key()]);
    }

    foreach($headers as $head){
        header($head);
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Admin Page</title>
        <link href="style.css" rel="stylesheet"/>
    </head>
    <body>
        <?php echo $html;?>
    </body>
</html>