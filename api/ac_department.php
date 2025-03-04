<?php 
    session_start();
    include 'function.php';
    if(isset($_REQUEST['ac'])) {
        switch ($_REQUEST['ac']) {
            case 'add':
                $sql = db()->query("SELECT department FROM tb_department WHERE department='".$_REQUEST['department']."' AND g_id='".$_REQUEST['g_id']."' ");
                if($sql->num_rows <= 0) {
                    $data = [
                        "department" => $_REQUEST['department'],
                        "room_qty" => $_REQUEST['room_qty'],
                        "g_id" => $_REQUEST['g_id']
                    ];
                    if(insert("tb_department", $data)) {
                        echo jsonMsg(true, "เพิ่มข้อมูลสำเร็จ","success");
                    }else{
                        db()->error;
                    }
                }else{
                    echo jsonMsg(false, "มีข้อมูลดังกว่าในระบบแล้ว","error");
                }
                break;
            case 'update':
                $data = [
                    "g_id" => $_REQUEST['g_id'],
                    "department" => $_REQUEST['department'],
                    "room_qty" => $_REQUEST['room_qty']
                ];
                $id = [
                    "dep_id" => $_REQUEST['dep_id']
                ];
                if(update("tb_department", $data, $id)) {
                    echo jsonMsg(true, "แก้ไขข้อมูลสำเร็จ","success");
                }else{
                    db()->error;
                }
                break;
            case 'del':
                $id = [
                    "dep_id" => $_REQUEST['dep_id']
                ];
                if(delete("tb_department",$id)) {
                    echo jsonMsg(true, "ลบข้อมูลสำเร็จ","success");
                }else{
                    echo db()->error;
                }
                break;
            case 'add_head':
                $sql  = db()->query("SELECT * FROM tb_user WHERE username='".$_REQUEST['username']."' AND user_role = 3");
                if($sql->num_rows <= 0) {
                    $data = [
                        "fullname" => $_REQUEST['fullname'],
                        "username" => $_REQUEST['username'],
                        "password" => $_REQUEST['password'],
                        "user_role" => 3,
                        "dep_id" => $_REQUEST['dep_id'],
                    ];
                    if(insert("tb_user", $data)) {
                        echo jsonMsg(true, "เพิ่มข้อมูลสำเร็จ","success");
                    }else{
                        echo db()->error;
                    }
                }else{
                    echo jsonMsg(false, "มีข้อมูลดังกล่าวในระบบแล้ว","error");
                }
                break;
            case 'edit_head':
                $data = [
                    "fullname" => $_REQUEST['fullname'],
                    "username" => $_REQUEST['username'],
                    "password" => $_REQUEST['password'],
                    "dep_id" => $_REQUEST['dep_id']
                ];
                $id = [
                    "user_id" => $_REQUEST['user_id']
                ];
                if(update("tb_user", $data, $id)) {
                    echo jsonMsg(true, "แก้ไขข้อมูลสำเร็จ","success");
                }else{
                    echo db()->error;
                }

                break;
            case 'del_head':
                $id = [
                    "user_id" => $_REQUEST['user_id']
                ];
                if(delete("tb_user", $id)) {
                    echo jsonMsg(true, "ลบข้อมูลสำเร็จ","success");
                }else{
                    echo db()->error;
                }
                break;

            case 'edit_profile':
                $data = [
                    "fullname" => $_REQUEST['fullname'],
                    "password" => $_REQUEST['password'],
                ];
                $id = [
                    "user_id" => $_SESSION['user_id']
                ];
                if(update("tb_user", $data, $id)) {
                    echo jsonMsg(true, "แก้ไขข้อมูลสำเร็จ","success");
                }else{
                    echo db()->error;
                }
            
                break;

        }
    }
?>