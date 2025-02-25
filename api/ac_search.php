<?php 
    session_start();
    include 'function.php';
    if(isset($_REQUEST['ac'])) {
        switch ($_REQUEST['ac']) {
            case 'department':
                $sql = db()->query("SELECT * FROM tb_department WHERE g_id='".$_REQUEST['g_id']."' ");
                while($fet = $sql->fetch_object()) {

                    echo '<option value="" selected hidden disabled>เลือกแผนกวิชา</option>';
                    echo '<option value="'.$fet->dep_id.'">'.$fet->department.'</option>';
                }
                break;
            case 'room':
                $sql = db()->query("SELECT * FROM tb_department WHERE dep_id='".$_REQUEST['dep_id']."' ");
                $fet = $sql->fetch_object();
                for ($i=1; $i <= $fet->room_qty; $i++) { 
                    echo '<option value="" selected hidden disabled>เลือกห้องเรียน</option>';
                    echo '<option value="'.$i.'">ห้อง '.$i.'</option>';
                }
                break;
            case 'admin_department':
                $sql = db()->query("SELECT * FROM tb_department WHERE g_id='".$_REQUEST['g_id']."' ");
                echo '<option value="">ทั้งหมด</option>';
                while($fet = $sql->fetch_object()) {

                    echo '<option value="'.$fet->dep_id.'">'.$fet->department.'</option>';
                }
                break;
            case 'admin_room':
                $sql = db()->query("SELECT * FROM tb_department WHERE dep_id='".$_REQUEST['dep_id']."' ");
                $fet = $sql->fetch_object();
                echo '<option value="">ทั้งหมด</option>';
                for ($i=1; $i <= $fet->room_qty; $i++) { 
                    echo '<option value="'.$i.'">ห้อง '.$i.'</option>';
                }
                break;
            case 'order':
                $sql = db()->query("
                SELECT tb_order.*, tb_cart.ca_qty, tb_cart.ca_product, tb_cart.ca_size, tb_product.pro_name, tb_product.pro_price, 'normal' AS source_table
                FROM tb_order 
                LEFT JOIN tb_cart ON tb_order.order_id = tb_cart.order_id 
                LEFT JOIN tb_product ON tb_cart.ca_product = tb_product.pro_id 
                WHERE tb_order.order_id = '".$_REQUEST['order_id']."'
                
                UNION ALL
                
                SELECT tb_order.*, tb_cart_quota.cq_qty, tb_cart_quota.cq_product,tb_cart_quota.cq_size, tb_product.pro_name, tb_product.pro_price, 'free_quota' AS source_table
                FROM tb_order 
                LEFT JOIN tb_cart_quota ON tb_order.order_id = tb_cart_quota.order_id 
                LEFT JOIN tb_product ON tb_cart_quota.cq_product = tb_product.pro_id 
                WHERE tb_order.order_id = '".$_REQUEST['order_id']."'
            ");
            
            $total = [
                'free_quota' => 0,
                'normal' => 0
            ];
            
            $orders = [
                'free_quota' => '',
                'normal' => ''
            ];
            
            while ($fet = $sql->fetch_object()) {
                $total_price = $fet->pro_price * $fet->ca_qty;
            
                // ใช้ source_table เพื่อแยกประเภท
                $orderType = $fet->source_table;
            
                $row = '<tr>
                            <td>'.$fet->pro_name.'</td>
                            <td class="text-center">'.$fet->ca_qty.'</td>
                            <td class="text-center">'.$fet->ca_size.'</td>
                            <td class="text-end">'.$fet->pro_price.'</td>
                        </tr>';
                
                $orders[$orderType] .= $row;
                $total[$orderType] += $total_price;
            }
            
            $sections = [
                'free_quota' => 'โควต้าเรียนฟรี',
                'normal' => 'การสั่งซื้อทั่วไป/การสั่งซื้อเพิ่มเติม'
            ];
            
            $content = '<thead class="table-light">
                            <tr>
                                <th>สินค้า</th>
                                <th class="text-center">จำนวน</th>
                                <th class="text-center">ไซส์/ขนาด</th>
                                <th class="text-end">ราคา (฿)</th>
                            </tr>
                        </thead>';
            
            foreach ($sections as $key => $title) {
                if (!empty($orders[$key])) {
                    $content .= '<tr class="table-primary"><td colspan="4"><strong>'.$title.'</strong></td></tr>';
                    $content .= $orders[$key];
                    $content .= '<tr class="table-warning">
                                    <td colspan="3" class="text-end"><strong>ราคารวม</strong></td>
                                    <td class="text-end"><strong>'.$total[$key].' ฿</strong></td>
                                </tr>';
                }
            }
            
            echo $content;
            
                break;
                case 'reportData':


                                    // รับค่าจากฟอร์ม (ถ้าไม่มีให้เป็นค่าว่าง)
                    $grade = isset($_POST['grade']) ? $_POST['grade'] : '';
                    $department = isset($_POST['department']) ? $_POST['department'] : '';
                    $room = isset($_POST['room']) ? $_POST['room'] : '';
                    $quota = isset($_POST['quota']) ? $_POST['quota'] : '';
                    $order_round = isset($_POST['order_round']) ? $_POST['order_round'] : '';

                    // สร้าง SQL Query แบบ Dynamic + JOIN tb_user
                    $sql = "SELECT tb_order.*, tb_user.fullname, tb_user.tel, tb_user.dep_id, tb_user.g_id, tb_user.room 
                            FROM tb_order 
                            JOIN tb_user ON tb_order.cus_name = tb_user.user_id
                            WHERE ORDER BY order_id DESC";

                    if ($grade !== '') {
                        $sql .= " AND tb_user.g_id = '" . db()->real_escape_string($grade) . "'";
                    }

                    if ($department !== '') {
                        $sql .= " AND tb_user.dep_id = '" . db()->real_escape_string($department) . "'";
                    }

                    if ($room !== '') {
                        $sql .= " AND tb_user.room = '" . db()->real_escape_string($room) . "'";
                    }

                    if ($quota !== '') {
                        $sql .= " AND tb_order.quota = '" . db()->real_escape_string($quota) . "'";
                    }

                    if ($order_round !== '') {
                        $sql_round = db()->query("SELECT * FROM tb_preorder WHERE pre_status = 1");
                        $fet_round = $sql_round->fetch_object();
                        $sql .= " AND tb_order.order_date BETWEEN '".$fet_round->start_at."' AND '".$fet_round->end_at."' ";
                    }

                    // ดึงข้อมูลจากฐานข้อมูล
                    $result = db()->query($sql);

                    if ($result->num_rows > 0) {
                        echo "<table border='1'>
                                <tr>
                                    <th>รหัสคำสั่งซื้อ</th>
                                    <th>ชื่อลูกค้า</th>
                                    <th>เบอร์โทร</th>
                                    <th>แผนก</th>
                                    <th>ระดับชั้น</th>
                                    <th>ห้อง</th>
                                    <th>โครงการ</th>
                                </tr>";
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['order_id']}</td>
                                    <td>{$row['fullname']}</td>
                                    <td>{$row['tel']}</td>
                                    <td>{$row['dep_id']}</td>
                                    <td>{$row['g_id']}</td>
                                    <td>{$row['room']}</td>
                                    <td>" . ($row['quota'] == 1 ? 'โควต้าเรียนฟรี' : 'ปกติ') . "</td>
                                </tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "<p>ไม่พบข้อมูล</p>";
                    }


                    break;
        }
    }
?>