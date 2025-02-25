<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">สร้างผู้ใช้งาน สำหรับดูเเลรายเเผนก</h1>
    <div class="text-end px-3 pt-3">
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalId"><i class="bi bi-plus-circle"></i> สร้างผู้ใช้งาน</button>
    </div>
</div>
<div class="card p-2">
    <div class="card-body">
    <table class="table display table-bordered" id="mytable">
    <thead>
        <tr>
            <th>#</th>
            <th>ชื่อ-นามสกุล</th>
            <th>รหัสผ่าน</th>
            <th>เเผนกวิชา</th>
            <th >Action</th>
        </tr>
    </thead>
    <tbody>
      
    <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>
                    <a href="#" class="text-warning mx-2" data-id="<?= $fet->g_id; ?>" data-grade="<?= $fet->grade; ?>" data-quota="<?= $fet->quota; ?>" data-bs-toggle="modal" data-bs-target="#modalUpdateGrade" id="editGrade"><i class="bi bi-pencil-square"></i></a>
                    <a href="#" class="text-danger" id="delGrade" data-id="<?= $fet->g_id; ?>"><i class="bi bi-trash"></i></a>
            </td>
          
        </tr>

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
                    เพิ่มข้อมูลผู้ดูเเลรายเเผนกวิชา
                </h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="frm_createuser">
                    <div class="mb-3">
                        <label for="fullname_user" class="form-label">ข้อมูลผู้ดูเเล</label>
                        <input
                            type="text"
                            class="form-control"
                            name="fullname_user"
                            id="fullname_user"
                            aria-describedby="helpId"
                            placeholder="กรุณากรอกชื่อ-นามสกุล"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label for="pass_user" class="form-label">สร้างรหัสผ่าน</label>
                        <input
                            type="text"
                            class="form-control"
                            name="pass_user"
                            id="pass_user"
                            aria-describedby="helpId"
                            placeholder="กรุณาสร้างรหัสผ่าน"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label for="grade" class="form-label">แผนก</label>
                        <select name="quota" id="quota" class="form-select" required>
                            <option value="" hidden selected disabled>เลือกแผนก</option>
                            <option value="1">เทคโนโลยีสารสนเทศ</option>
                            <option value="0">ไฟฟ้ากำลัง</option>
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

