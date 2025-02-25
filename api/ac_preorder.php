<?php 
    session_start();
    include 'function.php';
    if(isset($_REQUEST['ac'])) {
        switch ($_REQUEST['ac']) {
            case 'add':
                $data = [
                    "pre_year" => $_REQUEST['pre_year'],
                    "start_at" => $_REQUEST['start_at'],
                    "end_at" => $_REQUEST['end_at'],
                ];
                if(insert("tb_preorder", $data)) {
                    echo jsonMsg(true, "เพิ่มข้อมูลสำเร็จ","success");

                }else{
                    echo db()->error;
                }
                break;
            case 'update':
                $data = [
                    "pre_year" => $_REQUEST['pre_year'],
                    "start_at" => $_REQUEST['start_at'],
                    "end_at" => $_REQUEST['end_at'],
                ];
                $id = [
                    "pre_id" => $_REQUEST['pre_id']
                ];
                if(update("tb_preorder", $data, $id)) {
                    echo jsonMsg(true, "แก้ไขข้อมูลสำเร็จ","success");
                }else{
                    echo db()->error;
                }
                break;
            case 'end':
                $data = [
                    "pre_status" => 0,
                ];
                $id = [
                    "pre_id" => $_REQUEST['pre_id']
                ];
                if(update("tb_preorder", $data, $id)) {
                    echo jsonMsg(true, "ดำเนินการสำเร็จ","success");
                }else{
                    echo db()->error;
                }
                break;
        }
    }
?>