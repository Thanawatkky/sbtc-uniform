<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login Panel</title>
    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500&display=swap" rel="stylesheet">
    <!--font-->
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Mitr&family=Oswald:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
          
    <style>
        /* Importing fonts from Google */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

        /* Reseting */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(to right, #dcecf7, #f4f9fc);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .wrapper {
            max-width: 350px;
            min-height: 500px;
            padding: 40px 30px 30px 30px;
            background: #eaf2f8;
            border-radius: 15px;
            box-shadow: 10px 10px 20px #b0c4de, -10px -10px 20px #ffffff;
            text-align: center;
        }

        .logo {
            width: 120px;
            margin: auto;
        }

        .logo img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            box-shadow: 0px 0px 3px #5f5f5f,
                        0px 0px 0px 5px #eaf2f8,
                        8px 8px 15px #b0c4de,
                        -8px -8px 15px #ffffff;
        }

        .wrapper .name {
            font-weight: 600;
            font-size: 1.4rem;
            letter-spacing: 1.3px;
            color: #2c3e50;
            margin-top: 10px;
        }

        .wrapper .form-field input {
            width: 100%;
            height: 30px; /* กำหนดความสูงของ input */
            border: none;
            outline: none;
            background: none;
            font-size: 1rem;
            color: #666;
            padding: 10px;
            border-radius: 20px;
        }

        .wrapper .form-field {
            padding: 10px;
            margin: 20px 0;
            border-radius: 20px;
            box-shadow: inset 8px 8px 8px #b0c4de, inset -8px -8px 8px #ffffff;
        }

        .wrapper .btn {
            width: 100%;
            height: 45px;
            background-color: #5DADE2;
            color: #fff;
            border: none;
            border-radius: 25px;
            font-size: 1rem;
            cursor: pointer;
            box-shadow: 3px 3px 3px #b0c4de, -3px -3px 3px #ffffff;
            transition: all 0.3s;
        }

        .wrapper .btn:hover {
            background-color: #2980b9;
            transform: scale(1.05);
        }

        .wrapper a {
            text-decoration: none;
            font-size: 0.8rem;
            color: #2c3e50;
        }

        .wrapper a:hover {
            color: #1f2c38;
        }

        @media(max-width: 380px) {
            .wrapper {
                margin: 30px 20px;
                padding: 40px 15px 15px 15px;
            }
        }
    </style>
</head>
<body>
<div class="wrapper">
        <div class="logo">
            <img src="../img/logo/Logo_SBTC.jpg" alt="Logo">
        </div>
        <div class="name">
            <h6 style="font-family: 'Mitr', sans-serif;">ล็อกอินเข้าสู่ระบบ <br class="mt-2">ผู้ดูเเลระบบ สั่งจองเครื่องเเบบ</h6>
        </div>
        <form id="frm_login" action="../api/ac_login.php?ac=admin" method="post">
            <div class="form-field">
                <input style="font-family: 'Mitr', sans-serif;" type="text" placeholder="Username..." name="username" required>
            </div>
            <div class="form-field">
                <input style="font-family: 'Mitr', sans-serif;" type="password" placeholder="Password..." name="password" required>
            </div>
            <button style="font-family: 'Mitr', sans-serif;" class="btn" type="submit">เข้าสู่ระบบ</button>
        </form>
    </div>

</body>
</html>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="js/main.js"></script>
<script>
    $(document).on("submit","#frm_login",function() {
        $.ajax({
            url: $(this).attr("action"),
            method: $(this).attr("method"),
            data: new FormData(this),
            dataType: "JSON",
            contentType: false,
            processData: false,
            success: function(data) {
                if(data.status) {
                    if(data.role === 1) {
                        window.location.href = "index.php";
                    }else if(data.role === 3) {
                        window.location.href = "../department/index.php";
                    }else{
                        alertMsg("Unauthorized", "error");
                    }
                } else {
                    alertMsg(data.msg, data.type);
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                }
            },error: function(err) {
                console.log(err);
            }
        })
        return false;
    })
</script>
</body>
</html>
