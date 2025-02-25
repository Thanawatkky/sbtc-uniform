 <!-- Sidebar -->
 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    <div class="sidebar-brand-icon">
       <img src="../img/logo/Logo_SBTC.jpg" class="rounded-circle" height="50" width="50">
    </div>
    <div class="sidebar-brand-text mx-3">SBTC Admin <sup></sup></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="index.php">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span>
    </a>
</li>

<!-- Nav Item - สรุปยอดนักเรียน รายระดับชั้น -->
<li class="nav-item active">
    <a class="nav-link" href="index.php?p=dashboard_Level">
        <i class="fas fa-fw fa-users"></i>
        <span>สรุปยอดนักเรียน รายระดับชั้น</span>
    </a>
</li>

<!-- Nav Item - สรุปยอดนักเรียน รายแผนก -->
<li class="nav-item active">
    <a class="nav-link" href="dashboard_Department.php">
        <i class="fas fa-fw fa-briefcase"></i>
        <span>สรุปยอดนักเรียน รายแผนก</span>
    </a>
</li>



<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Interface
</div>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-cog"></i>
        <span>จัดการ</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">จัดการทั้งหมด</h6>
            <a class="collapse-item" href="index.php?p=grade">จัดการระดับชั้น</a>
            <a class="collapse-item" href="index.php?p=department">จัดการแผนกวิชา</a>
            <a class="collapse-item" href="index.php?p=product">จัดการเครื่องเเบบ</a>
            <a class="collapse-item" href="index.php?p=size">จัดการไซส์เครื่องเเบบ</a>
        </div>
    </div>
</li>


<!-- Nav Item - Utilities Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
        aria-expanded="true" aria-controls="collapseUtilities">
        <i class="fas fa-fw fa-wrench"></i>
        <span>โควต้าเรียนฟรี</span>
    </a>
    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="index.php?p=quota_uniform">จัดการเครื่องเเบบ</a>

        </div>
    </div>
</li>
<li class="nav-item">
    <a class="nav-link" href="index.php?p=preorder">
        <i class="fas fa-fw fa-table"></i>
        <span>รอบการสั่งซื้อ</span></a>
</li>

<li class="nav-item">
    <a class="nav-link" href="index.php?p=create_user_department">
        <i class="fas fa-fw fa-table"></i>
        <span>สร้างผู้ใช้งาน สำหรับเเผนก</span></a>
</li>
<!-- Divider -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReport"
        aria-expanded="true" aria-controls="collapseUtilities">
        <i class="fas fa-fw fa-wrench"></i>
        <span>สรุป</span>
    </a>
    <div id="collapseReport" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="index.php?p=reportCateProduct">สรุปตามประเภท</a>
            <a class="collapse-item" href="index.php?p=reportProduct">สรุปรายห้องเรียน</a>
        </div>
    </div>
</li>



<li class="nav-item">
    <?php 
        $sql_countEdit = db()->query("SELECT * FROM tb_order WHERE order_status = 4 OR order_status = 5 ");
        
    ?>
    <a class="nav-link collapsed" href="index.php?p=request_edit_order">
        <span>คำร้องเเก้ไขคำสั่งจอง </span><?php 
            if($sql_countEdit->num_rows > 0) {

            
        ?>
        <span class="badge badge-sm text-bg-danger rounded-pill"><?= $sql_countEdit->num_rows; ?></span>
        <?php } ?>
    </a>
   
</li>

</ul>
<!-- End of Sidebar -->
