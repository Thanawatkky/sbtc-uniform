<?php
require('../fpdf/fpdf.php'); // เรียกใช้ไลบรารี FPDF
require('../api/function.php');
if (isset($_GET['pro_id']) && $_GET['pro_id'] != "") {
    $pro_id = $_GET['pro_id'];
    $sql_product = db()->query("SELECT pro_name FROM tb_product WHERE pro_id='".$pro_id."' ");
    $fet_product = $sql_product->fetch_object();
    $pro_name = $fet_product->pro_name;
} else {
    $pro_id = "";
    $pro_name = "ทั้งหมด";
}

if (isset($_GET['grade']) && $_GET['grade'] != "") {
    $grade = $_GET['grade'];
    $sql_grade = db()->query("SELECT grade FROM tb_grade WHERE g_id='".$grade."' ");
    $fet_grade = $sql_grade->fetch_object();
    $grade_name = $fet_grade->grade;
} else {
    $grade_name = "ทั้งหมด";
    $grade = "";
}

if (isset($_GET['department']) && $_GET['department'] != "") {
    $department = $_GET['department'];
    $sql_department = db()->query("SELECT department FROM tb_department WHERE dep_id='".$department."' ");
    $fet_department = $sql_department->fetch_object();
    $department_name = $fet_department->department;
} else {
    $department = "";
    $department_name = "ทั้งหมด";
}

if (isset($_GET['room']) && $_GET['room'] != "") {
    $room = $_GET['room'];
} else {
    $room = "";
}

if (isset($_GET['quota']) && $_GET['quota'] != "") {
    $quota = $_GET['quota'];
} else {
    $quota = "";
}

if (isset($_GET['order_round']) && $_GET['order_round'] != "") {
    $order_round = $_GET['order_round'];
    $sql_order_round = db()->query("SELECT pre_year FROM tb_preorder WHERE pre_id='".$order_round."' ");
    $fet_order_round = $sql_order_round->fetch_object();
    $order_round_name = $fet_order_round->pre_year;
} else {
    $order_round = "";
    $order_round_name = "ทั้งหมด";
}

// สร้างอินสแตนซ์ของ FPDF
$pdf = new FPDF();
$pdf->AddPage();

// เพิ่มฟอนต์ Sarabun
$pdf->AddFont('Sarabun', '', 'THSarabunNew.php'); // ฟอนต์ปกติ
$pdf->AddFont('Sarabun', 'B', 'THSarabunNew Bold.php'); // ฟอนต์ตัวหนา

// กำหนดฟอนต์ให้กับการแสดงผลข้อความ
$pdf->SetFont('Sarabun', 'B', 18); // ใช้ฟอนต์ปกติขนาด 16 สำหรับหัวข้อ

// เพิ่มข้อความใน PDF
$pdf->Cell(0, 10, iconv('UTF-8', 'cp874', 'รายงานการสั่งจองเครื่องแบบ'), 0, 1, 'C');
$pdf->Ln(10);
$pdf->SetFont('Sarabun', '', 16); // ฟอนต์ตัวหนา สำหรับหัวตาราง

$pdf->Cell(50, 10, iconv('UTF-8', 'cp874', "ประเภทเครื่องแบบ: " . ($pro_name ?: "ทั้งหมด")), 0, 1);
$pdf->Cell(30, 10, iconv('UTF-8', 'cp874', "ระดับชั้น: " . ($grade_name ?: "ทั้งหมด")), 0, 1);
$pdf->Cell(20, 10, iconv('UTF-8', 'cp874', "แผนกวิชา: " . ($department_name ?: "ทั้งหมด")), 0, 1);
$pdf->Cell(0, 10, iconv('UTF-8', 'cp874', "ห้องเรียน: " . ($room ?: "ทั้งหมด")), 0, 1);
$pdf->Cell(0, 10, iconv('UTF-8', 'cp874', "โครงการ: " . ($quota == "1" ? "โควต้าเรียนฟรี" : "ปกติ")), 0, 1);
$pdf->Cell(0, 10, iconv('UTF-8', 'cp874', "รอบการสั่งจอง: " . ($order_round_name ?: "ทั้งหมด")), 0, 1);

// สร้างตารางโดยใช้ฟอนต์ตัวหนา
$pdf->SetFont('Sarabun', 'B', 16); // ฟอนต์ตัวหนา สำหรับหัวตาราง
$pdf->Cell(50, 10, iconv('UTF-8', 'cp874', 'สินค้า'), 1);
$pdf->Cell(30, 10, iconv('UTF-8', 'cp874', 'ไซส์'), 1);
$pdf->Cell(30, 10, iconv('UTF-8', 'cp874', 'จำนวน'), 1);
$pdf->Cell(40, 10, iconv('UTF-8', 'cp874', 'ราคารวม'), 1);
$pdf->Cell(40, 10, iconv('UTF-8', 'cp874', 'หมายเหตุ'), 1);
// $pdf->Cell(10, 0, iconv('UTF-8', 'cp874', 'หมายเหตุ'), 0);
$pdf->Ln();

// เชื่อมต่อฐานข้อมูลและดึงข้อมูล

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
    $sql = db()->query("
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
        $sql = db()->query("
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

// วนลูปเพื่อแสดงข้อมูลในตาราง
while ($fet = $sql->fetch_object()) {
    $pdf->SetFont('Sarabun', '', 14); // ฟอนต์ปกติสำหรับข้อมูล
    $pdf->Cell(50, 10, iconv('UTF-8', 'cp874', $fet->pro_name), 1);
    $pdf->Cell(30, 10, iconv('UTF-8', 'cp874', $quota == 1 ? $fet->cq_size : $fet->ca_size), 1);
    $pdf->Cell(30, 10, $fet->all_qty, 1);
    $pdf->Cell(40, 10, iconv('UTF-8', 'cp874',number_format($fet->pro_price * $fet->all_qty, 2) . ' บาท'), 1);
    $pdf->Cell(40, 10, iconv('UTF-8', 'cp874', ""), 1);
    $pdf->Ln();

    $total += $fet->all_qty;
    $sum_total += $fet->pro_price * $fet->all_qty;
}

// แสดงผลรวม
$pdf->SetFont('Sarabun', 'B', 16); // ใช้ฟอนต์ตัวหนา สำหรับผลรวม
$pdf->Cell(80, 10, iconv('UTF-8', 'cp874', 'รวมทั้งหมด'), 1);
$pdf->Cell(30, 10, iconv('UTF-8', 'cp874', $total . ' ตัว'), 1);
$pdf->Cell(40, 10, iconv('UTF-8', 'cp874', number_format($sum_total, 2) . ' บาท'), 1);
$pdf->Cell(40, 10, iconv('UTF-8', 'cp874', ""), 1);

// ส่งออกไฟล์ PDF
$pdf->Output("Report.pdf","D"); // ดาวน์โหลดไฟล์ PDF
?>
