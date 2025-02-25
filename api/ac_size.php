<?php 
    session_start();
    include 'function.php';
    if(isset($_REQUEST['ac'])) {
        switch ($_REQUEST['ac']) {
            case 'add':
               $sql = db()->query("SELECT size_product FROM tb_size WHERE size_product = '".$_REQUEST['size_product']."' AND sex='".$_REQUEST['sex']."' ");
               if($sql->num_rows <= 0) {    
                if($_FILES['size_img']['name'] != '') {
                    $img = $_FILES['size_img']['name'];
                    $img = explode('.',$img);
                    $img = end($img);
                    $img = date('Ymdhis').'.'.$img;
                    move_uploaded_file($_FILES['size_img']['tmp_name'],'../img/size/'.$img);
                }
                if($_FILES['size_img']['name'] == '') {
                    echo jsonMsg(false, "กรุณาเลือกรูปภาพ", "error");

                }
                $data = [
                    'size_product' => $_REQUEST['size_product'],
                    'size_img' => $img,
                    'sex' => $_REQUEST['sex']
                ];
                if(insert('tb_size',$data)) {
                    echo jsonMsg(true, "เพิ่มข้อมูลสำเร็จ", "success");
                } else {
                    echo db()->error;

                }
               }else{
                echo jsonMsg(false, "ข้อมูลดังกล่าวมีอยู่แล้ว", "error");
               }
                break;
            case 'update':
                if($_FILES['size_img']['name'] != '') {
                    $img = $_FILES['size_img']['name'];
                    $img = explode('.',$img);
                    $img = end($img);
                    $img = date('Ymdhis').'.'.$img;
                    move_uploaded_file($_FILES['size_img']['tmp_name'],'../img/size/'.$img);
                }
                if($_FILES['size_img']['name'] == '') {
                    $sql = db()->query("SELECT size_img FROM tb_size WHERE size_id = '".$_REQUEST['size_id']."' ");
                    $fet = $sql->fetch_object();
                    $img = $fet->size_img;
                }
                $data = [
                    'size_product' => $_REQUEST['size_product'],
                    'size_img' => $img,
                    'sex' => $_REQUEST['sex']
                ];
                $id = ['size_id' => $_REQUEST['size_id']];
                if(update('tb_size',$data,$id)) {
                    echo jsonMsg(true, "แก้ไขข้อมูลสำเร็จ", "success");
                } else {
                    echo db()->error;
                }
            break;
            case 'del':
                $id = ['size_id' => $_REQUEST['size_id']];
                if(delete('tb_size',$id)) {
                    echo jsonMsg(true, "ลบข้อมูลสำเร็จ", "success");
                } else {
                    echo db()->error;
                }
                break;
        }
    }
?>