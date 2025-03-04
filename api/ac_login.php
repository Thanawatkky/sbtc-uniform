<?php 
    session_start();
    include 'function.php';
    if(isset($_REQUEST['ac'])) {
        switch ($_REQUEST['ac']) {
            case 'user_login':
                $sql = db()->query("SELECT * FROM tb_user WHERE citizen_id='".$_REQUEST['citizen_id']."' ");
                if($sql->num_rows <= 0) {
                    echo jsonMsg(false, "เลขบัตรประจำตัวประชาชนไม่ถูกต้อง","error");
                }else{
                    $fet = $sql->fetch_object();
                    $_SESSION['user_id'] = $fet->user_id;
                    if($fet->quota == 1) {
                        echo json_encode(["status" => true, "quota" => true]);
                    }else{
                        echo json_encode(["status" => true, "quota" => false]);
                    }
                }
                break;
                case 'admin':
                    $sql = db()->query("SELECT * FROM tb_user WHERE username='".$_REQUEST['username']."' AND password='".$_REQUEST['password']."'");
                    if($sql->num_rows <= 0) {
                        echo jsonMsg(false, "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง","error");
                    }else{
                        $fet = $sql->fetch_object();
                        $_SESSION['user_id'] = $fet->user_id;
                        if($fet->user_role == 1) {
                            echo json_encode(["status" => true, "role" => 1]);
                        }else if($fet->user_role == 3) {
                            echo json_encode(["status" => true, "role" => 3]);
                        }else{
                            echo http_response_code(401, "Unauthorized");
                        }
                    }
                    break;
        }
    }
?>