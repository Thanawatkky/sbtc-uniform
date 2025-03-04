<?php 
    // รับค่าจากฟอร์ม (GET method)
    $pro_id = isset($_REQUEST['pro_id']) ? db()->real_escape_string($_REQUEST['pro_id']) : "";
    $grade = isset($_REQUEST['grade']) ? db()->real_escape_string($_REQUEST['grade']) : "";
    $department = isset($_REQUEST['department']) ? db()->real_escape_string($_REQUEST['department']) : "";
    $room = isset($_REQUEST['room']) ? db()->real_escape_string($_REQUEST['room']) : "";
    $quota = isset($_REQUEST['quota']) ? db()->real_escape_string($_REQUEST['quota']) : "";
    $order_round = isset($_REQUEST['order_round']) ? db()->real_escape_string($_REQUEST['order_round']) : "";
    
    // สร้างพารามิเตอร์ URL
    $params = [
        "pro_id" => $pro_id,
        "grade" => $grade,
        "department" => $department,
        "room" => $room,
        "quota" => $quota,
        "order_round" => $order_round
    ];
    
    // กรองพารามิเตอร์ที่ไม่มีค่าออก
    $params = array_filter($params);
    
    // สร้าง query string
    $queryString = http_build_query($params);
    $pdfUrl = "exportPDF.php" . (!empty($queryString) ? "?" . $queryString : "");
    
    ?>
   
    
