<link href="https://fonts.googleapis.com/css2?family=Mitr&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <?php 
    
    
    if (isset($_REQUEST['grade']) && $_REQUEST['grade'] != "") {
        $grade = $_REQUEST['grade'];
        $sql_grade = db()->query("SELECT grade FROM tb_grade WHERE g_id='".$grade."' ");
        $fet_grade = $sql_grade->fetch_object();
        $grade_name = $fet_grade->grade;
    } else {
        $grade_name = "ทั้งหมด";
        $grade = "";
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
?>
    <div class="container mt-3">
    <h1 class="text-center mb-3">สรุปข้อมูล</h1>
    <form action="index.php" method="post">
        <div class="row g-3">
            <div class="col-md-3">
                <label for="grade" class="form-label">ระดับชั้น</label>
                <select class="form-select" id="grade" name="grade">
                    <option value="">ทั้งหมด</option>
                    <?php 
                        $sql_searchGrade = db()->query("SELECT * FROM tb_grade ");
                        while($fet_searchGrade = $sql_searchGrade->fetch_object()) {
                    ?>
                    <option value="<?= $fet_searchGrade->g_id; ?>"><?= $fet_searchGrade->grade; ?></option>
                    <?php } ?>
                </select>
            </div>
            
            <div class="col-md-3">
                <label for="room" class="form-label">ห้องเรียน</label>
                <select class="form-select" id="room" name="room">
                    <option value="">ทั้งหมด</option>
                
                </select>
            </div>
            <div class="col-md-3">
                <label for="project" class="form-label">สิทธิ์</label>
                <select class="form-select" id="quota" name="quota">
                    <option value="">ทั้งหมด</option>
                    <?php 
                        for($i=0;$i<=1;$i++) {
                    ?>
                    <option value="<?= $i; ?>"><?= getProject($i); ?></option>
                    <?php } ?> 
                </select>
            </div>
        </div>

        <div class="row g-3 mt-2">
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
                    <i class="fas fa-search"></i> ตรวจสอบข้อมูล
                </button>
            </div>

           
        </div>
    </form>

                            <!-- Card Display with Collapse -->
<div class="row mt-3">
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
                                                <i class="bi bi-door-open" style="color: rgb(95, 122, 171);"></i> ห้องเรียน: <?= $room_name; ?>
                                            </p>
                                            <!-- ข้อมูล 2 -->
                                            <p class="card-text" style="font-family: 'Mitr', sans-serif; width: 50%; padding-right: 10px;">
                                                <i class="bi bi-calendar" style="color: rgb(95, 122, 171);"></i> รอบการสั่งจอง:<?= $order_round_name; ?>    
                                                <br>
                                                <i class="bi bi-clipboard-check" style="color: rgb(95, 122, 171);"></i> โครงการ: <?= $quota == "1" ? "เรียนฟรี" : ($quota == "0" ? "ปกติ" : "ทั้งหมด") ?>
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
            

            
            $whereConditions = ["tb_user.dep_id = '".$fet_profile->dep_id."' "];

                if (isset($grade) && $grade !== '') {
                    $whereConditions[] = "tb_user.g_id='" . $grade . "'";
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

      

            $sql = db()->query("SELECT tb_order.*,tb_user.* FROM tb_order LEFT JOIN tb_user ON tb_order.cus_name = tb_user.user_id $where");

            
           
            $i=0;
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


<!-- Modal -->


