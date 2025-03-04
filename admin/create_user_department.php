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
            <th>Username</th>
            <th>รหัสผ่าน</th>
            <th>เเผนกวิชา</th>
            <th >Action</th>
        </tr>
    </thead>
    <tbody>
      <?php 
        $sql = db()->query("SELECT * FROM tb_user WHERE user_role = 3");
        $i=0;
        while ($fet = $sql->fetch_object()) {
            $i++;
      ?>
    <tr>
            <td><?= $i; ?></td>
            <td><?=  $fet->fullname; ?></td>
            <td><?=  $fet->username; ?></td>
            <td><?= $fet->password; ?></td>
            <td><?= getDepartment($fet->dep_id); ?></td>
            <td>
                    <a href="#" class="text-warning mx-2" data-id="<?= $fet->user_id; ?>" data-fullname="<?= $fet->fullname; ?>" data-username="<?= $fet->username; ?>" data-password="<?= $fet->password; ?>" data-dep="<?= $fet->dep_id;  ?>"  data-bs-toggle="modal" data-bs-target="#modalId" id="editDepHead"><i class="bi bi-pencil-square"></i></a>




                    <a href="#" class="text-danger" id="delDepHead" data-id="<?= $fet->user_id; ?>"><i class="bi bi-trash"></i></a>
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
                <form action="../api/ac_department.php?ac=add_head" method="post" id="frm_grade">
                    <div class="mb-3">
                        <label for="fullname" class="form-label">ข้อมูลผู้ดูเเล</label>
                        <input
                            type="text"
                            class="form-control"
                            name="fullname"
                            id="fullname"
                            aria-describedby="helpId"
                            placeholder="กรุณากรอกชื่อ-นามสกุล"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input
                            type="text"
                            class="form-control"
                            name="username"
                            id="username"
                            aria-describedby="helpId"
                            placeholder="กรุณากรอกชื่อผู้ใช้สำหรับใช้เข้าสู่ระบบ"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">สร้างรหัสผ่าน</label>
                        <input
                            type="text"
                            class="form-control"
                            name="password"
                            id="password"
                            aria-describedby="helpId"
                            placeholder="กรุณาสร้างรหัสผ่าน"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label for="dep_id" class="form-label">แผนก</label>
                        <select name="dep_id" id="dep_id" class="form-select" required>
                            <option value="" hidden selected disabled>เลือกแผนก</option>
                            <?php 
                                $sql_dep = db()->query("SELECT * FROM tb_department GROUP BY department");
                                while ($fet_dep = $sql_dep->fetch_object()) {
                            ?>
                            <option value="<?= $fet_dep->dep_id; ?>"><?= $fet_dep->department; ?></option>
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

