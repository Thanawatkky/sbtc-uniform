<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">จัดการเครื่องแบบสิทธิ์เรียนฟรี 15 ปี</h1>
</div>
<div class="w-full ">
    <h5>เครื่องแบบ</h5>
    <ul class="list-group " id="listA">
        <?php 
            $sql_product = db()->query("SELECT * FROM tb_product ");
            while ($fet_product = $sql_product->fetch_object()) {
                $sql_check = db()->query("SELECT * FROM tb_uquota WHERE pro_id='" . $fet_product->pro_id . "' ");
                if ($sql_check->num_rows > 0) {
                    continue;
                }
        ?>
        <li class="list-group-item d-flex align-items-center ps-4">
            <div class="d-flex align-items-center " style="width: 60%;">
                <?php $checkbox_id = "item_" . $fet_product->pro_id; ?>
                <input class="form-check-input  item-checkbox " type="checkbox" value="<?= $fet_product->pro_id; ?>" id="<?= $checkbox_id; ?>">
                <label class="form-check-label d-flex align-items-center" for="<?= $checkbox_id; ?>">
                    <img src="../img/product/<?= $fet_product->pro_img; ?>" alt="proimg" width="50px" height="50px" class="img-thumbnail me-2">
                    <span><?= htmlspecialchars($fet_product->pro_name, ENT_QUOTES, 'UTF-8'); ?></span>
                </label>
            </div>
            <div class="text-center" style="width: 20%;">
                <p class="mb-0">฿<?= number_format($fet_product->pro_price, 2); ?></p>
            </div>
            <div style="width: 20%;">
                <input type="number" class="form-control quantity-input text-center" placeholder="Qty" min="1" disabled>
            </div>
        </li>
        <?php } ?>
    </ul>
</div>


    <!-- Action Section -->
    <hr>
    <div class="row">
          <div class="col-6">
            <div class="text-center my-auto">
              <div class="mt-4">
                <button class="btn btn-success w-100" id="addBtn" disabled>
                  <i class="bi bi-arrow-down-circle-fill"></i> Add
                </button>
              </div>
            </div>
          </div>
          <div class="col-6">
            <div class="text-center my-auto">
              <div class="mt-4">
                <select name="sex" id="sex" class="form-select">
                      <option value="" hidden selected disabled>เลือกเพศ</option>
                      <option value="3">ทั้งหมด</option>
                      <option value="1">ชาย</option>
                      <option value="2">หญิง</option>
                </select>
              </div>
            </div>
          </div>
    </div>
    <hr>
    <!-- List B -->
     <div class="row">
     <?php 
        $sex = ['1' => "ชาย", '2' => 'หญิง'];
        foreach ($sex as $key => $value) {
     ?>
    <div class="col-md-6">
      <h5>เครื่องแบบสิทธิ์เรียนฟรี 15 ปี<?= $value; ?> จำนวน 950</h5>
      <ul class="list-group" id="listB<?= $key; ?>">
        <?php 
               $sql_get = db()->query("SELECT tb_uquota.*, tb_product.* FROM tb_uquota LEFT JOIN tb_product ON tb_uquota.pro_id = tb_product.pro_id WHERE tb_uquota.sex = '".$key."' OR tb_uquota.sex = 3");
               $sum_total = 0;
               while($fet_get = $sql_get->fetch_object()) {
                   
        ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <img src="../img/product/<?= $fet_get->pro_img; ?>" alt="proImg" width="50px" height="50px" class="img-thumbnail me-2">
                    <?= $fet_get->pro_name; ?> <div class="text-center mt-3">
          <p>฿<?= number_format($fet_get->pro_price,2); ?></p>
        </div> <span class="badge bg-primary">x<?= $fet_get->u_qty; ?></span>
                    <button class="btn btn-sm btn-danger remove-btn" data-id="<?= $fet_get->u_id; ?>" data-sex="<?= $key; ?>">
                        <i class="bi bi-x-circle"></i> Remove
                    </button>
            </li>
        <?php 
            $sum_total += $fet_get->pro_price * $fet_get->u_qty;
      } 
      ?>
      </ul>
      <h5 class="my-5 text-center text-center">ราคารวมเซ็ท<?= $value; ?> <?= $sum_total; ?> THB.</h5>
    </div>
    <?php }  ?>
     </div>


