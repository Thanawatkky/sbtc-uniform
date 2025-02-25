<style>
                 body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 900px;
        }

        .product {
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
        }

        .product img {
            width: 80px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
        }

        .product-info h5 {
            margin-bottom: 5px;
        }

        .product-info p {
            font-size: 14px;
            color: #555;
        }

        .price {
            font-size: 18px;
            font-weight: bold;
            color: red;
        }

        .old-price {
            text-decoration: line-through;
            color: gray;
            font-size: 14px;
            margin-left: 5px;
        }

        .size-badge {
  
            background: #ddd;
            padding: 5px 10px;
            border-radius: 50%;
        }
</style>
<div class="container my-4 bg-white p-4 rounded shadow">
        <h2>ยืนยันคำสั่งซื้อ</h2>
            
        <?php 
            $sql = db()->query("SELECT tb_cart.*, tb_product.* FROM tb_cart INNER JOIN tb_product ON tb_cart.ca_product = tb_product.pro_id WHERE ca_user = '".$_SESSION['user_id']."' AND order_id = 0 ");
            while($fet = $sql->fetch_object()) {
        ?>
        <div class="row product align-items-center">
            <div class="col-md-2">
                <img src="img/product/<?= $fet->pro_img; ?>" width="80" height="100" alt="Product">
            </div>
            <div class="col-md-6 product-info">
                <h5><?= $fet->pro_name; ?></h5>
                <p>Size: <?= $fet->ca_size; ?></p>
                <span class="price">฿ <?= $fet->pro_price; ?></span>
               
            </div>
            <div class="col-md-4 text-end d-flex justify-content-between align-items-center">
                <label class="me-2">Quantity</label>
                <input type="num" value="<?= $fet->ca_qty; ?>" min="1" class="form-control d-inline w-auto text-center" style="max-width: 5rem;" readonly>
                <h5>฿ <?= $fet->ca_qty*$fet->pro_price; ?></h5>
            </div>
        </div>
        <?php } ?>
        <div class="text-center py-3">
            <h5>รวมทั้งหมด <?= $_REQUEST['sum_total']; ?> บาท</h5>
        </div>
        <div class="text-end">
            <button type="button" class="btn btn-success" data-total="<?= $_REQUEST['sum_total']; ?>" id="btn-confirm">ยืนยันคำสั่งซื้อ</button>
        </div>
    </div>