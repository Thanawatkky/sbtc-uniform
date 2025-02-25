<section class="py-5">
    <div class="container px-4 px-lg-5">
        <h2 class="fw-bolder mb-4">ตารางไซส์</h2>
        <div class="row">
            <?php 
                $sql = db()->query("SELECT * FROM tb_size");
                while($fet = $sql->fetch_object()) {
            ?>
            <div class="col-md-12 col-lg-6">
                <div class="d-flex justify-content-between align-items-center  py-3 px-5 text-secondary">
                    <h3 class="card-title"><?= $fet->size_product; ?></h3>
                    <h3 class="card-title">เพศ: <?= $fet->sex == 1 ? "ชาย" : "หญิง"; ?></h3>
                </div>
                <img src="../img/size/<?= $fet->size_img; ?>" alt="size" class="img-thumbnail" width="">
            </div>
            <?php } ?>

        </div> 
    </div>
</section>