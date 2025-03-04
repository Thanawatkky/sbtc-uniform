 <!-- Sidebar -->
 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    <div class="sidebar-brand-icon">
       <img src="../img/logo/Logo_SBTC.jpg" class="rounded-circle" height="50" width="50">
    </div>
    <div class="sidebar-brand-text mx-3">SBTC Admin Department<sup></sup></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">



<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Interface
</div>

<li class="nav-item">
    <a class="nav-link" href="index.php?p=edit_profile">
        <i class="fas fa-user-edit"></i>
        <span>เเก้ไขข้อมูลส่วนตัว</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link d-flex align-items-center" href="index.php?p=dashboard">
    <i class="fas fa-shopping-basket me-2"></i>
    <span>ตรวจสอบข้อมูลการสั่งจอง</span>
    </a>
</li>


<li class="nav-item">
    <?php 
        $sql_countEdit = db()->query("SELECT * FROM tb_order WHERE order_status = 9");
        
    ?>
    <a class="nav-link collapsed" href="index.php?p=request_edit_order">
        <span>ข้อมูลสั่งจองไม่ถูกต้อง </span><?php 
            if($sql_countEdit->num_rows > 0) {

            
        ?>
        <span class="badge badge-sm text-bg-danger rounded-pill"><?= $sql_countEdit->num_rows; ?></span>
        <?php } ?>
    </a>
   
</li>



</ul>
<!-- End of Sidebar -->
