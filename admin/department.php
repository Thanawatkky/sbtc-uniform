<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">จัดการแผนกวิชา</h1>
    <div class="text-end px-3 pt-3">
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalId"><i class="bi bi-plus-circle"></i> เพิ่มข้อมูลแผนกวิชา</button>
    </div>
</div>
<div class="card p-2">
    <div class="card-body">
    <table class="table display table-bordered" id="mytable">
    <thead>
        <tr>
            <th>#</th>
            <th>ระดับชั้น</th>
            <th>แผนกวิชา</th>
            <th>จำนวนห้องเรียน</th>
            <th>จัดการ</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $sql = db()->query("SELECT tb_department.*, tb_grade.grade FROM tb_department LEFT JOIN tb_grade ON tb_department.g_id = tb_grade.g_id");
            $i=0;
            while($fet = $sql->fetch_object()) {
                $i++;
            
        ?>
    <tr>
            <td><?= $i; ?></td>
            <td><?= $fet->grade; ?></td>
            <td><?= $fet->department; ?></td>
            <td><?= $fet->room_qty; ?></td>
            <td>
                    <a href="#" class="text-warning mx-2" data-id="<?= $fet->dep_id; ?>" data-grade="<?= $fet->g_id; ?>" data-dep="<?= $fet->department; ?>" data-room="<?= $fet->room_qty; ?>" data-bs-toggle="modal" data-bs-target="#modalUpdateDep" id="editDep"><i class="bi bi-pencil-square"></i></a>
                    <a href="#" class="text-danger" id="delDep" data-id="<?= $fet->dep_id; ?>"><i class="bi bi-trash"></i></a>
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
                    เพิ่มข้อมูลแผนกวิชา
                </h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                <form action="../api/ac_department.php?ac=add" method="post" id="frm_grade">
                    <div class="mb-3">
                        <label for="g_id" class="form-label">เลือกระดับชั้น</label>
                        <select name="g_id" id="g_id" class="form-select">
                            <option value="" selected hidden disabled>เลือกระดับชั้น</option>
                            <?php 
                                $sql_grade = db()->query("SELECT * FROM tb_grade");
                                while($fet_grade = $sql_grade->fetch_object()) {
                            ?>
                            <option value="<?= $fet_grade->g_id; ?>"><?= $fet_grade->grade; ?></option>
                            <?php 
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="department" class="form-label">แผนกวิชา</label>
                        <input type="text" name="department" id="department" class="form-control" placeholder="กรุณากรอกข้อมูลแผนกวิชา" required>
                    </div>
                    <div class="mb-3">
                        <label for="room_qty" class="form-label">จำนวนห้องเรียน</label>
                        <input type="number" name="room_qty" id="room_qty" min="1" class="form-control" placeholder="กรุณากรอกจำนวนห้องเรียน" required>
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
    id="modalUpdateDep"
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
                    แก้ไขข้อมูลแผนกวิชา
                </h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
            <form action="../api/ac_department.php?ac=update" method="post" id="frm_grade">
                <input type="hidden" name="dep_id" id="dep_id">
                    <div class="mb-3">
                        <label for="g_id" class="form-label">เลือกระดับชั้น</label>
                        <select name="g_id" id="g_id1" class="form-select">
                            <option value="" selected hidden disabled>เลือกระดับชั้น</option>
                            <?php 
                                $sql_grade = db()->query("SELECT * FROM tb_grade");
                                while($fet_grade = $sql_grade->fetch_object()) {
                            ?>
                            <option value="<?= $fet_grade->g_id; ?>"><?= $fet_grade->grade; ?></option>
                            <?php 
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="department" class="form-label">แผนกวิชา</label>
                        <input type="text" name="department" id="department1" class="form-control" placeholder="กรุณากรอกข้อมูลแผนกวิชา" required>
                    </div>
                    <div class="mb-3">
                        <label for="room_qty" class="form-label">จำนวนห้องเรียน</label>
                        <input type="number" name="room_qty" id="room_qty1" min="1" class="form-control" placeholder="กรุณากรอกจำนวนห้องเรียน" required>
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

