<section class="py-5">
    <div class="container px-4 px-lg-5">
                <h2 class="fw-bolder mb-4">สินค้าทั้งหมด</h2>
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    <?php 
                        $sql = db()->query("SELECT * FROM tb_product");
                        while($fet = $sql->fetch_object()) {
                    ?>
                    <div class="col-sm-12 col-lg-6 mb-5">
                 
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" src="../img/product/<?= $fet->pro_img; ?>" width="450" height="250" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder"><?= $fet->pro_name; ?></h5>
                                    <!-- Product price-->
                                    ฿<?= $fet->pro_price; ?>
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <?php 
                                                $sql_size = db()->query("SELECT * FROM tb_size WHERE size_product = '".$fet->pro_id."'");
                                                if($sql_size->num_rows > 0) {
                                                    $fet_size = $sql_size->fetch_object();
                                            ?>
                                            <div class="text-center mb-3">
                                            <button class="btn btn-sm btn-primary" id="btn-viewSize" data-bs-toggle="modal" data-bs-target="#modalviewSize" data-img="<?= $fet_size->size_img; ?>" data-name="<?= $fet->pro_name; ?>">
                                               ดูขนาดไซส์
                                            </button>
                                            </div>
                                            <?php } ?>
                                <div class="text-center">
                                    <button class="btn btn-outline-dark mt-auto" type="button" id="btn-cart" data-id="<?= $fet->pro_id; ?>">หยิบใส่ตะกร้า</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
        </div>
</section>