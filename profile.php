
    <div class="container my-5">

    
    <?php 
        $sql_profile2 = db()->query("SELECT tb_user.*, tb_grade.*, tb_department.* FROM tb_user INNER JOIN tb_grade ON tb_user.g_id = tb_grade.g_id INNER JOIN tb_department ON tb_user.dep_id = tb_department.dep_id WHERE user_id = '".$_SESSION['user_id']."' ");
        $fet_profile2 = $sql_profile2->fetch_object();
        
    ?>
      <div class="w-full">
        <div class="card mb-3">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">ชื่อ-นามสกุล</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <?= $fet_profile2->fullname;  ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">เลขบัตรประจำตัวประชาชน</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <?= $fet_profile2->citizen_id; ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">เบอร์โทรศัพท์</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <?= $fet_profile2->tel; ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">ขั้นปี</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <?= $fet_profile2->grade; ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">แผนกวิชา</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <?= $fet_profile2->department; ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">ห้อง</h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <?= $fet_profile2->room; ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-12">
                <a class="btn btn-info "  href="#frm_profile">Edit</a>
              </div>
            </div>
          </div>
        </div>



        <div class="card p-5">
            <form  action="api/ac_profile.php" method="post" id="frm_profile">
                
                
                <div class="mb-3">
                    <div class="form-floating">
                        <input type="number" class="form-control" id="citizen_id" name="citizen_id" value="<?= $fet_profile->citizen_id; ?>" placeholder="Phone Number" readonly disabled>
                        <label for="citizen_id"><i class="bi bi-person-vcard"></i> เลขบัตรประจำตัวประชาชน</label>
                    </div>
                    <span id="citizen_id-error" class="error" for="citizen_id"></span>
                </div>
                <div class=" mb-3">
                <div class="form-floating">
                    <input type="fullname" class="form-control" id="fullname" name="fullname" placeholder="fullname" value="<?= $fet_profile->fullname; ?>">
                    <label for="fullname"><i class="bi bi-person"></i> ชื่อ-นามสกุล</label>
                </div>
                <span id="fullname-error" class="error" for="fullname"></span>
                </div>
                <div class="mb-3">
                    <div class="form-floating">
                        <input type="tel" class="form-control" id="tel" name="tel" placeholder="Phone Number" value="<?= $fet_profile->tel; ?>">
                        <label for="tel"><i class="bi bi-telephone"></i> เบอร์โทรศัพท์</label>
                    </div>
                    <span id="tel-error" class="error" for="tel"></span>
                </div>
                <div class="form-floating">
                            <select class="form-select" id="grade" name="grade">
                                <option value="" selected hidden disabled>เลือกระดับชั้น</option>
                                <?php 
                                    $sql = db()->query("SELECT * FROM tb_grade");
                                    if($sql->num_rows <= 0) {
                                        echo "<option value=''>ไม่พบข้อมูล</option>";

                                    }else{
                                    while($fet = $sql->fetch_object()) {
                                ?>
                                <option value="<?= $fet->g_id; ?>" data-quota="<?= $fet->quota; ?>" ><?= $fet->grade; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                            <label for="grade"><i class="bi bi-briefcase"></i> ระดับชั้น</label>
                            <span id="grade-error" class="error" for="grade"></span>
                        </div>
                <div class="row my-3">
                    <div class="col">
                    <div class="form-floating">
                            <select class="form-select" id="department" name="department">
                                <option value="" selected hidden disabled>เลือกแผนกวิชา</option>
                                
                            </select>
                            <label for="department"><i class="bi bi-building"></i> แผนกวิชา</label>
                        </div>
                        <span id="department-error" class="error" for="department"></span>
                    </div>
                    <div class="col">
                        <div class="form-floating">
                            <select class="form-select" id="room" name="room">
                                <option value="" selected hidden disabled>เลือกห้องเรียน</option>
                                
                            </select>
                            <label for="job"><i class="bi bi-mortarboard"></i> ห้องเรียน</label>
                            <span id="room-error" class="error" for="room"></span>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">แก้ไขข้อมูลส่วนตัว</button>

            

            </form>
    </div>

   