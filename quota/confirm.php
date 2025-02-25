<div class="container my-5">
    <h4 class="text-center" style="font-family: 'Mitr', sans-serif; color:#7a7a7a;">
        <i class="fas fa-list"></i> ยืนยันการสั่งจองเครื่องแบบ
    </h4>
    
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card mt-2">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="card-title" style="font-family: 'Mitr', sans-serif;">ข้อมูลรายละเอียดการสั่งจอง</h5>
                </div>
                
                <?php 
                    $sql_quota = db()->query("SELECT tb_cart_quota.*, tb_product.* FROM tb_cart_quota INNER JOIN tb_product ON tb_cart_quota.cq_product = tb_product.pro_id WHERE cq_user = '".$_SESSION['user_id']."' AND order_id = 0 ");
                    $sql_product = db()->query("SELECT tb_cart.*, tb_product.* FROM tb_cart LEFT JOIN tb_product ON tb_cart.ca_product = tb_product.pro_id WHERE ca_user = '".$_SESSION['user_id']."' AND order_id = 0 ");
                    
                    if ($sql_product->num_rows <= 0 && $sql_quota->num_rows <= 0) {
                        echo '<p class="text-center my-3">Order not found!</p>';
                    } else {
                ?>
                
                <div class="card-body">
                    <div class="row">
                        <?php if ($sql_quota->num_rows > 0) { ?>
                        <div class="col-md-<?= $sql_product->num_rows > 0 ? '6' : '12'; ?>">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title text-success"><i class="bi bi-check-circle"></i> ข้อมูลการสั่งจอง (เรียนฟรี)</h5>
                                    <?php 
                                        $total_quota = 0;
                                    ?>
                                    <?php while ($fet_quota = $sql_quota->fetch_object()) { ?>
                                    <p class="card-text">
                                        <i class="bi bi-shirt text-primary"></i> <?= $fet_quota->pro_name; ?> จำนวน: <?= $fet_quota->cq_qty; ?><br>
                                        <i class="bi bi-archive text-primary"></i> ไซส์: <?= $fet_quota->cq_size; ?> ราคา: <?= number_format($fet_quota->pro_price, 2) ?> THB.
                                    </p>
                                    <?php
                                    $price_quota = $fet_quota->pro_price * $fet_quota->cq_qty;
                                    $total_quota += $price_quota;
                                    $price_quota = 0;
                                 } 
                                 ?>
                                    <hr>
                                    <h5 class="text-success">สิทธิ์เรียนฟรีทั้งหมด <?= $total_quota; ?> ฿</h5>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                        <?php if ($sql_product->num_rows > 0) { ?>
                        <div class="col-md-<?= $sql_quota->num_rows > 0 ? '6' : '12'; ?>">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title text-success"><i class="bi bi-check-circle"></i> ข้อมูลการสั่งจอง (เพิ่มเติม)</h5>
                                    <?php $total = 0; while ($fet_product = $sql_product->fetch_object()) { ?>
                                    <p class="card-text">
                                        <i class="bi bi-shoes text-primary"></i> <?= $fet_product->pro_name; ?> จำนวน: <?= $fet_product->ca_qty; ?><br>
                                        <i class="bi bi-archive text-primary"></i> ไซส์: <?= $fet_product->ca_size; ?> ราคา: <?= number_format($fet_product->pro_price, 2); ?> THB.
                                    </p>
                                    <?php 
                                        $total += $fet_product->pro_price * $fet_product->ca_qty;
                                    } ?>
                                    <hr>
                                    <h5 class="text-success">ราคารวม: <?= number_format($total,2); ?> THB.</h5>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    
                    <div class="text-center py-3">
                        <?php if ($sql_product->num_rows > 0) { ?>
                        <h3 style="font-family: 'Mitr', sans-serif;">รวมทั้งหมด <?= number_format($total, 2); ?> THB.</h3>
                        <?php } ?>
                        <button type="button" class="btn btn-success" data-total="<?= $total; ?>" id="btn-confirm">ยืนยันคำสั่งซื้อ</button>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
