<?php
session_start();
require('fpdf/fpdf.php'); // เรียกใช้ไลบรารี FPDF
require('api/function.php');


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
$pdf->Ln(5);

$sql_user = db()->query("SELECT * FROM tb_user WHERE user_id='".$_SESSION['user_id']."' ");
$fet_user = $sql_user->fetch_object();

$sql_order = db()->query("SELECT * FROM tb_order WHERE order_id='".$_REQUEST['order_id']."' ");
$fet_order = $sql_order->fetch_object();

// รหัสสั่งจอง และ วันที่สั่งจอง อยู่ในบรรทัดเดียวกัน
$pdf->SetFont('Sarabun', '', 16);
$pdf->Cell(50, 10, iconv('UTF-8', 'cp874', "รหัสสั่งจอง: " . $fet_order->order_id), 0, 0); // ใช้ 0,0 เพื่อให้ต่อกัน
$pdf->Cell(50, 10, iconv('UTF-8', 'cp874', "วันที่สั่งจอง: " . date("d-m-y", strtotime($fet_order->order_date))), 0, 1); // 1 เพื่อให้ขึ้นบรรทัดใหม่หลังจากแสดงผล

// ข้อมูลอื่นๆ อยู่บรรทัดเดียวกันใต้บรรทัดด้านบน
$pdf->Cell(70, 10, iconv('UTF-8', 'cp874', "ระดับชั้น: " . getGrade($fet_user->g_id)), 0, 0);
$pdf->Cell(60, 10, iconv('UTF-8', 'cp874', "แผนกวิชา: " . getDepartment($fet_user->dep_id)), 0, 0);
$pdf->Cell(50, 10, iconv('UTF-8', 'cp874', "ห้องเรียน: " . $fet_user->room), 0, 1);
$pdf->Cell(30, 10, iconv('UTF-8', 'cp874', "ชื่อ: " . $fet_user->fullname), 0, 0);

// $pdf->Cell(10, 0, iconv('UTF-8', 'cp874', 'หมายเหตุ'), 0);
$pdf->Ln();

$pdf->SetFont('Sarabun', 'B', 16); // ฟอนต์ปกติสำหรับข้อมูล
            $pdf->Cell(50, 10, iconv('UTF-8', 'cp874', "รายการ"), 1);
            $pdf->Cell(30, 10, iconv('UTF-8', 'cp874', "ขนาด/ไซส์"), 1);
            $pdf->Cell(30, 10, iconv('UTF-8', 'cp874','จำนวน') , 1);
            $pdf->Cell(40, 10, iconv('UTF-8', 'cp874','ราคารวม'), 1);
            $txt = "หมายเหตุ";
            if ($fet_user->quota == 1){
                $txt = "โครงการ"; 
            }
            $pdf->Cell(40, 10, iconv('UTF-8', 'cp874', $txt), 1);
        
            $pdf->Ln();

$total = 0;

