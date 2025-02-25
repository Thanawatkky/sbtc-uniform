<?php
require '../vendor/autoload.php';
require '../api/function.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

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
    $room_name = $_REQUEST['room'];
} else {
    $room = "";
    $room_name = "ทั้งหมด";
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

// ดึงข้อมูลจากฐานข้อมูล

// กำหนดหัวข้อคงที่ก่อน
$headers = [
    'A' => 'ระดับชั้น',
    'B' => 'ห้อง',
    'C' => 'ชื่อ-สกุล',
    'E' => 'แผนก',
    'F' => 'เลขที่ใบสั่งจอง'
];
$whereConditions = ["tb_order.order_status = 1"];

if (isset($grade) && $grade !== '') {
    $whereConditions[] = "tb_user.g_id='" . $grade . "'";
}

if (isset($department) && $department !== '') {
    $whereConditions[] = "tb_user.dep_id='" . $department . "'";
}

if (isset($room) && $room !== '') {
    $whereConditions[] = "tb_user.room='" . $room . "'";
}

if (isset($quota) && $quota !== '') {
    $whereConditions[] = "tb_user.quota='" . $quota . "'";
}

if (isset($order_round) && $order_round !== '') {
    $sql_getRound = db()->query("SELECT * FROM tb_preorder WHERE pre_id='" . $order_round . "'");
    $fet_getRound = $sql_getRound->fetch_object();
    $whereConditions[] = "tb_order.order_date BETWEEN '" . $fet_getRound->start_at . "' AND '" . $fet_getRound->end_at . "'";
}

$where = !empty($whereConditions) ? " WHERE " . implode(" AND ", $whereConditions) : '';
$colIndex = 7; // เริ่มจาก G (ASCII 71)
$isQuotaValid = $quota == 1 || $quota == "";
$isGradeValid = false; // ค่าเริ่มต้นเป็น false

switch (getGrade($grade)) {
    case "ประกาศนียบัตรวิชาชีพ":
    case "ปวช.":
        $isGradeValid = true;
        break;
}


function getExcelColumnName($index) {
    $columnName = '';
    while ($index > 0) {
        $index--; // ปรับให้เริ่มจาก 0 (A = 1, B = 2, ...)
        $columnName = chr(($index % 26) + 65) . $columnName;
        $index = floor($index / 26);
    }
    return $columnName;
}
if(($isQuotaValid || $isGradeValid) && $quota != 0 && !(!$isGradeValid && $quota == "")) {
    $sql_quota = db()->query("SELECT tb_uquota.*,tb_product.* FROM tb_uquota LEFT JOIN tb_product ON tb_uquota.pro_id = tb_product.pro_id GROUP BY tb_product.pro_id ORDER BY tb_product.pro_type ASC");
    $startCol = getExcelColumnName($colIndex);
    $sum_quota = 0;
    while ($fet_quota = $sql_quota->fetch_object()) {
        $col = getExcelColumnName($colIndex); // ใช้ฟังก์ชันช่วยคำนวณคอลัมน์
        $headers[$col] = $fet_quota->pro_name;

        if ($fet_quota->pro_type != 3) {
            $colIndex++; 
            $headers[getExcelColumnName($colIndex)] = ''; // เพิ่มคอลัมน์ว่าง
            $colIndex++; // ขยับไป 2 คอลัมน์
        } else {
            $colIndex++; // ขยับไป 1 คอลัมน์
        }
        if($fet_quota->sex == 1) {
            $sum_quota_price = $fet_quota->pro_price * $fet_quota->u_qty;
            $sum_quota += $sum_quota_price;
            $sum_quota_price = 0;
        }
        $sheet->getStyle($col."2")->getAlignment()->setTextRotation(90);
        // ตรวจสอบว่าคอลัมน์ถัดไปคืออะไร
        $endCol = getExcelColumnName($colIndex-1); // คอลัมน์สุดท้ายที่มี pro_name
        
        // รวมเซลล์ระหว่าง $col และ $nextCol
    }
    $sheet->setCellValue($startCol."1", "ฟรี");
    $sheet->mergeCells($startCol.'1:'.$endCol.'1'); // รวมเซลล์จาก $startCol ถึง $endCol
    $sheet->getStyle($startCol."1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    }

    if(($isQuotaValid || $isGradeValid) && $quota != 0 && !(!$isGradeValid && $quota == "")) {
        $sql_product = db()->query("SELECT tb_uquota.*,tb_product.* FROM tb_uquota LEFT JOIN tb_product ON tb_uquota.pro_id = tb_product.pro_id GROUP BY tb_product.pro_id ORDER BY tb_product.pro_type ASC");
    }else{
        $sql_product = db()->query("SELECT * FROM tb_product ORDER BY pro_type ASC");
    }
    while ($fet_product = $sql_product->fetch_object()) {
        $col = getExcelColumnName($colIndex); // ใช้ฟังก์ชันช่วยคำนวณคอลัมน์
        $headers[$col] = $fet_product->pro_name;

        if ($fet_product->pro_type != 3) {
            $startcol = getExcelColumnName($colIndex);
            $colIndex++; 
            $headers[getExcelColumnName($colIndex)] = ''; // เพิ่มคอลัมน์ว่าง
            $endcol = getExcelColumnName($colIndex);
            $colIndex++; // ขยับไป 2 คอลัมน์
        } else {
            $colIndex++; // ขยับไป 1 คอลัมน์
            
        }
        $sheet->setCellValue($col."1", $fet_product->pro_price);
        $sheet->mergeCells(($startcol ?? $col).'1:'.($endcol ?? $col).'1');
        $sheet->getStyle($col."1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($col."2")->getAlignment()->setTextRotation(90);
        
    }

// เพิ่มคอลัมน์สุดท้ายเป็น "รวม"
if(($isQuotaValid || $isGradeValid) && $quota != 0 && !(!$isGradeValid && $quota == "")) {
    $headers[getExcelColumnName($colIndex)] = 'สิทธิ์เรียนฟรี';
    $headers[getExcelColumnName($colIndex+1)] = 'รวม';

}else{

    $headers[getExcelColumnName($colIndex)] = 'รวม';
}

// เพิ่มคอลัมน์สุดท้าย



// ใส่หัวตารางที่แถว 2 และกำหนดแนวการวางข้อความ
foreach ($headers as $col => $value) {
    $cell = "{$col}2";
    $sheet->setCellValue($cell, $value);

    // หมุนแนวตั้งเฉพาะ E ถึง Z
    
    
    
    if ($col == "A" || $col == "B" || $col == "C" || $col == "D" || $col == "E") {
        $sheet->getStyle($cell)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($cell)->getAlignment()->setVertical(Alignment::VERTICAL_BOTTOM);
    } else {
        $sheet->getStyle($cell)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($cell)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    }
    

    // จัดกึ่งกลาง
    
    
    // ✅ เปิดใช้ Text Wrap
    $sheet->getStyle($cell)->getAlignment("F2")->setWrapText(true);
    
    // ✅ AutoFit คอลัมน์
    if($col == 'E' || $col == "F" || $col == "D") {
        $sheet->getColumnDimension("F")->setWidth(8);
        $sheet->getColumnDimension("E")->setWidth(22);
        $sheet->getColumnDimension("D")->setWidth(20);
    }else if((empty($value) || $value == '') && ($col != "A" && $col != "B") ) {
        $sheet->getColumnDimension($col)->setWidth(4);
    }else{
    $sheet->getColumnDimension($col)->setAutoSize(true);
    }
}


// ✅ ตั้งค่าความสูงของแถวให้พอดีกับ Text Wrap
// $sheet->getRowDimension(2)->setRowHeight(100);

// ✅ กำหนดฟอนต์ TH Sarabun New ขนาด 16 ทั้งหมด

// ✅ ทำให้หัวตารางตัวหนา
$sheet->getStyle('A2:'.getExcelColumnName($colIndex).'2')->getFont()->setBold(true);

// ใส่ข้อมูลตัวอย่าง
$sql_order = db()->query("SELECT tb_order.*, tb_user.* FROM tb_order LEFT JOIN tb_user ON tb_order.cus_name = tb_user.user_id $where ORDER BY tb_user.g_id DESC");
$row = 2;
$num_order = $sql_order->num_rows;
$total = 0;

while ($order = $sql_order->fetch_assoc()) {
    $row++;
    $lastRow = $sheet->getHighestRow();
    $col = 'A';
    if(getGrade($order['g_id']) == "ประกาศนียบัตรวิชาชีพชั้นสูง") {
        $gradeName = "ปวส.";
    }else if(getGrade($order['g_id']) == "ประกาศนียบัตรวิชาชีพ") {
        $gradeName = "ปวช.";
    }else if(getGrade($order['g_id']) == "ปริญญาตรี") {
        $gradeName = "ป.ตรี";
    }
    $sheet->setCellValue("{$col}{$row}", $gradeName); 
    $col++;
    $sheet->setCellValue("{$col}{$row}", $order['room']); 
    $sheet->getStyle("{$col}{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle("{$col}{$row}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    $col++;
    $sheet->setCellValue("{$col}{$row}", $order['fullname']); 
    $col++;
    $sheet->setCellValue("{$col}{$row}", ""); 
    $col++;
    $sheet->setCellValue("{$col}{$row}", getDepartment($order['dep_id'])); 
    $col++;
    $sheet->setCellValue("{$col}{$row}", $order['order_id']);
    $sheet->getStyle("{$col}{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle("{$col}{$row}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER); 
    $col++;
    // ใส่ข้อมูลสินค้าในคอลัมน์
    if(($isQuotaValid || $isGradeValid) && $quota != 0 && !(!$isGradeValid && $quota == "")) {

    $sql_quota->data_seek(0); // รีเซ็ต pointer
    while ($pdQuota = $sql_quota->fetch_object()) {

        $sql_cartQuota = db()->query("SELECT * FROM tb_cart_quota WHERE cq_product = '".$pdQuota->pro_id."' AND order_id='".$order['order_id']."'");
        $sql_quota_sum = db()->query("SELECT SUM(cq_qty) AS sumquota FROM tb_cart_quota WHERE cq_product = '".$pdQuota->pro_id."'");
        $fet_sumquota = $sql_quota_sum->fetch_object();

        $i=0;
        if($sql_cartQuota->num_rows <= 0) {
            $col++;
        }
        while($fet_cartQuota = $sql_cartQuota->fetch_object()) {
            $cq_qty = !empty($fet_cartQuota->cq_qty) ? $fet_cartQuota->cq_qty : 0; 
            $sheet->setCellValue("{$col}{$row}", $fet_cartQuota->cq_size);
            $sheet->getStyle("{$col}{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("{$col}{$row}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER); 
            if($pdQuota->pro_type != 3) {
                $col++;
            }
            
            $sheet->setCellValue("{$col}{$row}", $fet_cartQuota->cq_qty);
            $sheet->setCellValue("{$col}".($num_order+3), "=SUM({$col}3:{$col}".($num_order+2).")");
            $sheet->getStyle("{$col}{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("{$col}{$row}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("{$col}".($num_order+3))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("{$col}".($num_order+3))->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            // $sum_quota += $fet_cartQuota->cq_qty * $product->pro_price;
        }
        $col++;
    }
    $col = $endCol;
    $col++;
}
    $sql_product->data_seek(0);
   
    
    while ($product = $sql_product->fetch_object()) {
        $sql_cart = db()->query("SELECT * FROM tb_cart WHERE ca_product = '".$product->pro_id."' AND order_id='".$order['order_id']."' ");
        $sql_cart_sum = db()->query("SELECT SUM(ca_qty) AS sumqty FROM tb_cart WHERE ca_product = '".$product->pro_id."'");
        if($sql_cart->num_rows <= 0) {
            $col++;
            
        }
        $fet_sum = $sql_cart_sum->fetch_object();
        while($fet_cart = $sql_cart->fetch_object()) {
           
            $sheet->setCellValue("{$col}{$row}", $fet_cart->ca_size);
            $sheet->getStyle("{$col}{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("{$col}{$row}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER); 
            if($product->pro_type != 3) {
                $col++;
            }
            $sheet->setCellValue("{$col}{$row}", $fet_cart->ca_qty);
            $sheet->setCellValue("{$col}".($num_order+3), "=SUM({$col}3:{$col}".($num_order+2).")");
            
            $sheet->getStyle("{$col}{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("{$col}{$row}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("{$col}".($num_order+3))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("{$col}".($num_order+3))->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            
           
        }
        $col++;

    }
        
       
    if(($isQuotaValid || $isGradeValid) && $quota != 0 && !(!$isGradeValid && $quota == "")) {

    // Total Quota
    $sheet->setCellValue(getExcelColumnName($colIndex)."{$row}", $sum_quota);
    $sheet->setCellValue(getExcelColumnName($colIndex).($num_order+3),  "=SUM(".getExcelColumnName($colIndex)."3:".getExcelColumnName($colIndex).($num_order+2).")");    
    $sheet->getStyle(getExcelColumnName($colIndex).($num_order+3))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle(getExcelColumnName($colIndex).($num_order+3))->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    

    // Total No Quota
    $sheet->setCellValue(getExcelColumnName($colIndex+1)."{$row}", $order['total_price']);
    $total += $order['total_price'];
    $sheet->setCellValue(getExcelColumnName($colIndex+1).($num_order+3),  "=SUM(".getExcelColumnName($colIndex+1)."3:".getExcelColumnName($colIndex+1).($num_order+2).")");
    // exit();
    $sheet->getStyle(getExcelColumnName($colIndex+1).($num_order+3))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle(getExcelColumnName($colIndex+1).($num_order+3))->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    $sheet->getStyle(getExcelColumnName($colIndex)."2")->getAlignment()->setTextRotation(90);
    }else{

    // Total No Quota
    $sheet->setCellValue(getExcelColumnName($colIndex)."{$row}", $order['total_price']);
    $total += $order['total_price'];
    $sheet->setCellValue(getExcelColumnName($colIndex).($num_order+3),  "=SUM(".getExcelColumnName($colIndex)."3:".getExcelColumnName($colIndex).($num_order+2).")");
    // exit();
    $sheet->getStyle(getExcelColumnName($colIndex).($num_order+3))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle(getExcelColumnName($colIndex).($num_order+3))->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    $sheet->getStyle(getExcelColumnName($colIndex)."2")->getAlignment()->setTextRotation(90);
    }
    
    $sheet->mergeCells('C'.($row).':D'.($row));
    

}

$sheet->mergeCells('C2:D2');
$sheet->getStyle('A1:'.getExcelColumnName($colIndex).$sheet->getHighestRow())->getFont()->setName('TH Sarabun New')->setSize(16);


// ✅ ตั้งค่า Text Wrap ให้ข้อมูลทั้งหมด
$sheet->getStyle('A3:Z'.$sheet->getHighestRow())->getAlignment()->setWrapText(true);

// กำหนดชื่อไฟล์และบันทึก
$filename = 'order_data.xlsx';
$writer = new Xlsx($spreadsheet);
$writer->save($filename);

// ส่งไฟล์ให้ดาวน์โหลด
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');

flush();
readfile($filename);
unlink($filename);
exit;
?>