<?php 
    session_start();
    include 'api/function.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
     <!--font-->
     <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500&display=swap" rel="stylesheet">
    <!--font-->
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Mitr&family=Oswald:wght@500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
   <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        .registration-container {
            display: flex;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            flex-wrap: wrap;
        }
        .illustration {
            padding: 30px;
            background-color: #eef4ff;
            text-align: center;
            flex: 1 1 300px;
            
        }
        .illustration img {
            max-width: 100%;
            height: auto;
        }
        .form-container {
            padding: 30px;
            flex: 2 1 400px;
        }
        .error {
            color: red;
            font-size: 0.875em;
            margin-top: 0.25em;
        }
        @media (max-width: 768px) {
            body {
                padding: 20px;
            }
            .registration-container {
                flex-direction: column;
            }
            .illustration, .form-container {
                flex: 1 1 auto;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
<div class="registration-container container">
    <div class="illustration">
        <img src="img/logo/Logo_SBTC.jpg" class="rounded-circle" alt="Illustration">
        <h2 style="font-family: 'Mitr', sans-serif;">สมัครสมาชิก</h2>
        <p style="font-family: 'Mitr', sans-serif;">ระบบสั่งจองเครื่องแบบ</p>
    </div>
    <div class="form-container">
        <form id="registrationForm" action="api/ac_register.php" method="post">
            

            <div class=" mb-3">
            <div class="form-floating">
                <input type="fullname" class="form-control" id="fullname" name="fullname" placeholder="fullname">
                <label for="fullname" style="font-family: 'Mitr', sans-serif;"><i class="bi bi-person"></i> ชื่อ-นามสกุล</label>
            </div>
            <span id="fullname-error" class="error" for="fullname"></span>
            </div>
            <div class="mb-3">
                <div class="form-floating">
                    <input type="tel" class="form-control" id="tel" name="tel" placeholder="Phone Number">
                    <label for="tel" style="font-family: 'Mitr', sans-serif;"><i class="bi bi-telephone"></i> เบอร์โทรศัพท์</label>
                </div>
                <span id="tel-error" class="error" for="tel"></span>
            </div>
            <div class="mb-3">
                <div class="form-floating">
                    <input type="number" class="form-control" id="citizen_id" name="citizen_id" placeholder="Phone Number">
                    <label for="citizen_id" style="font-family: 'Mitr', sans-serif;"><i class="bi bi-person-vcard"></i> เลขบัตรประจำตัวประชาชน</label>
                </div>
                <span id="citizen_id-error" class="error" for="citizen_id"></span>
            </div>
            <div class="form-floating">
                        <select class="form-select" id="grade" name="grade" style="font-family: 'Mitr', sans-serif;">
                            <option style="font-family: 'Mitr', sans-serif;" value="" selected hidden disabled>เลือกระดับชั้น</option>
                            <?php 
                                $sql = db()->query("SELECT * FROM tb_grade");
                                if($sql->num_rows <= 0) {
                                    echo "<option value=''>ไม่พบข้อมูล</option>";

                                }else{
                                while($fet = $sql->fetch_object()) {
                            ?>
                            <option value="<?= $fet->g_id; ?>" data-quota="<?= $fet->quota; ?>"><?= $fet->grade; ?></option>
                            <?php } ?>
                            <?php } ?>
                        </select>
                        <label for="grade"style="font-family: 'Mitr', sans-serif;"><i class="bi bi-briefcase"></i> ระดับชั้น</label>
                        <span id="grade-error" class="error" for="grade" style="font-family: 'Mitr', sans-serif;"></span>
                    </div>
            <div class="row my-3">
                <div class="col">
                <div class="form-floating">
                        <select class="form-select" id="department" name="department" style="font-family: 'Mitr', sans-serif;">
                            <option value="" selected hidden disabled style="font-family: 'Mitr', sans-serif;">เลือกแผนกวิชา</option>
                            
                            
                        </select>
                        <label for="department" style="font-family: 'Mitr', sans-serif;"><i class="bi bi-building"></i> แผนกวิชา</label>
                    </div>
                    <span id="department-error" class="error" for="department style="font-family: 'Mitr', sans-serif;"></span>
                </div>
                <div class="col">
                    <div class="form-floating">
                        <select class="form-select" id="room" name="room" style="font-family: 'Mitr', sans-serif;">
                            <option value="" selected hidden disabled style="font-family: 'Mitr', sans-serif;">เลือกห้องเรียน</option>
                            
                        </select>
                        <label for="job"><i class="bi bi-mortarboard" style="font-family: 'Mitr', sans-serif;"></i> ห้องเรียน</label>
                        <span id="room-error" class="error" for="room" style="font-family: 'Mitr', sans-serif;"></span>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100" style="font-family: 'Mitr', sans-serif;">สมัครสมาชิก</button>

           

            <p class="text-center mt-3" style="font-family: 'Mitr', sans-serif;">มีบัญชีอยู่แล้วใช่ไหม? <a style="font-family: 'Mitr', sans-serif;" href="login.php">เข้าสู่ระบบ</a></p>
        </form>
    </div>
</div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/scripts.js"></script>
<script>
 
    $(document).ready(function () {
        $("#grade").change(()=>{

            $.ajax({
                url: "api/ac_search.php?ac=department&g_id="+$("#grade").val(),
                method: "get",
                success:function(data){
                    $("#department").html(data);
                },error: function(err) {
                    console.log(err);
                    
                }
            })
        })
        $("#department").change(()=>{

            $.ajax({
                url: "api/ac_search.php?ac=room&dep_id="+$("#department").val(),
                method: "get",
                success:function(data){
                    $("#room").html(data);
                },error: function(err) {
                    console.log(err);
                    
                }
            })
        })
        $("#registrationForm").validate({
    rules: {
        fullname: "required",
        tel: {
            required: true,
            digits: true
        },
        department: "required",
        grade: "required",
        room: "required",
        citizen_id: "required"
    },
    messages: {
        fullname: "กรุณากรอกชื่อ-นามสกุลของคุณ",
        citizen_id: "กรุณากรอกเลขบัตรประจำตัวประชาชนของคุณ",
        tel: "กรุณากรอกเบอร์โทรศัพท์ของคุณ",
        grade: "กรุณาเลือกระดับชั้น",
        department: "กรุณาเลือกแผนกวิชาของคุณ",
        room: "กรุณาเลือกห้องเรียนของคุณ"
    },
    errorPlacement: function (error, element) {
        error.insertAfter(element.closest('.form-floating')); // แสดงข้อความ error ใต้ input
    },
    submitHandler: function (form) {
        // เมื่อฟอร์ม valid และ ready ส่งผ่าน AJAX
        let quota = $("#grade option:selected").data("quota");
        let url = $(form).attr("action");
        let method = $(form).attr("method");
        let data = new FormData(form);
        data.append("quota", quota);

        $.ajax({
            url: url,
            data: data,
            method: method,
            dataType: "json",
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status) {
                    window.location.replace("login.php");
                } else {
                    alertMsg(response.msg, response.type);
                    setTimeout(() => {
                        window.location.reload(true);
                    }, 2000);
                }
            },
            error: function (err) {
                console.log(err);
            }
        });

        return false; // ป้องกันการ submit แบบปกติ
    }
});

    });
   
    
</script>

</body>
</html>