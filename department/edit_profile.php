
<div class="container my-5">

    
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-primary text-white">
                    <h5>ข้อมูลส่วนตัว</h5>
                </div>
                <div class="card-body">
                    <!-- โหมดแสดงข้อมูล -->
                    <div id="viewMode">
                        <p><strong>ชื่อ-นามสกุล:</strong> <span id="displayFullName"><?= $fet_profile->fullname; ?></span></p>
                        <p><strong>Username:</strong> <span id="displayUsername"><?= $fet_profile->username; ?></span></p>
                        <p><strong>Password:</strong> <span id="displayPassword"><?= $fet_profile->password; ?></span></p>
                        <p><strong>แผนกวิชา:</strong> <span id="displayPassword"><?= getDepartment($fet_profile->dep_id); ?></span></p>
                        <button class="btn btn-warning w-100" data-bs-toggle="collapse" data-bs-target="#editMode">Edit</button>
                    </div>

                    <!-- โหมดแก้ไขข้อมูล -->
                    <div id="editMode" class="collapse">
                        <form action="../api/ac_department.php?ac=edit_profile" method="post" id="frm_grade">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?= $fet_profile->username; ?>" readonly disabled>
                            </div>
                            <div class="mb-3">
                                <label for="fullname" class="form-label">ชื่อ-นามสกุล</label>
                                <input type="text" class="form-control" id="fullname" name="fullname" value="<?= $fet_profile->fullname; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" value="<?= $fet_profile->password; ?>">
                            </div>
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-secondary w-100" data-bs-toggle="collapse" data-bs-target="#editMode">Cancel</button>
                                <button type="submit" class="btn btn-primary w-100">บันทึก</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ลิงก์ไปยัง Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>


