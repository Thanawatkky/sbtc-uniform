<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">จัดการรอบการสั่งจอง</h1>
    <div class="text-end px-3 pt-3">
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"> <i class="bi bi-plus-circle" ></i> เพิ่มรอบการสั่งจอง</button>
    </div>
</div>

<div class="card p-2 ">
    <div class="card-body ">
        <div class="table-responsive">

        
    <table class="table table-bordered" id="mytable">
    <thead>
        <tr>
            <th>#</th>
            <th>ปีการศึกษา</th>
            <th>เปิดวันที่</th>
            <th>สิ้นสุดวันที่</th>
            <th>สถานะ</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $sql = db()->query("SELECT * FROM tb_preorder ");
            $i=0;
            while($fet = $sql->fetch_object()) {
                $i++;
        ?>
        <tr>
            <td><?= $i; ?></td>
            <td><?= $fet->pre_year; ?></td>

            <td><?= date("d-m-Y",strtotime($fet->start_at)); ?></td>
            <td><?= date("d-m-Y",strtotime($fet->end_at)); ?></td>
            <td><?= $fet->pre_status == 1 ? "<span class='text-success'>อยู่ภายในระยะเวลา</span>" : "<span class='text-danger'>สิ้นสุดเวลาการสั่งจอง</span>"; ?></td>
            <td>
                <?php 
                    if($fet->pre_status != 1) {
                        continue;
                    }
                ?>
                <a href="#" title="แก้ไขข้อมูล" class="text-warning mx-2" data-id="<?= $fet->pre_id; ?>" data-year="<?= $fet->pre_year; ?>"  data-start="<?= $fet->start_at; ?>" data-end="<?= $fet->end_at; ?>"  data-bs-toggle="modal" data-bs-target="#exampleModal" id="btn-preEdit"><i class="bi bi-pencil-square"></i></a>
                <a href="#" title="สิ้นสุดรอบการขาย" class="text-danger" id="btn-endPre" data-id="<?= $fet->pre_id; ?>"><i class="bi bi-calendar-check-fill"></i></a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
</div>
    </div>
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">กำหนดรอบการสั่งจอง</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <form action="../api/ac_preorder.php?ac=add" method="post" id="frm_grade">
                <div class="mb-3">
                    <label for="pre_year" class="form-label">ปีการศึกษา</label>
                    <input type="text" name="pre_year" id="pre_year" class="form-control" placeholder="กรุณากรอกปีการศึกษา" required>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="mb-3">
                            <label for="pre_year" class="form-label">เปิดวันที่</label>
                            <input type="date" name="start_at" id="start_at" class="form-control datepicker" required>
                        </div>
                       
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="mb-3">
                            <label for="pre_year" class="form-label">สิ้นสุดวันที่</label>
                            <input type="date" name="end_at" id="end_at" class="form-control datepicker" required>
                        </div>
                </div>
                
                
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">ยืนยัน</button>
                <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
            </div>
        </form>
      
    </div>
  </div>
</div>