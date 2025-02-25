
<header class="bg-primary py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">ระบบสั่งจองเครื่องแบบนักศึกษา</h1>
                    <?php 
                        
                        if($sql_pre->num_rows > 0) {
                          
                    ?>
                    <p class="lead fw-normal text-white-50 mb-0">รอบการสั่งจอง <?= date("d/m/Y",strtotime($fet_pre->start_at)); ?> - <?= date("d/m/Y",strtotime($fet_pre->end_at)); ?></p>
                    <?php } ?>
                    
                </div>
            </div>
        </header><section class="py-5">
<div class="d-sm-flex align-items-center justify-content-between mx-5">
    <h3 class="h3 mb-0 text-secondary">สินค้าแนะนำ</h3>
</div>
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    <?php 
                        $sql = db()->query("SELECT * FROM tb_product LIMIT 4");
                        while($fet = $sql->fetch_object()){
                    ?>
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->  
                            <img class="card-img-top" src="img/product/<?= $fet->pro_img; ?>" alt="..." width="450" height="250" class="img-thumbnail" />
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
                                <div class="text-center"><button class="btn btn-outline-dark mt-auto" type="button" id="btn-cart" data-id="<?= $fet->pro_id; ?>">หยิบใส่ตะกร้า</button></div>
                            </div>
                        </div>
                    </div>
                   <?php } ?>
                </div>
            </div>
        </section>