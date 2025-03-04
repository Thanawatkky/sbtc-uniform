<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">จัดการไซส์เครื่องแบบ</h1>
    <div class="text-end px-3 pt-3">
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"> <i class="bi bi-plus-circle" ></i> เพิ่มข้อมูลไซส์</button>
    </div>
</div>

<div class="card p-2 ">
    <div class="card-body ">
        <div class="table-responsive">

        
    <table class="table table-bordered" id="mytable">
    <thead>
        <tr>
            <th>#</th>
            <th>ไซส์เครื่องแบบ</th>
            <th>เพศ</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $sql = db()->query("SELECT tb_size.*,tb_product.pro_name FROM tb_size LEFT JOIN tb_product ON tb_size.size_product = tb_product.pro_id");
            $i=0;
            while($fet = $sql->fetch_object()) {
                $i++;
        ?>
        <tr>
            <td><?= $i; ?></td>
            <td>
                <img src="../img/size/<?= $fet->size_img; ?>" alt="proImg" width="50px" height="50px" class="img-thumbnail me-2">
                <?= $fet->pro_name; ?>
            </td>

            <td><?= $fet->sex == 1 ? "ชาย" : "หญิง"; ?></td>
            <td>
            <a href="#" class="text-primary"    data-img="<?= $fet->size_img; ?>"  data-bs-toggle="modal" data-bs-target="#modalviewSize" id="btn-viewSize"><i class="fas fa-eye"></i></a>

            <a href="#" class="text-warning mx-2" data-id="<?= $fet->size_id; ?>" data-name="<?= $fet->size_product; ?>"  data-img="<?= $fet->size_img; ?>" data-sex="<?= $fet->sex; ?>"  data-bs-toggle="modal" data-bs-target="#exampleModal" id="btn-sizeEdit"><i class="bi bi-pencil-square"></i></a>

            <a href="#" class="text-danger" id="btn-delSize" data-id="<?= $fet->size_id; ?>"><i class="bi bi-trash"></i></a>
                
                
        
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
</div>
    </div>
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">เพิ่มข้อมูลเครื่องแบบ</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="../api/ac_size.php?ac=add" method="post" enctype="multipart/form-data" id="frm_grade">
        <div class="mb-3">
            <label for="size_product" class="form-label">เครื่องแบบ</label>
              <select name="size_product" id="size_product" class="form-select">
                <option value="" selected disabled hidden>เลือกเครื่องเเบบ</option>
                <?php 
                  $sql_product = db()->query("SELECT * FROM tb_product");
                  while($fet_product = $sql_product->fetch_object()) {
                ?>
                <option value="<?= $fet_product->pro_id; ?>"><?= $fet_product->pro_name; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="mb-3">
            <label for="size_product" class="form-label">เพศ</label>
              <select name="sex" id="sex" class="form-select">
                <option value="" selected disabled hidden>เลือกเพศ</option>
                <option value="1">ชาย</option>
                <option value="2">หญิง</option>

              </select>
            </div>
            <div class="mb-3">
              <label for="size_img">แนบรูปภาพตารางไซส์</label>
              <input type="file" name="size_img" id="size_img" class="form-control" accept="image/png, image/jpg, image/jpeg" required>
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
    id="modalviewSize"
    tabindex="-1"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    
    role="dialog"
    aria-labelledby="modalTitleId"
    aria-hidden="true"
>   
    <div
        class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">
                    ข้อมูลไซส์เครื่องแบบ
                </h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                        <img  alt="sizeimg" class="img-thumbnail d-block mx-auto" id="imgproduct" width="450" height="450">
        
                </div>
                
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>