<?php 
    session_start();
    if(!$_SESSION['user_id']) {
        header("Location: ../login.php");
    }
    include '../api/function.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php 
            include 'sidebar.php';
            ?>
       
       <!-- Content Wrapper -->
       <div id="content-wrapper" class="d-flex flex-column">
           
           <!-- Main Content -->
           <div id="content">
               
                   <?php 
                      include 'navbar.php';
                      
                      ?>  

<!-- Begin Page Content -->
<div class="container-fluid">
    <h2 class="text-center">สรุปจำนวนนักศึกษา</h2>

    <div class="row mt-4">
        <div class="col-md-6">
            <label for="classSelect" class="form-label">เลือกแผนกวิชา:</label>
            <select id="classSelect" class="form-select" onchange="updateChart()">
                <?php 
                    $sql = db()->query("SELECT * FROM tb_department GROUP BY department");
                    while($fet = $sql->fetch_object()) {
                ?>
                <option value="<?= $fet->department; ?>" <?= $fet->department == "เทคโนโลยีสารสนเทศ" ? "selected" : ""; ?>><?= $fet->department; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-6">
            <label for="classLevelSelect" class="form-label">เลือกระดับชั้น:</label>
            <select id="classLevelSelect" class="form-select" onchange="updateTable()">
                <?php 
                    $sql_grade = db()->query("SELECT * FROM tb_grade");
                    while($fet_grade = $sql_grade->fetch_object()) {
                ?>
                <option value="<?= $fet_grade->grade; ?>" <?= $fet_grade->grade == "ประกาศนียบัตรวิชาชีพ" ? "selected" : ""; ?>><?= $fet_grade->grade; ?></option>
                <?php } ?> 
            </select>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-6">
            <!-- ตั้งให้กราฟไม่แสดงในตอนแรก -->
            <canvas id="studentChart" style="display: none; width: 100%; height: 300px;"></canvas> <!-- ใช้ 100% ความกว้างและตั้งค่าความสูง -->
        </div>

        <div class="col-lg-6">
            <!-- แสดงข้อมูลในรูปแบบ Card แทนตาราง -->
            <div id="studentCards" class="row">
                <!-- ข้อมูลจะถูกแสดงในนี้โดย JavaScript -->
            </div>
        </div>
    </div>
</div>
<footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span style="font-size:16px;">พัฒนาโดย นายกัณติกรณ์ สรสุริยวงษ์ เเละ นางสาวกนกวรรณศรีประไชย แผนกวิชาเทคโนโลยีสารสนเทศ &copy; Your Website 2025</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.datatables.net/2.2.1/js/dataTables.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/th.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
     $(document).on("click","#btn-logout",() => {
                Swal.fire({
                text: "คุณต้องการจะออกจากระบบใช่ไหม?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "ใช่",
                cancelButtonText: "ไม่ใช่"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.replace("../api/ac_logout.php");
                    }
                });
            })

            $(document).ready(function() {
    const ctx = document.getElementById('studentChart').getContext('2d');

    let studentChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: [],
            datasets: [{
                label: 'จำนวนนักศึกษา',
                data: [],
                backgroundColor: [
                    'rgba(150, 220, 204, 0.97)',
                    'rgba(170, 230, 204, 0.97)',
                    'rgba(190, 240, 204, 0.97)'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw + ' คน';
                        }
                    }
                }
            }
        }
    });

    function updateChart() {
        const selectedDepartment = $('#classSelect').val();
        const selectedGrade = $('#classLevelSelect').val();

        $.ajax({
            url: '../api/ac_getData.php?ac=getData',
            method: 'GET',
            data: {
                department: selectedDepartment,
                grade: selectedGrade
            },
            dataType: 'json',
            success: function(response) {
                // อัปเดตกราฟ
                studentChart.data.labels = response.labels;
                studentChart.data.datasets[0].data = response.data;
                studentChart.update();

                // แสดงกราฟ
                $('#studentChart').css('display', 'block');

                // อัปเดต Card
                updateTable(response.labels, response.data);
            },
            error: function(xhr, status, error) {
                console.error("Error fetching data:", error);
            }
        });
    }

    function updateTable(labels, data) {
        const selectedDepartment = $('#classSelect').val();
        const selectedGrade = $('#classLevelSelect').val();

        const studentCardsContainer = $('#studentCards');
        studentCardsContainer.empty(); // ล้างข้อมูล Card ก่อน

        // สร้าง Card ด้านบนที่แสดงข้อมูลรวม
        const topCard = `
            <div class="col-md-12 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title">${selectedGrade}</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">แผนก: ${selectedDepartment}</p>
                        <p class="card-text">จำนวนรวมทั้งหมด: ${data.reduce((acc, val) => parseInt(acc) + parseInt(val))} คน</p>
                    </div>
                </div>
            </div>
        `;
        studentCardsContainer.append(topCard);

        // วนลูปเพื่อเพิ่มข้อมูลใน Card สำหรับแต่ละห้อง
        labels.forEach((label, index) => {
            const card = `
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-info text-white">
                            <i class="bi bi-person-circle" style="font-size: 2em;"></i>
                            <h5 class="card-title">${label}</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">${data[index]} คน</p>
                        </div>
                    </div>
                </div>
            `;

            studentCardsContainer.append(card);
        });
    }

    // เมื่อผู้ใช้เลือกแผนกหรือระดับชั้น
    $('#classSelect, #classLevelSelect').on('change', updateChart);

    // โหลดข้อมูลเริ่มต้นเมื่อหน้าเว็บโหลดเสร็จ
    updateChart();
});
</script>

            <!-- End of Main Content -->

            <!-- Footer -->
       
</body>

</html>