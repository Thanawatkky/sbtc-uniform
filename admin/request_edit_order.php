<link href="https://fonts.googleapis.com/css2?family=Mitr&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
   
    <div class="container mt-3">
    <h3 class="text-center mb-3"> <i class="fas fa-check-circle"></i> คำร้องขอเเก้ไขคำสั่งจอง !</h3>
    


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
            $sql = db()->query("SELECT tb_order.*,tb_user.* FROM tb_order LEFT JOIN tb_user ON tb_order.cus_name = tb_user.user_id WHERE tb_order.order_status = 4 OR tb_order.order_status = 5 OR tb_order.order_status = 6");
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
                    if($fet->order_status == 4) {

                    
                ?>
                <button class="btn btn-outline-warning" id="btn-confirmReq" data-id="<?= $fet->order_id; ?>">
                    <i class="fas fa-check-circle"></i> อนุมัติคำร้องขอ
                </button>
                <?php }else if($fet->order_status == 5) { ?>
                    <p style="color: rgb(0, 154, 103); font-family: 'Mitr', sans-serif;">กำลังดำเนินการเเก้ไข</p>
                <?php }else if($fet->order_status == 6) { ?>
                    <button class="btn btn-secondary" data-bs-toggle="modal" id="btn-recheck" data-id="<?= $fet->order_id; ?>" data-status="<?= $fet->order_status; ?>" data-date="<?= date("d-m-Y",strtotime($fet->order_date)); ?>" data-bs-target="#check_data">
                        <i class="fas fa-info-circle"></i> ตรวจสอบข้อมูล
                    </button>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>
      
    </tbody>
</table>

</div>
    </div>
</div>

