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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500&display=swap" rel="stylesheet">
    <!--font-->
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Mitr&family=Oswald:wght@500&display=swap" rel="stylesheet">
  

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

    .custom-font {
        font-family: 'Prompt', sans-serif; /* ใช้ฟอนต์ไทยสวย ๆ */
        font-weight: 600; /* ปรับความหนาของตัวอักษร */
    
    }

    h2 {
        font-size: 30px; /* ปรับขนาดตัวอักษร */
    }

    p {
        font-size: 20px; /* ปรับขนาดตัวอักษรของคำอธิบาย */
    }


    </style>
</head>
<body>
<div class="registration-container container">
    <div class="illustration">
        <img src="img/logo/Logo_SBTC.jpg" class="rounded-circle" alt="Illustration">
        <h4 class="custom-font" style="font-family: 'Mitr', sans-serif;">ล็อกอินเข้าสู่ระบบ</h4>
    <p class="custom-font" style="font-family: 'Mitr', sans-serif;">สั่งจองเครื่องเเบบ</p>

    </div>
    <div class="form-container my-auto">
        <form id="registrationForm" action="api/ac_login.php?ac=user_login" method="post">
            

            <div class="mb-3">
                <div class="form-floating">
                    <input type="number" class="form-control" id="citizen_id" name="citizen_id" placeholder="Phone Number">
                    <label for="citizen_id"  style="font-family: 'Mitr', sans-serif;"><i class="bi bi-person-vcard" ></i> เลขบัตรประจำตัวประชาชน</label>
                </div>
                <span id="citizen_id-error" class="error" for="citizen_id"></span>
            </div>
           

            <button type="submit" class="btn btn-primary w-100"  style="font-family: 'Mitr', sans-serif;">เข้าสู่ระบบ</button>
            
            
            <div class="text-center">
            <p class="text-center mt-3" style="font-family: 'Mitr', sans-serif;">ยังไม่มีบัญชีใช่ไหม? <a href="register.php">สมัครสมาชิก</a></p>
            <p class="text-muted">-or-</p>
            <a href="admin/login.php" class="text-decoration-none"  style="font-family: 'Mitr', sans-serif;">Admin Login</a>
            </div>
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
       
        $("#registrationForm").validate({
    rules: {
        citizen_id: "required"
    },
    messages: {   
        citizen_id: "กรุณากรอกเลขบัตรประจำตัวประชาชนของคุณ",
    },
    errorPlacement: function (error, element) {
        error.insertAfter(element.closest('.form-floating')); // แสดงข้อความ error ใต้ input
    },
    submitHandler: function (form) {
        // เมื่อฟอร์ม valid และ ready ส่งผ่าน AJAX
        let url = $(form).attr("action");
        let method = $(form).attr("method");
        let data = new FormData(form);

        $.ajax({
            url: url,
            data: data,
            method: method,
            dataType: "json",
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status) {
                    if(response.quota) {
                        window.location.replace("quota/index.php");
                    }else{
                        window.location.replace("index.php");
                    }
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