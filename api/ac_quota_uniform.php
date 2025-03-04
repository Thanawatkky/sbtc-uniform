<?php 
    session_start();
    include 'function.php';
    if(isset($_REQUEST['ac'])) {
        switch ($_REQUEST['ac']) {
            case 'add':
                $sql = db()->query("SELECT pro_id FROM tb_uquota WHERE pro_id='".$_REQUEST['pro_id']."' AND sex='".$_REQUEST['sex']."' ");
                if($sql->num_rows <= 0) {
                    if($_REQUEST['sex'] == 3) {
                        for ($i = 1; $i < 3; $i++) {
                            $data = [
                                "pro_id" => $_REQUEST['pro_id'],
                                "u_qty" => $_REQUEST['qty'],
                                "sex" => $i
                            ];
                            insert("tb_uquota", $data);
                        }
                        echo jsonMsg(true, "เพิ่มข้อมูลสำเร็จ","success");
                    }else{
                        $data = [
                            "pro_id" => $_REQUEST['pro_id'],
                            "u_qty" => $_REQUEST['qty'],
                            "sex" => $_REQUEST['sex']
                        ];
                        if(insert("tb_uquota", $data)) {
                            echo jsonMsg(true, "เพิ่มข้อมูลสำเร็จ","success");
                            
                         }else{
                             echo db()->error;
                         }
                    }
                }else{
                    $data = [
                        "u_qty" => $_REQUEST['qty']
                    ];
                    $id = [
                        "pro_id" => $_REQUEST['pro_id'],
                        "sex" => $_REQUEST['sex']
                    ];
                    $sql = db()->query("UPDATE tb_uquota SET u_qty = '".$_REQUEST['u_qty']."' WHERE pro_id='".$_REQUEST['pro_id']."' AND sex='".$_REQUEST['sex']."' ");
                    if($sql) {
                     echo jsonMsg(true, "เพิ่มข้อมูลสำเร็จ","success");
                    }else{
                        echo db()->error;
                    }
                }
                break;
                case 'del':
                    $id = [
                        "u_id" => $_REQUEST['u_id']
                    ];
                    if(delete("tb_uquota",$id)){
                        echo jsonMsg(true, "ลบข้อมูลสำเร็จ","success");
                    }else{
                        echo db()->error;
                    }
                    break;
                case 'addSize':
                    if(is_array($_REQUEST['data'])) {
                        foreach ($_REQUEST['data'] as $item) {
                            $uq_size = $item['uq_size'];
                            $uq_product = $item['uq_product'];
                           
                                $sql_update = db()->query("UPDATE tb_cart_quota SET cq_size = '".$uq_size."' WHERE cq_product = '".$uq_product."' AND cq_user = '".$_SESSION['user_id']."' AND order_id <= 0 ");
                                if($sql_update) {
                                    echo jsonMsg(true, "เพิ่มข้อมูลสำเร็จ","success");
                                }else{
                                    echo db()->error;
                                }
                            
                            
                            
                        }

                    } else {
                        echo "Invalid data format.";
                    }
                    break;
                    case 'addToCart':
                        $sql_check = db()->query("SELECT * FROM tb_cart_quota WHERE cq_user = '".$_SESSION['user_id']."' AND order_id <= 0 ");
                        if($sql_check->num_rows <= 0) {
                        $sql = db()->query("SELECT * FROM tb_uquota WHERE sex='".$_REQUEST['sex']."' ");
                        while($fet = $sql->fetch_object()) {
                            $data = [
                                "cq_product" => $fet->pro_id,
                                "cq_user" => $_SESSION['user_id'],
                                "cq_qty" => $fet->u_qty
                            ];
                            if(insert("tb_cart_quota", $data)) {
                                $_SESSION['sex'] = $_REQUEST['sex'];
                                echo jsonMsg(true, "เพิ่มข้อมูลสำเร็จ","success");
                            }else{
                                echo db()->error;
                            }
                        }
                    }else{
                        $sql_delete = db()->query("DELETE FROM tb_cart_quota WHERE cq_user = '".$_SESSION['user_id']."' AND order_id <= 0 ");
                        $sql = db()->query("SELECT * FROM tb_uquota WHERE sex='".$_REQUEST['sex']."' ");
                        while($fet = $sql->fetch_object()) {
                            $data = [
                                "cq_product" => $fet->pro_id,
                                "cq_user" => $_SESSION['user_id'],
                                "cq_qty" => $fet->u_qty
                            ];
                            if(insert("tb_cart_quota", $data)) {
                                $_SESSION['sex'] = $_REQUEST['sex'];
                                echo jsonMsg(true, "เพิ่มข้อมูลสำเร็จ","success");
                            }else{
                                echo db()->error;
                            }
                        }
                    }
                        break;

                        case 'changeSex':
                          unset($_SESSION['sex']);

                          $sql_delete = db()->query("DELETE FROM tb_cart_quota WHERE cq_user = '".$_SESSION['user_id']."' AND order_id <= 0 ");
                          $sql = db()->query("SELECT * FROM tb_uquota WHERE sex='".$_REQUEST['sex']."' ");
                          while($fet = $sql->fetch_object()) {
                              $data = [
                                  "cq_product" => $fet->pro_id,
                                  "cq_user" => $_SESSION['user_id'],
                                  "cq_qty" => $fet->u_qty
                              ];
                              if(insert("tb_cart_quota", $data)) {
                                  $_SESSION['sex'] = $_REQUEST['sex'];
                                  echo jsonMsg(true, "เพิ่มข้อมูลสำเร็จ","success");
                              }else{
                                  echo db()->error;
                              }
                          }
                            break;
        }
    }
?>