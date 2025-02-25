<?php 
    session_start();
    if(!$_SESSION['user_id']) {
        header("Location: login.php");
    }

    include 'api/function.php';
    // error_reporting(E_ALL, 1);

    $sql_pre = db()->query("SELECT * FROM tb_preorder WHERE pre_status = 1");
    $fet_pre = $sql_pre->fetch_object();
    $sql_profile = db()->query("SELECT * FROM tb_user WHERE user_id='".$_SESSION['user_id']."'");
    $fet_profile = $sql_profile->fetch_object();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shop Homepage - Start Bootstrap Template</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
         <!--font-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500&display=swap" rel="stylesheet">
            <!--font-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Mitr&family=Oswald:wght@500&display=swap" rel="stylesheet">
 

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
            <img class="rounded" src="img/product/<?= $fet_cart->pro_img; ?>" alt="Title" width="80" height="80" />

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
            </div>
            <div class="text-center py-2 mt-2">
                <p>฿ <?= $sum_price = $fet_cart->pro_price*$fet_cart->ca_qty; ?></p>
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
      <div class="text-center py-4">
          <h5>รวมทั้งหมด <?= $sum_total; ?> บาท</h5>
          <a href="index.php?p=order&sum_total=<?= $sum_total; ?>" class="btn btn-primary">สั่งซื้อสินค้า</a>
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
        <script src="js/scripts.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/dayjs"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
             $(document).on("submit","#frm_editOrder",function() {
            $.ajax({
                url: $(this).attr("action"),
                type: "POST",
                data: new FormData(this), // ดึงข้อมูลจากฟอร์ม
                dataType: "json",
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.status === true) {
                        alertMsg(response.msg, response.type);
                        setTimeout(() => {
                            window.location.replace("index.php?p=history");
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
                    
                },
            });
            return false;
        })
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
                        window.location.href = 'login.php';
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


                                // ฟังก์ชันคำนวณราคารวม
                function calculateTotal() {
                    let total = 0;

                    // คำนวณราคารวมจากตารางโควต้า
                    // $('table:first tbody tr').each(function() {
                    //     const price = parseFloat($(this).find('td:eq(3)').text().replace('฿', '').trim());
                    //     const qty = parseFloat($(this).find('input[name^="editcq_qty"]').val());
                    //     if (!isNaN(price) && !isNaN(qty)) {
                    //         total += price * qty;
                    //     }
                    // });

                    // คำนวณราคารวมจากตารางทั่วไป
                    $('table:last tbody tr').each(function() {
                        const price = parseFloat($(this).find('td:eq(3)').text().replace('฿', '').trim());
                        const qty = parseFloat($(this).find('input[name^="editca_qty"]').val());
                        if (!isNaN(price) && !isNaN(qty)) {
                            total += price * qty;
                        }
                    });

                    // แสดงผลรวมและอัปเดตค่าใน input hidden
                    $('#editTotal').text('ราคารวม: ' + total.toFixed(2) + ' ฿');
                    $('#edit_Total').val(total.toFixed(2));
                }

                // เรียกใช้ฟังก์ชันคำนวณราคารวมเมื่อโหลดหน้าเว็บ
                calculateTotal();

                // เรียกใช้ฟังก์ชันคำนวณราคารวมเมื่อมีการเปลี่ยนแปลงจำนวนสินค้า
                $('input[name^="editcq_qty"], input[name^="editca_qty"]').on('input', function() {
                    calculateTotal();
                });

            })
            $(document).on("change","#grade",function() {


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
                $(document).on("change","#department",function() {

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
            $(document).on("click","#btn-cart",function() {
                let pro_id = $(this).data("id");
              
                $.ajax({
                    url: 'api/ac_cart.php?ac=add',
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
                        window.location.replace("api/ac_logout.php");
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
                    url: "api/ac_cart.php?ac=del&ca_id="+id,
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
                        url: 'api/ac_cart.php?ac=addQty', // URL ที่จะส่งค่าไป
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
                        url: 'api/ac_cart.php?ac=addSize', // URL ที่จะส่งค่าไป
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
            $(document).on('change', 'input[name^="ca_size"]', function () {
    // ใช้ map เพื่อรวบรวมข้อมูลทั้งหมด
                    let dataToSend = $('input[name^="ca_size"]').map(function () {
                        let ca_id = $(this).attr('name').match(/\d+/)[0]; // ดึง ca_id จาก name
                        let quantity = $(this).val(); // ดึงค่าจำนวน
                        return {
                            ca_id: ca_id,
                            ca_size: quantity
                        };
                    }).get(); // แปลง jQuery object เป็น array

                    // ส่งค่าไปยัง Server
                    $.ajax({
                        url: 'api/ac_cart.php?ac=addSize', // URL ที่จะส่งค่าไป
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
                        url: 'api/ac_order.php?ac=add',
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
            $(document).on("click","#btn-request",function() {
                $.ajax({
                    url: "api/ac_order.php?ac=request_update",
                    type: "get",
                    data: {order_id: $(this).data("id")},
                    dataType: "json",
                    success:function(data){
                        if(data.status) {
                            alertMsg(data.msg, data.type);
                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);
                        }else{
                            console.log(data);
                            
                        }
                    },error:function(err){
                        console.log(err);
                        
                    }
                })
            })
        </script>
    </body>
</html>
