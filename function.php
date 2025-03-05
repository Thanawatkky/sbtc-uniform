<?php

    function db() {

    //    $conn = new mysqli("localhost","sbtcacth_uniform","VSFUBnKYbpCUYWg4rkS2","sbtcacth_uniform");
        $conn = new mysqli("localhost","root","","db_uniformfinal");

        
        ini_set('display_errors', 0);
        $conn->set_charset("utf8");
        return $conn;
    }

    function jsonMsg($status, $msg, $type) {
        return json_encode(["status" => $status, "msg" => $msg, "type"=> $type]);
    }
    function insert($table, $data) {
        $sql = "INSERT INTO $table";
        $fields = "";
        $values = "";
        foreach ($data as $row => $val) {
            $fields .= "$row, ";
            $values .= "'$val', ";
        }
        $fields = rtrim($fields, ", ");
        $values = rtrim($values, ", ");
        
        $sql .= "($fields) VALUES ($values)";
        return db()->query($sql);
    }

    function update($table, $data, $id) {
        $sql = "UPDATE $table SET ";

        foreach ($data as $rows => $val) {
            $sql .= "$rows = '$val', ";
        }
        $sql = rtrim($sql, ", ");
        $sql .= "WHERE ";

        foreach ($id as $key => $value) {
            $sql .= "$key = '$value' ";
        }
        return db()->query($sql);

    }

    function delete($table, $id) {
        $sql = "DELETE FROM $table WHERE ";
        foreach ($id as $row => $val) {
            $sql .= "$row = '$val' ";
        }
        return db()->query($sql);
    }
    function productType($type) {
        return $type == 1 ? "เสื้อนักเรียน-เสื้อฝึกงาน" : ($type == 2 ? "กางเกง-รองเท้า" : ($type == 3 ? "อุปกรณ์เสริมอื่นๆ" : "ไม่มีข้อมูลหมวดหมู่")) ;
    }

    function orderStatus($status) {
        if($status == 0) {
            return "กำลังดำเนินการ";
        }else if($status == 1){
            return "คำสั่งซื้อเสร็จสิ้น";
        }else if($status == 4) {
            return "รอเเอดมินอนุมัติแก้ไข";
        }else if($status == 9) {
            return "ข้อมูลไม่ถูกต้อง";
        }
    }
    function getGrade($id) {
        $sql = db()->query("SELECT grade FROM tb_grade WHERE g_id = '".$id."'");
        while ($fet = $sql->fetch_object()) {
            # code...
            return $fet->grade;
        }
    }
    function getDepartment($id) {
        $sql = db()->query("SELECT department FROM tb_department WHERE dep_id = '".$id."' ");
        
        while ($fet = $sql->fetch_object()) {
            # code...
            return $fet->department;
        }
    }

    function getProject($id) {
        $sql = db()->query("SELECT SUM(pro_price) as sum_total FROM view_price_quota WHERE sex = 1");

        $fet_sum = $sql->fetch_object();
        if($id == 1) {
            return "สิทธิ์เรียนฟรี 15 ปี (".$fet_sum->sum_total." บาท)";
        }else{
            return "ไม่ได้รับสิทธิ์เรียนฟรี";
        }
    }

    function getSex($sex) {
        return $sex == 1 ? "ชาย" : ($sex == 2  ? "หญิง" : "ทั้งหมด");
    }
?>