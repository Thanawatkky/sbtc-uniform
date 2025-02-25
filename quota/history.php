
<div class="container  my-5">
<h4 class="mt-3 mb-3" style="font-family: 'Mitr', sans-serif; color:#7a7a7a; justify-content: center; text-align:center;"><i class="fas fa-list"></i> ยืนยันการสั่งจองเครื่องเเบบ</h4>
<?php 
    $sql_order = db()->query("SELECT * FROM tb_order WHERE cus_name='".$_SESSION['user_id']."' ORDER BY order_id DESC ");
    while($fet_order = $sql_order->fetch_object()) {
?>    
<div class="row">
        <div class="col-lg-2 col-md-12 col-sm-12"></div>
        <div class="col-lg-8 col-md-12 col-sm-12">
            <div class="card mt-2" style="width: 100%;">
                <div class="card-header bg-primary d-flex justify-content-between">
                    <h5 class="card-title" style="font-family: 'Mitr', sans-serif; color:#fff">
                        ข้อมูลรายละเอียดการสั่งจอง
                    </h5>
                    <h5 class="card-title" style="font-family: 'Mitr', sans-serif; color:#fff">
                        ออเดอร์: <?= $fet_order->order_id; ?>
                    </h5>
                </div>
                <div class="card-body">
                    <p>วันที่: <?= date("d-m-Y",strtotime($fet_order->order_date)); ?></p>
                    <div class="container-fluid">
                        <div class="row">
                            <!-- Example of Reserved Items -->
                            <div class="col-lg-6 mt-2">
                                <div class="card" style="border-radius: 10px;">
                                    <div class="card-body">
                                        <h5 class="card-title" style="font-family: 'Mitr', sans-serif;">
                                            <i class="bi bi-check-circle" style="color: rgb(0, 154, 103);"></i> ข้อมูลการสั่งจอง สำหรับเรียนฟรี
                                        </h5>
                                            <?php 
                                                $sql_quota = db()->query("SELECT tb_cart_quota.*, tb_product.* FROM tb_cart_quota INNER JOIN tb_product ON tb_cart_quota.cq_product = tb_product.pro_id WHERE cq_user = '".$_SESSION['user_id']."' AND order_id = '".$fet_order->order_id."' ");
                                                while($fet_quota = $sql_quota->fetch_object()) {
                                            ?>
                                        <p class="card-text" style="font-family: 'Mitr', sans-serif;">
                                            <i class="bi bi-shirt" style="color: rgb(95, 122, 171);"></i> <?= $fet_quota->pro_name; ?> จำนวน: <?= $fet_quota->cq_qty; ?>
                                            <br>
                                            <i class="bi bi-archive" style="color: rgb(95, 122, 171);"></i> ไซส์: <?= $fet_quota->cq_size; ?> ราคา: <?= number_format($fet_quota->pro_price, 2) ?> THB.
                                        </p>
                                        <?php } ?>
      
                                        <hr>
                                        <h5 class="card-title" style="font-family: 'Mitr', sans-serif; color: rgb(0, 154, 103);">
                                           สิทธิ์โควต้าเรียนฟรี
                                        </h5>
                                    </div>
                                </div>
                            </div>

                            <!-- Example of Additional Items -->
                            <div class="col-lg-6 mt-2">
                                <div class="card" style="border-radius: 10px;">
                                    <div class="card-body">
                                        <h5 class="card-title" style="font-family: 'Mitr', sans-serif;">
                                            <i class="bi bi-check-circle" style="color: rgb(0, 154, 103);"></i> ข้อมูลการสั่งจองเครื่องเเบบ เพิ่มเติม
                                        </h5>
                                        <?php 
                                            $sql_product = db()->query("SELECT tb_cart.*, tb_product.* FROM tb_cart LEFT JOIN tb_product ON tb_cart.ca_product = tb_product.pro_id WHERE ca_user = '".$_SESSION['user_id']."' AND order_id = '".$fet_order->order_id."' ");
                                            while($fet_product = $sql_product->fetch_object()) {
                                        ?>
                                        <p class="card-text" style="font-family: 'Mitr', sans-serif;">
                                            <i class="bi bi-shoes" style="color: rgb(95, 122, 171);"></i> <?= $fet_product->pro_name; ?> จำนวน: <?= $fet_product->ca_qty; ?>
                                            <br>
                                            <i class="bi bi-archive" style="color: rgb(95, 122, 171);"></i> ไซส์: <?= $fet_product->ca_size; ?> ราคา: <?= number_format($fet_product->pro_price, 2); ?> THB.
                                        </p>
                                        <?php } ?>
                                        <hr>
                                        <h5 class="card-title" style="font-family: 'Mitr', sans-serif; color: rgb(0, 154, 103);">
                                            ราคารวมทั้งสิ้น <?= number_format($fet_order->total_price,2); ?> THB.
                                        </h5>
                                    </div>
                                </div>
                            </div>

                            <!-- Total -->
                            <div class="text-center py-3">
                                <h5 style="font-family: 'Mitr', sans-serif;" class="<?= $fet_order->order_status == 0 ? 'text-warning' : 'text-success'; ?>"><?= orderStatus($fet_order->order_status); ?></h5>
                                <h3 style="font-family: 'Mitr', sans-serif;">รวมทั้งหมด <?= number_format($fet_order->total_price, 2); ?> THB.</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-12 col-sm-12"></div>
    </div>
<?php } ?>
</div>