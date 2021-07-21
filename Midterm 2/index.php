<?php
    require_once 'util.php';
    $conn = mysql_db_conn();
    $bytes = mysql_esc_str($conn, get_upload_bytes_seq());
    $html = '';
    if($bytes){
        $sql = 'SELECT m.'name', mt.'name' as 'type', mt.'desc' FROM 'malware' m inner JOIN 
        'malware_type' mt ON m.'malware_type_id' = mt.'id' where m.'bytes'=? limit 1';
        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $bytes);
        $stm->execute();
        $res = $stm->get_result();
        if(0 === $res->num_rows){
            $html = '<p class="warn">File is not suspicious</p>';
        } else {
            $row = $res->fetch_assoc();
            $html = '<p class="error">Suspicious file detected</p>';
            $html .= '<p class="info">Name:'.$row['name'].'</p>';
            $html .= '<p class="info">Type:'.$row['type'].'</p>';
            $html .= '<p class="info">Desc:'.$row['desc'].'</p>';
        }
        $stm->close();
    }
    $conn->close();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>User Page</title>
        <link href="style.css" rel="stylesheet"/>
    </head>
    <body>
        <h1>Upload suspicious file for malaware detection</h1>
        <form method="post" enctype="multipart/form-data">
            <input name="scan" type="file" required=""/>
            <?php echo get_max_file_upload_size();?>
            <input type="submit"/>
        </form>
        <?php echo $html;?>
    </body>
</html>