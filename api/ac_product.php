<?php 
    session_start();
    include 'function.php';
    if(isset($_REQUEST['ac'])) {
        switch ($_REQUEST['ac']) {
            case 'add':
                $sql = db()->query("SELECT pro_name FROM tb_product WHERE pro_name='".$_REQUEST['pro_name']."' ");
                if($sql->num_rows <= 0) {
                    if($_FILES['pro_img']['name'] != "") {
                        move_uploaded_file($_FILES['pro_img']['tmp_name'],"../img/product/".$_FILES['pro_img']['name']);
                    }
                    if($_FILES['pro_img']['name'] == ""){
                        echo jsonMsg(false, "กรุณาแนบรูปภาพประกอบเครื่องแบบ","error");
                    }
                    $data = [
                        "pro_name" => $_REQUEST['pro_name'],
                        "pro_price" => $_REQUEST['pro_price'],
                        "pro_img" => $_FILES['pro_img']['name'],
                        "pro_type" => $_REQUEST['pro_type']
                    ];
                    if(insert("tb_product", $data)) {
                        echo jsonMsg(true, "เพิ่มข้อมูลสำเร็จ","success");
                    }else{
                        echo db()->error;
                    }
                }else{
                    echo jsonMsg(false, "มีข้อมูลเครื่องแบบนี้ในระบบแล้ว","error");
                }
                break;
            case 'update':
                if($_FILES['pro_img']['name'] != "") {
                    $file = $_FILES['pro_img']['name'];
                    move_uploaded_file($_FILES['pro_img']['tmp_name'],"../img/product/".$file);
                }
                if($_FILES['pro_img']['name'] == ""){
                    $sql_img = db()->query("SELECT pro_img FROM tb_product WHERE pro_id='".$_REQUEST['pro_id']."' ");
                    $fet_img = $sql_img->fetch_object();
                    $file = $fet_img->pro_img;
                } 
                $data = [
                    "pro_name" => $_REQUEST['pro_name'],
                    "pro_price" => $_REQUEST['pro_price'],
                    "pro_img" => $file,
                    "pro_type" => $_REQUEST['pro_type']

                ];
                $id = [
                    "pro_id" => $_REQUEST['pro_id']
                ];
                if(update("tb_product", $data, $id)) {
                    echo jsonMsg(true, "แก้ไขข้อมูลสำเร็จ","success");
                }else{
                    echo db()->error;
                }
                break;
            case 'del':
                $id = [
                    "pro_id" => $_REQUEST['pro_id']
                ];
                if(delete("tb_product",$id)){
                    echo jsonMsg(true, "ลบข้อมูลสำเร็จ","success");
                }else{
                    echo db()->error;
                }
                break;
        }
    }
?>