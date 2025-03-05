<nav class="navbar navbar-expand-lg navbar-light bg-ligth border-bottom">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="#!"><img src="img/logo/Logo_SBTC.jpg" alt="Logo" width="50" height="50" class=""></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php"><i class="bi bi-house-door"></i> หน้าแรก</a></li>
                        <li class="nav-item"><a class="nav-link active" href="?p=product"><i class="bi bi-bag"></i> สินค้าทั้งหมด</a></li>
                        
                    </ul>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-outline-dark" type="submit" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                            <i class="bi-cart-fill me-1"></i>
                            Cart
                            <?php 
                                $sql_sumCart = db()->query("SELECT * FROM tb_cart WHERE ca_user='".$_SESSION['user_id']."' AND order_id = 0 ");
                            ?>
                            <span class="badge bg-dark text-white ms-1 rounded-pill"><?= $sql_sumCart->num_rows; ?></span>
                        </button>
                        <div class="dropdown mx-4">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-person-fill"></i> <?=  $fet_profile->fullname; ?></a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="index.php?p=profile"><i class="bi bi-pencil"></i> แก้ไขข้อมูลส่วนตัว</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="?p=history"><i class="bi bi-clock-history"></i> ประวัติการสั่งซื้อ</a></li>
                                <li><a class="dropdown-item" href="#!" id="btn-logout"><i class="bi bi-door-open"></i> ออกจากระบบ</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>