<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">จัดการระดับชั้น</h1>
    <div class="text-end px-3 pt-3">
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalId"><i class="bi bi-plus-circle"></i> เพิ่มข้อมูลระดับขั้น</button>
    </div>
</div>
<div class="card p-2">
    <div class="card-body">
    <table class="table display table-bordered" id="mytable">
    <thead>
        <tr>
            <th>#</th>
            <th>ระดับชั้น</th>
            <th>สิทธิ์</th>
            <th >Action</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $sql = db()->query("SELECT * FROM tb_grade");
            $i=0;
            while($fet = $sql->fetch_object()) {
                $i++;
            
        ?>
    <tr>
            <td><?= $i; ?></td>
            <td><?= $fet->grade; ?></td>
            <td><?= getProject($fet->quota); ?></td>
            <td>
          
                    <a href="#" class="text-warning mx-2" data-id="<?= $fet->g_id; ?>" data-grade="<?= $fet->grade; ?>" data-quota="<?= $fet->quota; ?>" data-bs-toggle="modal" data-bs-target="#modalUpdateGrade" id="editGrade"><i class="bi bi-pencil-square"></i></a>
                    <a href="#" class="text-danger" id="delGrade" data-id="<?= $fet->g_id; ?>"><i class="bi bi-trash"></i></a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
    </div>
</div>


<!-- Modal Body -->
<!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
<div
    class="modal fade"
    id="modalId"
    tabindex="-1"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    
    role="dialog"
    aria-labelledby="modalTitleId"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-dialog-scrollable modal-dialog-centered"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">
                    เพิ่มข้อมูลระดับขั้น
                </h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                <form action="../api/ac_grade.php?ac=add" method="post" id="frm_grade">
                    <div class="mb-3">
                        <label for="grade" class="form-label">ข้อมูลระดับชั้น</label>
                        <input
                            type="text"
                            class="form-control"
                            name="grade"
                            id="grade"
                            aria-describedby="helpId"
                            placeholder="กรุณากรอกข้อมูลระดับชั้น"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label for="grade" class="form-label">ประเภท</label>
                        <select class="form-select" id="quota" name="quota">
                            <option value="">ทั้งหมด</option>
                            <?php 
                                for($i=0;$i<=1;$i++) {
                            ?>
                            <option value="<?= $i; ?>"><?= getProject($i); ?></option>
                            <?php } ?> 
                        </select>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                    >
                    Close
                </button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
        </div>
    </div>
</div>

<div
    class="modal fade"
    id="modalUpdateGrade"
    tabindex="-1"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    
    role="dialog"
    aria-labelledby="modalTitleId"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-dialog-scrollable modal-dialog-centered"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">
                    แก้ไขข้อมูลระดับชั้น
                </h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                <form action="../api/ac_grade.php?ac=update" method="post" id="frm_grade">
                    <input type="hidden" name="id" id="g_id">
                    <div class="mb-3">
                        <label for="grade" class="form-label">ข้อมูลระดับชั้น</label>
                        <input
                            type="text"
                            class="form-control"
                            name="grade"
                            id="grade1"
                            aria-describedby="helpId"
                            placeholder="กรุณากรอกข้อมูลระดับชั้น"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label for="grade" class="form-label">โครงการ</label>
                        <select name="quota" id="quota1" class="form-select" required>
                            <option value="" hidden selected disabled>เลือกโครงการ</option>
                            <option value="1">โควต้าเรียนฟรี</option>
                            <option value="0">ปกติ</option>
                        </select>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                    >
                    Close
                </button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
        </div>
    </div>
</div>

