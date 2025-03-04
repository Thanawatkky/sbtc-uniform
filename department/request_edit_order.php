<link href="https://fonts.googleapis.com/css2?family=Mitr&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
   
    <div class="container mt-3">
    <h3 class="text-center mb-3"> ข้อมูลคำสั่งจองไม่ถูกต้อง !</h3>
    


<div class="card p-2 mt-3">
    <div class="card-body ">
        <div class="table-responsive">

        
        <table class="table table-bordered" id="mytable">
    <thead>
        <tr>
            <th>#</th>
            <th>ออเดอร์ที่</th>
            <th>ชื่อ</th>
            <th>ชั้น</th>
            <th>แผนกวิชา</th>
            <th>ห้อง</th>
            <th>เบอร์ติดต่อ</th>
            <th>รูปแบบ</th>
            <th>ตรวจข้อมูล</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $sql = db()->query("SELECT tb_order.*,tb_user.* FROM tb_order LEFT JOIN tb_user ON tb_order.cus_name = tb_user.user_id WHERE tb_order.order_status = 4 OR tb_order.order_status = 5 OR tb_order.order_status = 6 OR tb_order.order_status = 9 AND tb_user.dep_id = '".$fet_profile->dep_id."'");
            $i = 0;
            while($fet = $sql->fetch_object()) {
                $i++;
            ?>
        <tr>
            <td><?= $i; ?></td>
            <td><?= $fet->order_id; ?></td>
            <td><?= $fet->fullname; ?></td>
            <td><?= getGrade($fet->g_id); ?></td>
            <td><?= getDepartment($fet->dep_id); ?></td>
            <td><?= $fet->room; ?></td>
            <td><?= $fet->tel; ?></td>
            <td><?= $fet->quota == "1" ? "เพิ่มเติม" : ($fet->quota == '0' ? 'ปกติ' : 'เกิดข้อผิดพลาด'); ?></td>
            <td>
            <?php 
                        if($fet->order_status == 1) {
                            echo "ตรวจข้อมูลถูกต้อง";
                        }else if($fet->order_status == 4) {
                            echo "คำร้องขอแก้ไข";
                        }else if($fet->order_status == 5) {
                            echo "กำลังดำเนินการเเก้ไข";
                        }else if($fet->order_status == 0 || $fet->order_status == 6){
                            echo "รอการตรวจสอบ";
                        }else{ 
                            echo "ข้อมูลไม่ถูกต้อง";
                        }
                    ?>
            </td>
        </tr>
        <?php } ?>
      
    </tbody>
</table>

</div>
    </div>
</div>

