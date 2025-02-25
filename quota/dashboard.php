<?php 
    echo "  <style>
        /* Apply Kanit font to body */
        .card-header {
            background-color: #007bff;
            color: white;
        }
        .card-body {
            background-color: white;
        }
        .card-title {
            font-weight: 600;
            font-size: 1.2rem;
        }
        .text-muted {
            font-size: 0.9rem;
        }
        .btn {
            font-weight: 500;
        }
        /* Ensure form elements and text fit well on smaller screens */
        .form-select, .form-control {
            font-size: 0.9rem;
        }

        /* Smooth transitions for images and hover effects */
        .card-body img {
            transition: transform 0.3s ease;
        }
        .card-body img:hover {
            transform: scale(1.1);
        }

        /* Responsive Design Adjustments */
        @media (max-width: 768px) {
            .card-body img {
                width: 80px;
            }
            .btn {
                font-size: 0.9rem;
            }
        }

    </style>";
?>
<div class="container">
<div class="row justify-content-center my-5">
    
        <div class="col-lg-8 col-md-10">
      
            <div class="card shadow-lg rounded">
                <div class="card-header text-center">
                    <h4 class="mb-0"><i class="fas fa-tshirt"></i> เครื่องแบบสำหรับโควต้าเรียนฟรี</h4>
                </div>
                <div class="card-body">
                         <?php 
                            $sql = db()->query("SELECT tb_uquota.*, tb_product.* FROM tb_uquota LEFT JOIN tb_product ON tb_uquota.pro_id = tb_product.pro_id WHERE tb_uquota.sex = '".$_SESSION['sex']."' ");
                            while($fet = $sql->fetch_object()) {

                            
                         ?>

                        <div class="card mb-3">
                            <div class="row g-0">
                                <div class="col-md-4 text-center p-2">
                                    <img src="../img/product/<?= $fet->pro_img; ?>" style="width:100px;" alt="proImg">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= $fet->pro_name; ?></h5>
                                        <p class="text-muted mb-1">ราคา: <strong><?= $fet->pro_price; ?> บาท</strong></p>
                                        <?php 
                                            $sql_cartQuota = db()->query("SELECT * FROM tb_cart_quota WHERE cq_product = '".$fet->pro_id."' AND cq_user = '".$_SESSION['user_id']."' AND order_id = 0 ");
                                            
                                            if($sql_cartQuota->num_rows <= 0) {
                                      
                                            if($fet->pro_type == 1) {
                                                $size = ["s","m","l","xl","2xl","3xl","4xl","5xl"];
                                            
                                        ?>
                                            <select name="uq_size[<?= $fet->pro_id; ?>]" id="uq_size" class="form-select">
                                                <option value="" selected hidden disabled>เลือกไซส์</option>
                                                <?php 
                                                    foreach ($size as $key => $val) {
                                                        
                                                ?>
                                                <option value="<?= strtoupper($val); ?>"><?= strtoupper($val); ?></option>
                                                <?php } ?>

                                            </select>
                                            <input type="hidden" name="cq_qty[<?= $fet->pro_id; ?>]" id="qty" class="form-control" value="<?= $fet->u_qty; ?>">

                                            <?php }else if($fet->pro_type == 2) { ?>
                                                <input type="number" name="uq_size[<?= $fet->pro_id; ?>]" id="uq_size" class="form-control" placeholder="โปรดกรอก ขนาดเอว/ขนาดเท้า ของคุณ">
                                                <input type="hidden" name="cq_qty[<?= $fet->pro_id; ?>]" id="qty" class="form-control" value="<?= $fet->u_qty; ?>">
                                            <?php }else{ ?>
                                                <label for="qty">จำนวน</label>
                                                <input type="number" name="cq_qty[<?= $fet->pro_id; ?>]" id="qty" class="form-control" value="<?= $fet->u_qty; ?>" disabled readonly>
                                            <?php } ?>
                                        <?php }else{ ?>
                                            <?php
                                            $fet_size = $sql_cartQuota->fetch_object();
                                            if($fet->pro_type == 1) {
                                                $size = ["s","m","l","xl","2xl","3xl","4xl","5xl"];
                                            
                                        ?>
                                            <select name="uq_size[<?= $fet->pro_id; ?>]" id="uq_size" class="form-select">
                                                <option value="" selected hidden disabled>เลือกไซส์</option>
                                                <?php 
                                                    foreach ($size as $key => $val) {
                                                        
                                                ?>
                                                <option value="<?= strtoupper($val); ?>" <?php echo $fet_size->cq_size == strtoupper($val) ? "selected" : null;?>><?= strtoupper($val); ?></option>
                                                <?php } ?>

                                            </select>
                                            <input type="hidden" name="cq_qty[<?= $fet->pro_id; ?>]" id="qty" class="form-control" value="<?= $fet->u_qty; ?>">

                                            <?php }else if($fet->pro_type == 2) { ?>
                                                <input type="number" name="uq_size[<?= $fet->pro_id; ?>]" id="uq_size" value="<?= $fet_size->cq_size; ?>" class="form-control" placeholder="โปรดกรอก ขนาดเอว/ขนาดเท้า ของคุณ">
                                                <input type="hidden" name="cq_qty[<?= $fet->pro_id; ?>]" id="qty" class="form-control" value="<?= $fet->u_qty; ?>">
                                            <?php }else{ ?>
                                                <label for="qty">จำนวน</label>
                                                <input type="number" name="cq_qty[<?= $fet->pro_id; ?>]" id="qty" class="form-control" value="<?= $fet->u_qty; ?>" disabled readonly>
                                                
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                     

                        <!-- ปุ่ม -->
                        <div class="text-center">
                            <a href="index.php?p=product" class="btn btn-warning"><i class="fas fa-plus-circle"></i> สั่งจองเพิ่มเติม</a>
                            <a class="btn btn-success" href="index.php?p=confirm"><i class="fas fa-clipboard-list"></i> ดูข้อมูลสรุปการสั่งจอง</a>
                        </div>
                     
                </div>
            </div>
        </div>
    </div>
</div>