$sum_total = 0;
$sql = db()->query("SELECT tb_cart.*,tb_product.* FROM tb_cart LEFT JOIN tb_product ON tb_cart.ca_product = tb_product.pro_id WHERE tb_cart.order_id = '".$fet_order->order_id."' ");
if ($fet_user->quota == 1){
        $sql_free = db()->query("SELECT tb_cart_quota.*,tb_product.* FROM tb_cart_quota LEFT JOIN tb_product ON tb_cart_quota.cq_product = tb_product.pro_id  WHERE tb_cart_quota.order_id = '".$fet_order->order_id."' ");
        while ($fet_free = $sql_free->fetch_object()) {
            $qty = $fet_free->cq_qty;
            $price_total = $fet_free->pro_price * $qty;

            $pdf->SetFont('Sarabun', '', 14); // ฟอนต์ปกติสำหรับข้อมูล
            $pdf->Cell(50, 10, iconv('UTF-8', 'cp874', $fet_free->pro_name), 1);
            $pdf->Cell(30, 10, iconv('UTF-8', 'cp874', $fet_free->cq_size), 1);
            $pdf->Cell(30, 10, $qty , 1);
            $pdf->Cell(40, 10, iconv('UTF-8', 'cp874',number_format($fet_free->pro_price * $qty , 2) . ' บาท'), 1);
            $pdf->Cell(40, 10, iconv('UTF-8', 'cp874', "สิทธิ์เรียนฟรี"), 1);
        
            $pdf->Ln();
        
            $total += $qty ;
            $sum_total += $price_total;

        }
        $pdf->SetFont('Sarabun', 'B', 16); // ใช้ฟอนต์ตัวหนา สำหรับผลรวม
        $pdf->Cell(80, 10, iconv('UTF-8', 'cp874', 'สิทธิ์เรียนฟรี'), 1);
        $pdf->Cell(30, 10, iconv('UTF-8', 'cp874', $total . ''), 1);
        $pdf->Cell(40, 10, iconv('UTF-8', 'cp874', number_format($sum_total, 2) . ' บาท'), 1);
        $pdf->Cell(40, 10, iconv('UTF-8', 'cp874', ""), 1);
        $pdf->Ln();
        $total = 0;
        $sum_total = 0;
        if($sql->num_rows > 0) {
            while ($fet = $sql->fetch_object()) {
                $qty = $fet->ca_qty;
                $price_total = $fet->pro_price * $qty;

                $pdf->SetFont('Sarabun', '', 14); // ฟอนต์ปกติสำหรับข้อมูล
                $pdf->Cell(50, 10, iconv('UTF-8', 'cp874', $fet->pro_name), 1);
                $pdf->Cell(30, 10, iconv('UTF-8', 'cp874', $fet->ca_size), 1);
                $pdf->Cell(30, 10, $qty , 1);
                $pdf->Cell(40, 10, iconv('UTF-8', 'cp874',number_format($fet->pro_price * $qty , 2) . ' บาท'), 1);
                $pdf->Cell(40, 10, iconv('UTF-8', 'cp874', "สั่งเพิ่มเติม"), 1);
            
                $pdf->Ln();
            
                $total += $qty ;
                $sum_total += $price_total;
            }
        }
    }else{
        while ($fet = $sql->fetch_object()) {
            $qty = $fet->ca_qty;
            $pdf->SetFont('Sarabun', '', 14); // ฟอนต์ปกติสำหรับข้อมูล
            $pdf->Cell(50, 10, iconv('UTF-8', 'cp874', $fet->pro_name), 1);
            $pdf->Cell(30, 10, iconv('UTF-8', 'cp874', $fet->ca_size), 1);
            $pdf->Cell(30, 10, $qty , 1);
            $pdf->Cell(40, 10, iconv('UTF-8', 'cp874',number_format($fet->pro_price * $qty , 2) . ' บาท'), 1);
            $pdf->Cell(40, 10, iconv('UTF-8', 'cp874', ""), 1);
        
            $pdf->Ln();
        
            $total += $qty ;
            $sum_total += $fet->pro_price * $qty ;
        }
    }
        
    
// วนลูปเพื่อแสดงข้อมูลในตาราง


// แสดงผลรวม
$pdf->SetFont('Sarabun', 'B', 16); // ใช้ฟอนต์ตัวหนา สำหรับผลรวม
$pdf->Cell(80, 10, iconv('UTF-8', 'cp874', 'รวมทั้งหมด'), 1);
$pdf->Cell(30, 10, iconv('UTF-8', 'cp874', $total . ''), 1);
$pdf->Cell(40, 10, iconv('UTF-8', 'cp874', number_format($sum_total, 2) . ' บาท'), 1);
$pdf->Cell(40, 10, iconv('UTF-8', 'cp874', ""), 1);

// ส่งออกไฟล์ PDF
$pdf->Output("Report.pdf","D"); // ดาวน์โหลดไฟล์ PDF
?>
