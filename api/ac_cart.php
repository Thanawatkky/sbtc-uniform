<?php 
session_start();
    include 'function.php';
    if(isset($_REQUEST['ac'])) {
        switch ($_REQUEST['ac']) {
            case 'add':
                $sql = db()->query("SELECT ca_product FROM tb_cart WHERE ca_product='".$_REQUEST['pro_id']."' AND order_id <= 0 ");
                if($sql->num_rows <= 0) {
                    $data = [
                        "ca_product" => $_REQUEST['pro_id'],
                        "ca_qty" => 1,
                        "ca_user" => $_SESSION['user_id']

                     ];
                     if(insert("tb_cart", $data)) {
                        echo jsonMsg(true, "เพิ่มสินค้าลงตะกร้าสำเร็จ","success");
                     }else{
                        echo db()->error;
                     }
                }else{
                    echo jsonMsg(false, "มีสินค้าชิ้นนี้อยู่ในระบบแล้ว", "error");
                }
                break;
            case 'del':
                $id = [
                    "ca_id" => $_REQUEST['ca_id']
                ];
                if(delete("tb_cart",$id)) {
                    echo jsonMsg(true, false , false);
                }else{
                    echo db()->error;

                }
                break;
                case 'addQty':
                    if (is_array($_REQUEST['data'])) {
                        // วนลูปข้อมูลที่ได้มา
                        foreach ($_REQUEST['data'] as $item) {
                            $ca_id = $item['ca_id']; // ดึงค่า ca_id
                            $ca_qty = $item['ca_qty']; // ดึงค่า ca_qty
                
                            // ตัวอย่าง: อัปเดตข้อมูลในฐานข้อมูล (เขียนโค้ดตามจริง)
                            // updateCart($ca_id, $ca_qty);
                
                           $data = [
                                "ca_qty" => $ca_qty
                           ];
                           $id = [
                            "ca_id" => $ca_id
                           ];
                           update("tb_cart",$data,$id);
                        }
                    } else {
                        echo "Invalid data format.";
                    }
            
                    break;
                case 'addSize':
                    if (is_array($_REQUEST['data'])) {
                        // วนลูปข้อมูลที่ได้มา
                        foreach ($_REQUEST['data'] as $item) {
                            $ca_id = $item['ca_id']; // ดึงค่า ca_id
                            $ca_size = $item['ca_size']; // ดึงค่า ca_size
                
                            // ตัวอย่าง: อัปเดตข้อมูลในฐานข้อมูล (เขียนโค้ดตามจริง)
                            // updateCart($ca_id, $ca_size);
                
                           $data = [
                                "ca_size" => $ca_size
                           ];
                           $id = [
                            "ca_id" => $ca_id
                           ];
                           update("tb_cart",$data,$id);
                        }
                    } else {
                        echo "Invalid data format.";
                    }
            
                    break;
        }
    }
?>