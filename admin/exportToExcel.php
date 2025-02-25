<?php
require '../vendor/autoload.php';
require '../api/function.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// ฟังก์ชันแปลงดัชนีเป็นชื่อคอลัมน์ Excel
function getExcelColumnName($index) {
    $columnName = '';
    while ($index > 0) {
        $index--;
        $columnName = chr(($index % 26) + 65) . $columnName;
        $index = floor($index / 26);
    }
    return $columnName;
}

// หัวตารางเริ่มต้น
$headers = [
    'A' => 'ระดับชั้น',
    'B' => 'ห้อง',
    'C' => 'ชื่อ-สกุล',
    'D' => 'แผนก',
    'E' => 'เลขที่ใบสั่งจอง'
];

$colIndex = 6; // เริ่มจากคอลัมน์ F

// ดึงข้อมูลสินค้า
$sql_product = db()->query("SELECT * FROM tb_product");
while ($fet_product = $sql_product->fetch_object()) {
    $col = getExcelColumnName($colIndex);
    
    if ($fet_product->pro_type != 3) {
        // เสื้อ กางเกง รองเท้า → 2 คอลัมน์ (Size + จำนวน)
        $headers[$col] = $fet_product->pro_name;
        $colIndex++;
        $headers[getExcelColumnName($colIndex)] = "";
    } else {
        // เข็มขัดหรือเข็ม → 1 คอลัมน์ (จำนวน)
        $headers[$col] = $fet_product->pro_name;
    }
    
    $colIndex++;
}

// ใส่หัวตารางที่แถว 1
foreach ($headers as $col => $value) {
    $sheet->setCellValue("{$col}1", $value);
    $sheet->getStyle("{$col}1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
}

// ดึงข้อมูลคำสั่งซื้อ
$sql_order = db()->query("SELECT tb_order.*, tb_user.* FROM tb_order JOIN tb_user ON tb_order.cus_name = tb_user.user_id");
$row = 2;

while ($order = $sql_order->fetch_assoc()) {
    $col = 'A';
    $sheet->setCellValue("{$col}{$row}", getGrade($order['g_id'])); $col++;
    $sheet->setCellValue("{$col}{$row}", $order['room']); $col++;
    $sheet->setCellValue("{$col}{$row}", $order['fullname']); $col++;
    $sheet->setCellValue("{$col}{$row}", getDepartment($order['dep_id'])); $col++;
    $sheet->setCellValue("{$col}{$row}", $order['order_id']); $col++;

    // ดึงข้อมูลสินค้าในตะกร้า
    $sql_cart = db()->query("SELECT * FROM tb_cart WHERE order_id = '{$order['order_id']}'");
    $cartData = [];
    while ($cart = $sql_cart->fetch_assoc()) {
        $cartData[$cart['pro_id']] = ['size' => $cart['size'], 'qty' => $cart['quantity']];
    }

    // ใส่ข้อมูลสินค้าในคอลัมน์
    $sql_product->data_seek(0); // รีเซ็ต pointer
    while ($product = $sql_product->fetch_object()) {
        
        if (isset($cartData[$product->pro_id])) {
            $sheet->setCellValue("{$col}{$row}", ($product->pro_type != 3) ? $cartData[$product->pro_id]['size'] : '');
            $col++;
            $sheet->setCellValue("{$col}{$row}", $cartData[$product->pro_id]['qty']);
        }
        $col++;
    }
    
    $row++;
}

// บันทึกไฟล์
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
