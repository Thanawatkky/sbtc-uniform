<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">จัดการเครื่องแบบ</h1>
    <div class="text-end px-3 pt-3">
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"> <i class="bi bi-plus-circle" ></i> เพิ่มข้อมูลเครื่องแบบ</button>
    </div>
</div>
<div class="card p-2 ">
    <div class="card-body ">
        <div class="table-responsive">

        
    <table class="table table-bordered" id="mytable">
    <thead>
        <tr>
            <th>#</th>
            <th>เครื่องแบบ</th>
            <th>ราคา</th>
            <th>หมวดหมู่</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $sql = db()->query("SELECT * FROM tb_product");
            $i=0;
            while($fet = $sql->fetch_object()) {
                $i++;
        ?>
        <tr>
            <td><?= $i; ?></td>
            <td>
                <img src="../img/product/<?= $fet->pro_img; ?>" alt="proImg" width="50px" height="50px" class="img-thumbnail me-2">
                <?= $fet->pro_name; ?>
            </td>

            <td>฿<?= $fet->pro_price; ?></td>
            <td><?= productType($fet->pro_type); ?></td>
            <td>
            <a href="#" class="text-primary"  data-id="<?= $fet->pro_id; ?>" data-name="<?= $fet->pro_name; ?>" data-price="<?= $fet->pro_price; ?>" data-img="<?= $fet->pro_img; ?>" data-type="<?= productType($fet->pro_type); ?>" data-bs-toggle="modal" data-bs-target="#modalviewPd" id="btn-viewPd"><i class="fas fa-eye"></i></a>
            <a href="#" class="text-warning mx-2" data-id="<?= $fet->pro_id; ?>" data-name="<?= $fet->pro_name; ?>" data-price="<?= $fet->pro_price; ?>" data-type="<?= $fet->pro_type; ?>" data-bs-toggle="modal" data-bs-target="#modal-editpd" id="btn-editpd"><i class="bi bi-pencil-square"></i></a>
            <a href="#" class="text-danger" id="btn-delpd" data-id="<?= $fet->pro_id; ?>"><i class="bi bi-trash"></i></a>
                
                
        
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
</div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">เพิ่มข้อมูลเครื่องแบบ</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="../api/ac_product.php?ac=add" method="post" enctype="multipart/form-data" id="frm_grade">
            <!-- Product Name -->
            <div class="mb-3">
                <label for="productName" class="form-label">ชื่อสินค้า <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="pro_name" id="pro_name" placeholder="กรุณากรอกชื่อเครื่องแบบ" maxlength="20" required>
                <small class="form-text" >ไม่เกิน 20 ตัวอักษร</small>
            </div>
            <div class="mb-3">
                <label for="pro_price" class="form-label">ราคาสินค้า <span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="pro_price" id="pro_price" placeholder="กรุณากรอกราคาของเครื่องแบบ" min="1" required>
            </div>
            <div class="mb-3">
                <label for="pro_type">หมวดหมู่</label>
                <select name="pro_type" id="pro_type" class="form-select" required>
                    <option value="" selected hidden disabled>เลือกหมวดหมู่เสำหรับเครื่องแบบ</option>
                    <?php 
                        $type = ["1" => "เสื้อนักเรียน-เสื้อฝึกงาน", "2" => "กางเกง-รองเท้า", "3" => "อุปกรณ์เสริมอื่นๆ"];
                        foreach ($type as $key => $value) {
                    ?>
                            <option value="<?= $key; ?>"><?= $value; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="productName" class="form-label">รูปภาพเครื่องแบบ <span class="text-danger">*</span></label>
                <input type="file" class="form-control" name="pro_img" id="pro_img" accept="image/png, image/jpeg, image/jpg" required>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">ยืนยัน</button>
            <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
        </div>
    </form>
    </div>
  </div>
</div>
<div class="modal fade" id="modal-editpd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">แก้ไขข้อมูลเครื่องแบบ</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="../api/ac_product.php?ac=update" method="post" enctype="multipart/form-data" id="frm_grade">
            <!-- Product Name -->
             <input type="hidden" name="pro_id" id="pro_id">
            <div class="mb-3">
                <label for="productName" class="form-label">ชื่อสินค้า <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="pro_name" id="pro_name1" placeholder="กรุณากรอกชื่อเครื่องแบบ" maxlength="20" readonly>
                <small class="form-text" >ไม่เกิน 20 ตัวอักษร</small>
            </div>
            <div class="mb-3">
                <label for="pro_price" class="form-label">ราคาสินค้า <span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="pro_price" id="pro_price1" placeholder="กรุณากรอกราคาของเครื่องแบบ" min="1" required>
            </div>
            <div class="mb-3">
                <label for="pro_type">หมวดหมู่</label>
                <select name="pro_type" id="pro_type1" class="form-select" required>
                    <option value="" selected hidden disabled>เลือกหมวดหมู่เสำหรับเครื่องแบบ</option>
                    <?php 
                        $type = ["1" => "เสื้อนักเรียน-เสื้อฝึกงาน", "2" => "กางเกง-รองเท้า", "3" => "อุปกรณ์เสริมอื่นๆ"];
                        foreach ($type as $key => $value) {
                    ?>
                            <option value="<?= $key; ?>"><?= $value; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="productName" class="form-label">รูปภาพเครื่องแบบ <span class="text-danger">*</span></label>
                <input type="file" class="form-control" name="pro_img" id="pro_img" accept="image/png, image/jpeg, image/jpg">
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">ยืนยัน</button>
            <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
        </div>
    </form>
    </div>
  </div>
</div>



<div
    class="modal fade"
    id="modalviewPd"
    tabindex="-1"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    
    role="dialog"
    aria-labelledby="modalTitleId"
    aria-hidden="true"
>   
    <div
        class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">
                    ข้อมูลเครื่องแบบ
                </h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-4">
                        <img  alt="prodimg" class="img-thumbnail d-block mx-auto" id="imgproduct" width="225px" height="225px">
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-8">
                        <div class="text-center mt-5 pt-4 text-black">
                            <h2 id="txt-proname"></h2>
                            <p id="txt-protype" class="text-muted"></p>
                            <p id="txt-proprice"></p>
                       </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>