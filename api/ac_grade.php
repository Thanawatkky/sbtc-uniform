<?php 
    session_start();
    include 'function.php';
    if(isset($_REQUEST['ac'])) {
        switch ($_REQUEST['ac']) {
            case 'add':
               $sql = db()->query("SELECT * FROM tb_grade WHERE grade = '".$_REQUEST['grade']."' ");
               if($sql->num_rows <= 0) {    
                   $insert = db()->query("INSERT INTO tb_grade(grade,quota) VALUES('".$_REQUEST['grade']."','".$_REQUEST['quota']."') ");
                   if($insert) {
                       echo jsonMsg(true, "เพิ่มข้อมูลสำเร็จ","success");
                    }else{
                        echo db()->error;
                    }
                }else{
                   echo jsonMsg(false, "มีข้อมูลระดับชั้นนี้แล้ว","error");
               }
                break;
            case 'update':
                $sql = db()->query("UPDATE tb_grade SET grade = '".$_REQUEST['grade']."', quota='".$_REQUEST['quota']."' WHERE g_id='".$_REQUEST['id']."' ");
                if($sql) {
                    echo jsonMsg(true, "แก้ไขข้อมูลสำเร็จ","success");
                }else{
                    echo db()->error;
                }
                break;
            case 'del':
                $sql = db()->query("DELETE FROM tb_grade WHERE g_id='".$_REQUEST['id']."' ");
                if($sql) {
                    echo jsonMsg(true, "ลบข้อมูลสำเร็จ","success");
                }else{
                    echo db()->error;
                }
                break;
        }
    }
?>