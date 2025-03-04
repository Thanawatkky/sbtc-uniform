<?php 
    session_start();
    include 'function.php';
    if (isset($_REQUEST['ac'])) {
        switch ($_REQUEST['ac']) {
            case 'add':
                $data = [
                    "cus_name" => $_SESSION['user_id'],
                    "total_price" => $_REQUEST['sum_total'],

                ];
                insert("tb_order", $data);
                $sql_mx = db()->query("SELECT MAX(order_id) as order_mx FROM tb_order WHERE cus_name = '".$_SESSION['user_id']."' ");
                $fet_mx = $sql_mx->fetch_object();
                $sql_update = db()->query("UPDATE tb_cart SET order_id = '".$fet_mx->order_mx."' WHERE ca_user = '".$_SESSION['user_id']."' AND order_id = 0 ");
                echo jsonMsg(true, "สั่งซื้อสินค้าสำเร็จ","success");


                break;
            case 'addFromQuota':
                $data = [
                    "cus_name" => $_SESSION['user_id'],
                    "total_price" => $_REQUEST['sum_total'],

                ];
                insert("tb_order", $data);
                $sql_mx = db()->query("SELECT MAX(order_id) as order_mx FROM tb_order WHERE cus_name = '".$_SESSION['user_id']."' ");
                $fet_mx = $sql_mx->fetch_object();
                $sql_update = db()->query("UPDATE tb_cart SET order_id = '".$fet_mx->order_mx."' WHERE ca_user = '".$_SESSION['user_id']."' AND order_id = 0 ");
                $sql_update = db()->query("UPDATE tb_cart_quota SET order_id = '".$fet_mx->order_mx."' WHERE cq_user = '".$_SESSION['user_id']."' AND order_id = 0 ");
                echo jsonMsg(true, "สั่งซื้อสินค้าสำเร็จ","success");


                break;
                case 'complete':
                    $data = [
                        "order_status" => 1,
                    ];
                    $id = [
                        "order_id" => $_REQUEST['order_id'],
                    ];
                    if(update("tb_order", $data, $id)) {
                        echo jsonMsg(true, "ยืนยันการสั่งซื้อสำเร็จ","success");
                    } else {
                        echo jsonMsg(false, "ยืนยันการสั่งซื้อไม่สำเร็จ","error");
                        
                    }
                    break;
                case 'request_update':
                    $data = [
                        "order_status" => 4
                    ];
                    $id = [
                        "order_id" => $_REQUEST['order_id']
                    ];
                    if(update("tb_order",$data,$id)) {
                        echo jsonMsg(true, "ส่งคำร้องขอสำเร็จ","success");
                    }else{
                        echo db()->error;
                    }
                    break;
                case 'confirmReq':
                    $data = [
                        'order_status' => 5
                    ];
                    $id = [
                        'order_id' => $_REQUEST['order_id']
                    ];
                    if(update("tb_order",$data,$id)) {
                        echo jsonMsg(true, "อนุมัติคำขอสำเร็จ","success");
                    }else{
                        echo db()->error;
                    }
                    break;
                case 'editorder':
                    
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    
                        // อัปเดตข้อมูลโควต้า (ถ้ามี)
                        if (isset($_POST["editcq_size"])) {
                            foreach ($_POST["editcq_size"] as $cq_id => $cq_size) {
                                db()->query("UPDATE tb_cart_quota SET cq_size='$cq_size' WHERE cq_id='$cq_id'");
                            }
                        }
                    
                        // อัปเดตข้อมูลสินค้า
                        if (isset($_POST["editca_qty"]) && isset($_POST["editca_size"])) {
                            foreach ($_REQUEST["editca_qty"] as $ca_id => $ca_qty) {
                                $ca_size = $_REQUEST["editca_size"][$ca_id];
                                $data = [
                                    "ca_size" => $ca_size,
                                    "ca_qty" => $ca_qty
                                ];
                                $id = [
                                    "ca_id" => $ca_id
                                ];
                                 update("tb_cart",$data,$id);
                            }

                        }
                        $dataOrder = [
                            "order_status" => 6,
                            "total_price" => $_REQUEST['sum_total']
                        ];
                        $order_id = [
                            "order_id" => $_REQUEST['order_id']
                        ];
                        update("tb_order",$dataOrder,$order_id);
                        echo jsonMsg(true, "แก้ไขข้อมูลสำเร็จ", "success");
                    } else {
                        http_response_code(405);
                        echo jsonMsg(true, "Method not allowed", "error");
                       
                    }
                    
                    break;
                case 'cancel':
                    $data = [
                        "order_status" => 9
                    ];
                    $id = [
                        "order_id" => $_REQUEST['order_id']
                    ];
                    if(update("tb_order",$data,$id)) {
                        echo jsonMsg(true, "แจ้งข้อมูลผิดพลาดสำเร็จ","success");
                    }else{
                        echo db()->error;
                    }
                    break;
        }
    }
?>