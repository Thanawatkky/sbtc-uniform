
<div class="d-flex justify-content-center">
    <div class="card p-2 mt-3" style="max-width: 800px; width: 100%;">
        <!-- Card Header with Primary Color -->
        <div class="card-header bg-primary text-white">
            <h3>เเก้ไขข้อมูลการสั่งจองเครื่องแบบ</h3>
        </div>

        <div class="card-body">
            <form action="api/ac_order.php?ac=editorder&order_id=<?= $_REQUEST['order_id']; ?>" method="POST" id="frm_editOrder">
                <!-- ข้อมูลรหัสการสั่งซื้อและวันที่ -->
                 <?php 
                    $sql = db()->query("SELECT * FROM tb_order WHERE order_id = '".$_REQUEST['order_id']."' ");
                    $fet = $sql->fetch_object();
                 ?>
                <div class="mb-3">
                    <label for="order-id" class="form-label">รหัสการสั่งซื้อ</label>
                    <input type="text" class="form-control" id="order-id" name="order_id" value="<?= $fet->order_id; ?>" disabled>
                </div>
                <div class="mb-3">
                    <label for="order-date" class="form-label">วันที่สั่งซื้อ</label>
                    <input type="text" class="form-control" id="order-date" name="order_date" value="<?= date("d-m-Y",strtotime($fet->order_date)); ?>" disabled>
                </div>
            <!-- ตารางข้อมูลสินค้า -->
                <?php 
                    if($fet_profile->quota == 1) {
                ?>
                <h5>สิทธ์โควต้าเรียนฟรี</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>สินค้า</th>
                        <th>จำนวน</th>
                        <th>ไซส์/ขนาด</th>
                        <th>ราคา (฿)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $sql_quota = db()->query("SELECT tb_cart_quota.*,tb_product.* FROM tb_cart_quota LEFT JOIN tb_product ON tb_cart_quota.cq_product = tb_product.pro_id WHERE tb_cart_quota.order_id = '".$fet->order_id."' ");
                        $total_quota = 0;
                        while($fet_quota = $sql_quota->fetch_object()) {
                    ?>
                    <tr>
                        <td><?= $fet_quota->pro_name; ?></td>
                        <td><input type="number" class="form-control" name="editcq_qty" value="<?= $fet_quota->cq_qty; ?>" disabled></td>
                        <td><input type="text" class="form-control" name="editcq_size[<?= $fet_quota->cq_id; ?>]" value="<?= $fet_quota->cq_size; ?>" <?= $fet_quota->pro_type == 3 ? "disabled" : ""; ?>></td>
                        <td><?= $fet_quota->pro_price; ?></td>
                    </tr>
                   <?php
                   $sum_quota = $fet_quota->pro_price * $fet_quota->cq_qty;
                   $total_quota += $sum_quota;
                   $sum_quota = 0;
                 } 
                 ?>
                </tbody>
            </table>
            <h6>ราคารวม: <?= $total_quota; ?> ฿</h6>
                <!-- ส่วนการสั่งซื้อเพิ่มเติม -->
                 <?php } ?>
                <h5>การสั่งซื้อทั่วไป/การสั่งซื้อเพิ่มเติม</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>สินค้า</th>
                            <th>จำนวน</th>
                            <th>ไซส์/ขนาด</th>
                            <th>ราคา (฿)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $sql_product = db()->query("SELECT tb_cart.*,tb_product.* FROM tb_cart LEFT JOIN tb_product ON tb_cart.ca_product = tb_product.pro_id WHERE tb_cart.order_id='".$fet->order_id."' ");
                            $sum_total = 0;
                            while($fet_product = $sql_product->fetch_object()) {
                        ?>
                        <tr>
                            <td><?= $fet_product->pro_name; ?></td>
                            <td><input type="number" class="form-control" name="editca_qty[<?= $fet_product->ca_id; ?>]" value="<?= $fet_product->ca_qty;  ?>"></td>
                            <td><input type="text" class="form-control" name="editca_size[<?= $fet_product->ca_id; ?>]" value="<?= $fet_product->ca_size; ?>"></td>
                            <td><?= $fet_product->pro_price; ?></td>
                        </tr>
                        <?php
                        $sum_price = $fet_product->pro_price * $fet_product->ca_qty;
                        $sum_total += $sum_price;
                        $sum_price = 0;
                     } 
                     ?>
                    </tbody>
                </table>
                <h6 id="editTotal"></h6>
                <input type="hidden" name="sum_total" id="edit_Total">
                    
                <!-- ปุ่มยืนยันการแก้ไข -->
                <div class="mb-3">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check-circle"></i> ยืนยันการแก้ไข
                    </button>
                    <a href="?=history" class="btn btn-secondary">
                        <i class="fas fa-times"></i> ยกเลิก
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
