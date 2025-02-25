<?php 
    session_start();
    include 'function.php';
    $sql = db()->query("SELECT citizen_id FROM tb_user WHERE citizen_id='".$_REQUEST['citizen_id']."' ");
    if($sql->num_rows <= 0) {
        $data = [
            "fullname" => $_REQUEST['fullname'],
            "citizen_id" => $_REQUEST['citizen_id'],
            "tel" => $_REQUEST['tel'],
            "g_id" => $_REQUEST['grade'],
            "dep_id" => $_REQUEST['department'],
            "room" => $_REQUEST['room'],
            "quota" => $_REQUEST['quota']
        ];
        if(insert('tb_user', $data)) {
            echo jsonMsg(true, false, false);
        
        }else{
            echo db()->error;
        }
    }else{
        echo jsonMsg(false, "ผู้ใช้งานดังกล่าว มีข้อมูลอยู่ในระบบแล้ว","error");
    }
?>