<div class="container mt-3">
<h4 class="mb-3"><i class="fas fa-list"></i> สรุปยอดการสั่งจองเครื่องแบบ</h4>
    <form action="index.php?p=reportCateProduct" method="post">
            <div class="row g-3">
            <div class="col-md-3">
                    <label for="grade" class="form-label">ประเภทเครื่องเเบบ</label>
                    <select class="form-select" id="pro_id" name="pro_id">
                        <option value="">ทั้งหมด</option>
                        <?php 
                            $sql_productData = db()->query("SELECT * FROM tb_product");
                            while ($fet_productData = $sql_productData->fetch_object()) {
                              
                        ?>
                        <option value="<?= $fet_productData->pro_id; ?>"><?= $fet_productData->pro_name; ?></option>
                        <?php } ?>
                  
                    </select>
                </div>
                <div class="col-md-3">
                <label for="grade" class="form-label">ระดับชั้น</label>
                <select class="form-select" id="grade" name="grade">
                    <option value="">ทั้งหมด</option>
                    <?php 
                        $sql_grade = db()->query("SELECT * FROM tb_grade ");
                        while($fet_grade = $sql_grade->fetch_object()) {
                    ?>
                    <option value="<?= $fet_grade->g_id; ?>"><?= $fet_grade->grade; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-3">
                <label for="department" class="form-label">แผนกวิชา</label>
                <select class="form-select" id="department" name="department">
                    <option value="">ทั้งหมด</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="room" class="form-label">ห้องเรียน</label>
                <select class="form-select" id="room" name="room">
                    <option value="">ทั้งหมด</option>
                    
                </select>
            </div>
                <div class="col-md-3">
                    <label for="quota" class="form-label">สิทธิ์</label>
                    <select class="form-select" id="quota" name="quota">
                        <option value="">ทั้งหมด</option>
                        <?php 
                        for($i=0;$i<=1;$i++) {
                        ?>
                        <option value="<?= $i; ?>"><?= getProject($i); ?></option>
                        <?php } ?> 
                    </select>
                </div>

                <div class="col-md-3">
                <label for="order_round" class="form-label">รอบการสั่งจอง</label>
                <select class="form-select" id="order_round" name="order_round">
                    <option value="">ทั้งหมด</option>
                    <?php 
                        $sql_round = db()->query("SELECT * FROM tb_preorder WHERE pre_status = 1");
                        while($fet_round = $sql_round->fetch_object()) {
                    ?>
                    <option value="<?= $fet_round->pre_id; ?>"><?= $fet_round->pre_year; ?></option>
                    <?php } ?>
                </select>
            </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> สรุปข้อมูล
                    </button>
                </div>
                
                <div class="col-md-3 d-flex align-items-end">
                    <a type="button" class="btn btn-danger w-100" href="<?= htmlspecialchars($pdfUrl) ?>">
                        <i class="fas fa-file-pdf"></i> Export Report To PDF
                    </a>
                </div>
            </div>
        </form>
    </div>
   
    <?php 


// เงื่อนไขสำหรับการกรองข้อมูล
$where = "WHERE 1=1";
if (!empty($pro_id)) $where .= " AND tb_product.pro_id = '$pro_id'";
if (!empty($grade)) $where .= " AND tb_user.g_id = '$grade'";
if (!empty($department)) $where .= " AND tb_user.dep_id = '$department'";
if (!empty($room)) $where .= " AND tb_user.room = '$room'";

if (!empty($order_round)){
    $sql_getRound = db()->query("SELECT * FROM tb_preorder WHERE pre_id='".$order_round."' ");
                $fet_getRound = $sql_getRound->fetch_object();
                $where .= " AND tb_order.order_date BETWEEN '" . $fet_getRound->start_at . "' AND '" . $fet_getRound->end_at . "'";
}
if (empty($quota)){
// Query ข้อมูลที่สรุปยอด
$sql_size = db()->query("
    SELECT 
        tb_order.order_date,
        tb_cart.ca_product, 
        tb_cart.ca_size, 
        SUM(tb_cart.ca_qty) AS all_qty,
        tb_product.pro_name, 
        tb_product.pro_price
    FROM tb_cart 
    LEFT JOIN tb_product ON tb_cart.ca_product = tb_product.pro_id  
    LEFT JOIN tb_user ON tb_cart.ca_user = tb_user.user_id  
    LEFT JOIN tb_order ON tb_cart.order_id = tb_order.order_id
    $where
    GROUP BY tb_cart.ca_product, tb_cart.ca_size
");
}else{
    $sql_size = db()->query("
    SELECT 
        tb_order.order_date,
        tb_cart_quota.cq_product, 
        tb_cart_quota.cq_size, 
        SUM(tb_cart_quota.cq_qty) AS all_qty,
        tb_product.pro_name, 
        tb_product.pro_price
    FROM tb_cart_quota 
    LEFT JOIN tb_product ON tb_cart_quota.cq_product = tb_product.pro_id  
    LEFT JOIN tb_user ON tb_cart_quota.cq_user = tb_user.user_id  
    LEFT JOIN tb_order ON tb_cart_quota.order_id = tb_order.order_id
    $where
    GROUP BY tb_cart_quota.cq_product, tb_cart_quota.cq_size
");
}
$total = 0;
$sum_total = 0;
?>

<div class="container mt-4">

<?php 
    
    if (isset($_REQUEST['pro_id']) && $_REQUEST['pro_id'] != "") {
        $pro_id = $_REQUEST['pro_id'];
        $sql_product = db()->query("SELECT pro_name FROM tb_product WHERE pro_id='".$pro_id."' ");
        $fet_product = $sql_product->fetch_object();
        $pro_name = $fet_product->pro_name;
    } else {
        $pro_id = "";
        $pro_name = "ทั้งหมด";
    }
    if (isset($_REQUEST['grade']) && $_REQUEST['grade'] != "") {
        $grade = $_REQUEST['grade'];
        $sql_grade = db()->query("SELECT grade FROM tb_grade WHERE g_id='".$grade."' ");
        $fet_grade = $sql_grade->fetch_object();
        $grade_name = $fet_grade->grade;
    } else {
        $grade_name = "ทั้งหมด";
        $grade = "";
    }
    
    if (isset($_REQUEST['department']) && $_REQUEST['department'] != "") {
        $department = $_REQUEST['department'];
        $sql_department = db()->query("SELECT department FROM tb_department WHERE dep_id='".$department."' ");
        $fet_department = $sql_department->fetch_object();
        $department_name = $fet_department->department;
    } else {
        $department = "";
        $department_name = "ทั้งหมด";
    }
    
    if (isset($_REQUEST['room']) && $_REQUEST['room'] != "") {
        $room = $_REQUEST['room'];
    } else {
        $room = "ทั้งหมด";
    }
    
    if (isset($_REQUEST['quota']) && $_REQUEST['quota'] != "") {
        $quota = $_REQUEST['quota'];
    } else {
        $quota = "";
    }
    
    if (isset($_REQUEST['order_round']) && $_REQUEST['order_round'] != "") {
        $order_round = $_REQUEST['order_round'];
        $sql_order_round = db()->query("SELECT pre_year FROM tb_preorder WHERE pre_id='".$order_round."' ");
        $fet_order_round = $sql_order_round->fetch_object();
        $order_round_name = $fet_order_round->pre_year;
    } else {
        $order_round = "";
        $order_round_name = "ทั้งหมด";
    }
?>
                            <!-- Card Display with Collapse -->
<div class="row my-3">
    <div class="col-lg-12">
        <div class="card mt-2" style="width: 100%;">
            <div class="card-header bg-primary">
                <h5 class="card-title" style="font-family: 'Mitr', sans-serif; color:#fff" data-bs-toggle="collapse" data-bs-target="#searchSummary" aria-expanded="false" aria-controls="searchSummary">
                    ข้อมูลการค้นหา
                    <!-- Toggle Icon -->
                    <i class="bi bi-chevron-down" id="toggleIcon" style="float: right; cursor: pointer;"></i>
                </h5>
            </div>
            <div id="searchSummary" class="collapse show"> <!-- ทำให้แสดงผลทันทีเมื่อโหลด -->
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12 mt-2">
                                <div class="card shadow-sm" style="border-radius: 10px;">
                                    <div class="card-body">
                                        <h5 class="card-title" style="font-family: 'Mitr', sans-serif;">
                                            <i class="bi bi-file-earmark-check" style="color: rgb(0, 154, 103);"></i> สรุปข้อมูลการกรอกฟอร์ม
                                        </h5>
                                        <div class="d-flex flex-wrap">
                                            <!-- ข้อมูล 1 -->
                                            <p class="card-text" style="font-family: 'Mitr', sans-serif; width: 50%; padding-right: 10px;">
                                                <i class="bi bi-person-badge" style="color: rgb(95, 122, 171);"></i> ระดับชั้น: <?= $grade_name; ?>
                                                <br>
                                                <i class="bi bi-door-open" style="color: rgb(95, 122, 171);"></i> ห้องเรียน: <?= $room; ?>
                                            </p>
                                            <!-- ข้อมูล 2 -->
                                            <p class="card-text" style="font-family: 'Mitr', sans-serif; width: 50%; padding-right: 10px;">
                                                <i class="bi bi-building" style="color: rgb(95, 122, 171);"></i> แผนการศึกษา: <?= $department_name; ?>
                                                <br>
                                                <i class="bi bi-clipboard-check" style="color: rgb(95, 122, 171);"></i> ประเภท: <?= $quota != '' ? getProject($quota) : "ทั้งหมด";  ?>
                                                <br>
                                                <i class="bi bi-bag" style="color: rgb(95, 122, 171);"></i> ประเภทเครื่องแบบ: <?= $pro_name; ?>

                                            </p>
                                            <!-- ข้อมูล 3 -->
                                            <p class="card-text" style="font-family: 'Mitr', sans-serif; width: 100%;">
                                                <i class="bi bi-calendar" style="color: rgb(95, 122, 171);"></i> รอบการสั่งจอง:<?= $order_round_name; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>
    <div class="row">
    <?php while($fet = $sql_size->fetch_object()) { ?>
        <!-- Card รายการสินค้า -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-tshirt"></i> <?= $fet->pro_name; ?> ไซส์ <?= $quota == 1 ? $fet->cq_size : $fet->ca_size; ?>
                </div>
                <div class="card-body">
                    <h5 class="mb-1">จำนวน: <strong><?= $fet->all_qty; ?> ตัว</strong></h5>
                    <h6>ราคารวม: <strong><?= number_format($fet->pro_price * $fet->all_qty, 2); ?> บาท</strong></h6>
                </div>
            </div>
        </div>
    <?php 
        $total += $fet->all_qty;
        $sum_total += $fet->pro_price * $fet->all_qty;
    } 
    ?>

    <!-- Card แสดงจำนวนรวมทั้งหมด -->
    <div class="col-md-6">
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-success text-white">
                <i class="fas fa-box"></i> สรุปจำนวนทั้งหมด
            </div>
            <div class="card-body text-center">
                <h3><strong><?= $total; ?></strong> ตัว</h3>
            </div>
        </div>
    </div>

    <!-- Card แสดงราคารวมทั้งหมด -->
    <div class="col-md-6">
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-success text-white">
                <i class="fas fa-coins"></i> ราคารวมทั้งหมด
            </div>
            <div class="card-body text-center">
                <h3><strong><?= number_format($sum_total, 2); ?></strong> บาท</h3>
            </div>
        </div>
    </div>


</div>
