<?php 
    $sql_allorder = db()->query("SELECT * FROM tb_order");
    $num_allorder = $sql_allorder->num_rows;

    $sql_orderActive = db()->query("SELECT * FROM tb_order WHERE order_status = 1");
    $num_orderActive = $sql_orderActive->num_rows;

    $sql_orderWait = db()->query("SELECT * FROM tb_order WHERE order_status = 0");
    $num_orderWait = $sql_orderWait->num_rows;

    $sql_allStd = db()->query("SELECT * FROM tb_user WHERE user_role = 2");
    $num_allStd = $sql_allStd->num_rows;

    $sql_quotaStd = db()->query("SELECT * FROM tb_user WHERE user_role = 2 AND quota = 1");
    $num_quotaStd = $sql_quotaStd->num_rows;

    $sql_noQuota = db()->query("SELECT * FROM tb_user WHERE user_role = 2 AND quota = 0");
    $num_noQuota = $sql_noQuota->num_rows;

?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>
<div class="container-fluid">
    <div class="row">
        <!-- Card 1: ออร์เดอร์การสั่งจองทั้งหมด -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1" style="font-size: 16px;">ออร์เดอร์การสั่งจองทั้งหมด</div> <!-- ปรับขนาดตัวอักษร -->
                            <div class="h3 mb-0 font-weight-bold text-gray-800" style="font-size: 32px;"><?= $num_allorder; ?></div> <!-- ปรับขนาดตัวอักษร -->
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-3x text-gray-300"></i> <!-- ปรับขนาดไอคอน -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: ออร์เดอร์ที่ตรวจสอบแล้วทั้งหมด -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1" style="font-size: 16px;">ออร์เดอร์ที่ตรวจสอบแล้วทั้งหมด</div> <!-- ปรับขนาดตัวอักษร -->
                            <div class="h3 mb-0 font-weight-bold text-gray-800" style="font-size: 32px;"><?= $num_orderActive; ?></div> <!-- ปรับขนาดตัวอักษร -->
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-3x text-gray-300"></i> <!-- ปรับขนาดไอคอน -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: ออร์เดอร์ที่ยังไม่ได้ตรวจสอบ -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1" style="font-size: 16px;">ออร์เดอร์ที่ยังไม่ได้ตรวจสอบ</div> <!-- ปรับขนาดตัวอักษร -->
                            <div class="h3 mb-0 font-weight-bold text-gray-800" style="font-size: 32px;"><?= $num_orderWait; ?></div> <!-- ปรับขนาดตัวอักษร -->
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-3x text-gray-300"></i> <!-- ปรับขนาดไอคอน -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4: ยอดนักเรียน-นักศึกษาในระบบทั้งหมด -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1" style="font-size: 16px;">ยอดนักเรียน-นักศึกษาในระบบทั้งหมด</div> <!-- ปรับขนาดตัวอักษร -->
                            <div class="h3 mb-0 font-weight-bold text-gray-800" style="font-size: 32px;"><?= $num_allStd; ?></div> <!-- ปรับขนาดตัวอักษร -->
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-3x text-gray-300"></i> <!-- ปรับขนาดไอคอน -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 5: ยอดนักเรียน-นักศึกษา โควต้าเรียนฟรี ปวช ทั้งหมด -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1" style="font-size: 16px;">ยอดนักเรียน-นักศึกษา โควต้าเรียนฟรี ปวช ทั้งหมด</div> <!-- ปรับขนาดตัวอักษร -->
                            <div class="h3 mb-0 font-weight-bold text-gray-800" style="font-size: 32px;"><?= $num_quotaStd; ?></div> <!-- ปรับขนาดตัวอักษร -->
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-graduate fa-3x text-gray-300"></i> <!-- ปรับขนาดไอคอน -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 6: ยอดนักเรียน-นักศึกษา ปกติ ปวส ทั้งหมด -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1" style="font-size: 16px;">ยอดนักเรียน-นักศึกษา ปกติ ปวส ทั้งหมด</div> <!-- ปรับขนาดตัวอักษร -->
                            <div class="h3 mb-0 font-weight-bold text-gray-800" style="font-size: 32px;"><?= $num_noQuota; ?></div> <!-- ปรับขนาดตัวอักษร -->
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-tie fa-3x text-gray-300"></i> <!-- ปรับขนาดไอคอน -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>