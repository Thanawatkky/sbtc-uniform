
    <h2 class="text-center">สรุปจำนวนนักศึกษา</h2>

    <div class="row mt-4">
        <div class="col-md-6">
            <label for="classSelect" class="form-label">เลือกระดับชั้น:</label>
            <select id="classSelect" class="form-select" name="selectGrade">
                <option value="" selected>ทุกระดับชั้น</option>
                <?php 
                    $sql = db()->query("SELECT * FROM tb_grade");
                    while($fet = $sql->fetch_object()) {
                ?>
                <option value="<?= $fet->g_id; ?>"><?= $fet->grade; ?></option>
                <?php } ?>

            </select>
        </div>
    </div>

    <div class="mt-4">
        <canvas id="studentChart"></canvas>
    </div>