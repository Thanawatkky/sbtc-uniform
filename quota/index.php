<?php 
    session_start();
    if(!$_SESSION['user_id']) {
        header("Location: ../login.php");
    }
    include '../api/function.php';
    $sql_pre = db()->query("SELECT * FROM tb_preorder WHERE pre_status = 1");
    $fet_pre = $sql_pre->fetch_object();
    $sql_profile = db()->query("SELECT * FROM tb_user WHERE user_id='".$_SESSION['user_id']."'");
    $fet_profile = $sql_profile->fetch_object();
    $sql_checkquotaed = db()->query("SELECT tb_order.cus_name, tb_user.user_id FROM tb_order LEFT JOIN tb_user ON tb_order.cus_name = tb_user.user_id WHERE tb_user.quota = 1 AND tb_order.cus_name = '".$_SESSION['user_id']."' ");
    if($sql_checkquotaed->num_rows > 0) {
        header("Location: ../index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shop Homepage - Start Bootstrap Template</title>
         <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500&display=swap" rel="stylesheet">
    <!--font-->
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Mitr&family=Oswald:wght@500&display=swap" rel="stylesheet">
  
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="../css/styles.css" rel="stylesheet" />
    <style>
                body {
           
            font-family: 'Mitr', sans-serif;
        }
    </style>
    </head>
    <body>
        <?php 
            include 'nav.php';
        ?>
        <!-- Header-->
   
        <!-- Section-->
            <?php 
                if(isset($_REQUEST['p'])) {
                    include $_REQUEST['p'].".php";
                }else{
                    include 'dashboard.php';
                }
            ?>

<div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">ตะกร้าของฉัน</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body ">
    <?php 
        $sql_cart = db()->query("SELECT tb_cart.*,tb_product.* FROM tb_cart LEFT JOIN tb_product ON tb_cart.ca_product = tb_product.pro_id WHERE tb_cart.ca_user = '".$_SESSION['user_id']."' AND tb_cart.order_id = 0 ");
        $sum_total = 0;
        while($fet_cart = $sql_cart->fetch_object()) {
    ?>
    <div class="d-flex justify-content-between align-items-center border p-4 mt-3">
        <div >
            <img class="rounded" src="../img/product/<?= $fet_cart->pro_img; ?>" alt="Title" width="80" height="80" />

        </div>
        <div >
           <div class="card-body">
               <p class="card-title"><?= $fet_cart->pro_name; ?></p>
               <div class="d-flex align-items-center mt-2">
                    <div>
                        <input class="form-control text-center me-3 mt-2" id="ca_qty" name="ca_qty[<?= $fet_cart->ca_id; ?>]" type="num" value="<?= $fet_cart->ca_qty; ?>" min="1" pattern="{0-9}" style="max-width: 3rem" />
                    </div>

                    <div>
                        <?php 
                            if($fet_cart->pro_type == 1) {

                            
                        ?>
                    <select name="ca_size[<?= $fet_cart->ca_id; ?>]" id="ca_size" class="form-select-sm mt-2">
                        <option value="" selected hidden disabled>SIZE</option>
                        <?php 
                            $sizes = [
                                "S",
                                "M",
                                "L",
                                "XL",
                                "2XL",
                                "3XL",
                                "4XL",
                                "5XL"
                            ];
                            foreach ($sizes as $size) {
                               
                        ?>
                        <option value="<?= $size; ?>" <?= $fet_cart->ca_size == $size ? "selected" : "" ?>><?= $size; ?></option>
                            <?php 
                            }
                            ?>
                    </select>
                    <?php }else if($fet_cart->pro_type == 2) { ?>
                        <input type="text" name="ca_size[<?= $fet_cart->ca_id; ?>]" id="ca_size" class="form-control mt-2" value="<?= $fet_cart->ca_size; ?>" placeholder="โปรดกรอก ขนาดเอว/ขนาดเท้า ของคุณ">
                        <?php } ?>
                    </div>
               </div>
            </div>
            <div class="text-center py-2 mt-2">
                <p>฿ <?= $sum_price = $fet_cart->pro_price*$fet_cart->ca_qty; ?></p>
            </div>
        </div>
        <div>
            <a class="text-danger text-md" href="#" id="btn-delCart" data-id="<?= $fet_cart->ca_id; ?>"><i class="bi bi-trash"></i></a>
        </div>

       
    </div>
    <?php
    $sum_total += $sum_price;
    $sum_price = 0;
 } 
 ?>
  </div>
  <div class="text-center py-4">
      <h5>รวมทั้งหมด <?= $sum_total; ?> บาท</h5>
      <a href="index.php?p=order&sum_total=<?= $sum_total; ?>" class="btn btn-primary">สั่งซื้อสินค้า</a>
  </div>
</div>
</div>

<div
    class="modal fade"
    id="modalviewSize"
    tabindex="-1"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    
    role="dialog"
    aria-labelledby="modalTitleId"
    aria-hidden="true"
>   
    <div
        class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">
                    ข้อมูลไซส์เครื่องแบบ
                </h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                <div class="text-start">
                    <h5 id="nameproduct"></h5>
                </div>
                    
                        <img  alt="sizeimg" class="img-thumbnail d-block mx-auto" id="imgproduct" width="450" height="450">
        
                </div>
                
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>
        <!-- Footer-->
        <footer class="py-5 bg-light border-top">
            <div class="container"><p class="m-0 text-center text-dark">Copyright &copy; Your Website 2023</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="../js/scripts.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/dayjs"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            $(function() {
                var start = dayjs('<?= $fet_pre->start_at; ?>');
                var end = dayjs('<?= $fet_pre->end_at; ?>');
                var now = dayjs();
                if(now.isBefore(start) || now.isAfter(end)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'ขออภัย',
                        text: 'ขณะนี้ไม่ได้อยู่ในช่วงเปิดให้บริการ'
                    }).then((result) => {
                        window.location.href = '../login.php';
                    })
                }
                $('#ca_qty').on('input', function () {
                    $(this).val($(this).val().replace(/[^0-9]/g, ''));
                });

                if (localStorage.getItem('showOffcanvas') === 'true') {
                    $("#offcanvasWithBothOptions").addClass("show");

                    // ลบค่าออกจาก localStorage เพื่อไม่ให้แสดง offcanvas ซ้ำทุกครั้งที่โหลดหน้า
                    localStorage.removeItem('showOffcanvas');
                }
                
                
                if (!localStorage.getItem("ajaxSent")) {
                    Swal.fire({
                    title: 'เลือกเพศของคุณ',
                    html: `
                        <div style="text-align: left;">
                        <label>
                            <input type="radio" name="choice" value="1"> เพศชาย
                        </label><br>
                        <label>
                            <input type="radio" name="choice" value="2"> เพศหญิง
                        </label>
                        </div>
                    `,
                    allowOutsideClick: false, // ❌ ไม่ให้คลิกข้างนอกแล้วปิด
                    showCancelButton: true,
                    confirmButtonText: 'ตกลง',
                    preConfirm: () => {
                        const selectedOption = document.querySelector('input[name="choice"]:checked');
                        if (!selectedOption) {
                        Swal.showValidationMessage('กรุณาเลือกเพศของคุณ!');
                        return false;
                        }
                        return selectedOption.value;
                    }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "../api/ac_quota_uniform.php?ac=addToCart&sex="+result.value,
                                method: "POST",
                                
                                success: function (response) {
                                    console.log(response);
                                    
                                    localStorage.setItem("ajaxSent", "true"); // บันทึกค่าเพื่อไม่ให้ส่งซ้ำ
                                    window.location.reload(true);
                                },
                                error: function (xhr, status, error) {
                                    console.error("Error sending data", error);
                                }
                            });
                        }
                    });
                }
            })

            $(document).on("click","#sex",function() {
                $.ajax({
                    url: "../api/ac_quota_uniform.php?ac=changeSex&sex="+$(this).val(),
                    method: "POST",
                    success: function(data) {
                        window.location.reload(true);
                    },error: function(err) {
                        console.log(err);
                        
                    }
                })
            });


            $(document).on("click","#btn-viewSize",function() {
                let img = $(this).data("img");
                let name = $(this).data("name");
                $("#imgproduct").attr("src","../img/size/"+img);
                $("#nameproduct").text(name);
            });
            $(document).on("change","#grade",function() {


                $.ajax({
                    url: "../api/ac_search.php?ac=department&g_id="+$("#grade").val(),
                    method: "get",
                    success:function(data){
                        $("#department").html(data);
                    },error: function(err) {
                        console.log(err);
                        
                    }
                })
            })
            $(document).on("change","#department",function() {

                    $.ajax({
                    url: "../api/ac_search.php?ac=room&dep_id="+$("#department").val(),
                    method: "get",
                    success:function(data){
                        $("#room").html(data);
                    },error: function(err) {
                        console.log(err);
                        
                    }
                })
            })
            $(document).on("click","#btn-cart",function() {
                let pro_id = $(this).data("id");
              
                $.ajax({
                    url: '../api/ac_cart.php?ac=add',
                    type: 'post',
                    dataType: 'json',
                    data: {pro_id:pro_id},
                    success: function(data) {
                        if(data.status) {
                         alertMsg(data.msg, data.type);
                         setTimeout(() => {
                            window.location.reload(true);
                         },2000)
                        }else{
                            alertMsg(data.msg, data.type);
                         setTimeout(() => {
                            window.location.reload(true);
                         },2000)
                        }
                    },error:function(err) {
                        console.log(err);
                        
                    }
                })
            })
            $(document).on("submit","#frm_profile",function(){
                let url = $(this).attr("action");
                let method = $(this).attr("method");
                let data = new FormData(this);
                $.ajax({
                    url: url,
                    data: data,
                    method: method,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.status) {
                            alertMsg(response.msg, response.type);
                            setTimeout(() => {
                                window.location.reload(true);
                            }, 2000);
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
            })
            $(document).on("click","#btn-logout",function(){
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
         
            $(document).on("click","#btn-delCart", function() {
                Swal.fire({
                text: "คุณต้องการนำรายการสินค้านี้ออกจากตะกร้าใช้ไหม?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "ใช่",
                cancelButtonText: "ไม่ใช่"
                }).then((result) => {
                    if (result.isConfirmed) {
                        let id = $(this).data("id");
                $.ajax({
                    url: "../api/ac_cart.php?ac=del&ca_id="+id,
                    method: "delete",
                    success: function(data) {
                        window.location.reload(true);
                    },error: function(err) {
                        console.log(err);
                        
                    }
                })
                    }
                });
            })
            $(document).on("change", "input[name^='uq_size'], select[name^='uq_size']", function () {
            let dataToSend = $("input[name^='uq_size'], select[name^='uq_size']").map(function () {
                let pro_id = $(this).attr("name").match(/\d+/)?.[0] || ''; // ดึงหมายเลขสินค้า
                let uq_size = $(this).val();
                let qty = $(`input[name='cq_qty[${pro_id}]']`).val() || 0; // ป้องกัน undefined

                return {
                    uq_product: pro_id,
                    uq_size: uq_size,
                    uq_qty: qty
                };
            }).get();

            $.ajax({
                url: '../api/ac_quota_uniform.php?ac=addSize',
                method: 'POST',
                data: { data: dataToSend },
                success: function (response) {
                    console.log(response);
                    
                },
                error: function (error) {
                    console.error('Error:', error);
                }
            });
        });


            $(document).on('change', 'input[name^="ca_qty"]', function () {
    // ใช้ map เพื่อรวบรวมข้อมูลทั้งหมด
                    let dataToSend = $('input[name^="ca_qty"]').map(function () {
                        let ca_id = $(this).attr('name').match(/\d+/)[0]; // ดึง ca_id จาก name
                        let quantity = $(this).val(); // ดึงค่าจำนวน
                        return {
                            ca_id: ca_id,
                            ca_qty: quantity
                        };
                    }).get(); // แปลง jQuery object เป็น array

                    // ส่งค่าไปยัง Server
                    $.ajax({
                        url: '../api/ac_cart.php?ac=addQty', // URL ที่จะส่งค่าไป
                        method: 'POST',
                        data: { data: dataToSend }, // ส่งข้อมูลทั้งชุด
                        success: function (response) {
                            localStorage.setItem('showOffcanvas', 'true');

                            // รีโหลดหน้า
                            window.location.reload();
                        },
                        error: function (error) {
                            console.error('Error:', error); // แสดง error ใน console
                        }
                    });
                });
            $(document).on('change', 'select[name^="ca_size"]', function () {
    // ใช้ map เพื่อรวบรวมข้อมูลทั้งหมด
                    let dataToSend = $('select[name^="ca_size"]').map(function () {
                        let ca_id = $(this).attr('name').match(/\d+/)[0]; // ดึง ca_id จาก name
                        let quantity = $(this).val(); // ดึงค่าจำนวน
                        return {
                            ca_id: ca_id,
                            ca_size: quantity
                        };
                    }).get(); // แปลง jQuery object เป็น array

                    // ส่งค่าไปยัง Server
                    $.ajax({
                        url: '../api/ac_cart.php?ac=addSize', // URL ที่จะส่งค่าไป
                        method: 'POST',
                        data: { data: dataToSend }, // ส่งข้อมูลทั้งชุด
                        success: function (response) {
                            localStorage.setItem('showOffcanvas', 'true');

                            // รีโหลดหน้า
                            window.location.reload();
                        },
                        error: function (error) {
                            console.error('Error:', error); // แสดง error ใน console
                        }
                    });
                });

                $(document).on("click","#btn-confirm",function() {
                    let total = $(this).data("total");
                    $.ajax({
                        url: '../api/ac_order.php?ac=addFromQuota',
                        type: 'post',
                        dataType: 'json',
                        data: {sum_total:total},
                        success: function(data) {
                            if(data.status) {
                                alertMsg(data.msg, data.type);
                                setTimeout(() => {
                                    window.location.href = 'index.php?p=history';
                                },2000)
                            }else{
                                alertMsg(data.msg, data.type);
                                setTimeout(() => {
                                    window.location.reload(true);
                                },2000)
                            }
                        },error:function(err) {
                            console.log(err);
                            
                        }
                    })
                })
        </script>
    </body>
</html>
