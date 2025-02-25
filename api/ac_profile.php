<?php 
session_start();
include 'function.php';

// ดึงข้อมูลปัจจุบันจากฐานข้อมูล
$sql = db()->query("SELECT * FROM tb_user WHERE user_id = '".$_SESSION['user_id']."' ");
$fet = $sql->fetch_object();

// ตรวจสอบค่าก่อนอัปเดต (ถ้าไม่มีค่าที่ส่งมา ให้ใช้ค่าปัจจุบัน)
$data = [
    'fullname' => isset($_REQUEST['fullname']) ? $_REQUEST['fullname'] : $fet->fullname,
    'tel' => isset($_REQUEST['tel']) ? $_REQUEST['tel'] : $fet->tel,
    'dep_id' => isset($_REQUEST['department']) ? $_REQUEST['department'] : $fet->dep_id,
    'g_id' => isset($_REQUEST['grade']) ? $_REQUEST['grade'] : $fet->g_id,
    'room' => isset($_REQUEST['room']) ? $_REQUEST['room'] : $fet->room,
];

$id = [
    'user_id' => $_SESSION['user_id']
];

// อัปเดตข้อมูลในฐานข้อมูล
if (update('tb_user', $data, $id)) {
    echo jsonMsg(true, 'แก้ไขข้อมูลสำเร็จ', 'success');
} else {
    echo db()->error;
}