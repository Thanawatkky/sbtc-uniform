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
                        <?php 
                            if(isset($_REQUEST['p'])) {
                                include $_REQUEST['p'].".php";
                            }else{
                                include 'dashboard.php';
                            }
                        ?>
                </div>
  
          

                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
            <div class="modal fade" id="check_data" tabindex="-1" aria-labelledby="check_dataLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> 
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="check_dataLabel">
                    <i class="fas fa-shopping-cart"></i> ข้อมูลการสั่งจองเครื่องแบบ
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <h6 id="txt-id"></h6>
                    <h6 id="txt-date"></h6>
                    
                </div>
                <table class="table table-bordered" id="table-report">
                    
                    
                    
                </table>
            </div>
            <div class="modal-footer">
        
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> ยกเลิก
                </button>
                <button id="btn-complete" type="button" class="btn btn-success">
                    <i class="fas fa-check-circle"></i> ยืนยันข้อมูลถูกต้อง
                </button>
            </div>
        </div>
    </div>
</div>
            <!-- Footer -->
          <!-- Footer -->
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



    <!-- Bootstrap core JavaScript-->
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

  

</body>
    <script>
        
        let table = new DataTable("#mytable",{
            info: false,
        });
       
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
        $(document).on("submit","#frm_grade",function() {
            
                let url = $(this).attr("action");
                let method = $(this).attr("method");
                let data = new FormData(this);
                $.ajax({
                    url: url,
                    method: method,
                    dataType: "json",
                    data: data,
                    processData: false,
                    contentType: false,
                    success:function(res){
                        if(res.status) {
                            alertMsg(res.msg,res.type);
                            setTimeout(() => {
                                window.location.reload(true);
                            }, 2000);
                        }else{
                            alertMsg(res.msg,res.type);
                            setTimeout(() => {
                                window.location.reload(true);
                            }, 2000);
                        }
                    },error: function(err) {
                        console.log(err);
                        
                    }
                })
                return false;
        })
        $(document).on("click","#editGrade",function() {
            $("#g_id").val($(this).data("id"));
            $("#grade1").val($(this).data("grade"));
            $("#quota1").val($(this).data("quota"));
        });
        $(document).on("click","#btn-viewPd",function() {
            let pro_name = $(this).data("name");
            let pro_price = $(this).data("price");
            let pro_type = $(this).data("type");
            let img = $(this).data("img");
            $("#imgproduct").attr("src","../img/product/"+img);
            $("#txt-proname").text(pro_name);
            $("#txt-protype").text("หมวดหมู่: "+pro_type);
            $("#txt-proprice").text(`ราคา ${pro_price} บาท`);
        });
        $(document).on("click","#btn-viewSize",function() {
            let img = $(this).data("img");
            $("#imgproduct").attr("src","../img/size/"+img);
        });
        $(document).on("click","#btn-editpd",function() {
            $("#pro_id").val($(this).data('id'));
            $("#pro_name1").val($(this).data("name"));
            $("#pro_price1").val($(this).data("price"))
            $("#pro_type1").val($(this).data("type"))
        })
        $(document).on("click","#btn-sizeEdit",function() {
            $("#size_id").val($(this).data('id'));
            $("#size_product").val($(this).data("name"));
            $("#sex").val($(this).data("sex"));
            $("#frm_grade").attr("action","../api/ac_size.php?ac=update&size_id="+$(this).data('id'));
            $("#size_img").removeAttr("required");
        })
        $(document).on("click","#editDep",function() {
            $("#dep_id").val($(this).data("id"));
            $("#g_id1").val($(this).data("grade"));
            $("#room_qty1").val($(this).data("room"));
            $("#department1").val($(this).data("dep"));
        });
        $(document).on("click","#delGrade",function() {
            let id = $(this).data("id");
            Swal.fire({
            text: "คุณต้องการลบข้อมูลดังกล่าวใช่ไหม?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "ใช่",
            cancelButtonText: "ไม่ใช่"
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "../api/ac_grade.php?ac=del&id="+id,
                    dataType: "json",
                    method: "delete",
                    processData: false,
                    contentType: false,
                    success: (data) => {
                        if(data.status) {
                            alertMsg(data.msg, data.type);
                            setTimeout(() => {
                                window.location.reload(true);
                            },2000);
                        }else{
                            console.log(data);
                        }
                    },error: (err) => {
                        console.log(err);
                        
                    }
                })
            }
            });
                        
        });
        $(document).on("click","#delDep",function() {
            let id = $(this).data("id");
            Swal.fire({
            text: "คุณต้องการลบข้อมูลดังกล่าวใช่ไหม?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "ใช่",
            cancelButtonText: "ไม่ใช่"
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "../api/ac_department.php?ac=del&dep_id="+id,
                    dataType: "json",
                    method: "delete",
                    processData: false,
                    contentType: false,
                    success: (data) => {
                        if(data.status) {
                            alertMsg(data.msg, data.type);
                            setTimeout(() => {
                                window.location.reload(true);
                            },2000);
                        }else{
                            console.log(data);
                        }
                    },error: (err) => {
                        console.log(err);
                        
                    }
                })
            }
            });
                        
        });
        $(document).on("click","#btn-delpd",function() {
            let id = $(this).data("id");
            Swal.fire({
            text: "คุณต้องการลบข้อมูลดังกล่าวใช่ไหม?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "ใช่",
            cancelButtonText: "ไม่ใช่"
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "../api/ac_product.php?ac=del&pro_id="+id,
                    dataType: "json",
                    method: "delete",
                    processData: false,
                    contentType: false,
                    success: (data) => {
                        if(data.status) {
                            alertMsg(data.msg, data.type);
                            setTimeout(() => {
                                window.location.reload(true);
                            },2000);
                        }else{
                            console.log(data);
                        }
                    },error: (err) => {
                        console.log(err);
                        
                    }
                })
            }
            });
                        
        });
        $(document).on("click","#btn-delSize",function() {
            let id = $(this).data("id");
            Swal.fire({
            text: "คุณต้องการลบข้อมูลดังกล่าวใช่ไหม?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "ใช่",
            cancelButtonText: "ไม่ใช่"
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "../api/ac_size.php?ac=del&size_id="+id,
                    dataType: "json",
                    method: "delete",
                    processData: false,
                    contentType: false,
                    success: (data) => {
                        if(data.status) {
                            alertMsg(data.msg, data.type);
                            setTimeout(() => {
                                window.location.reload(true);
                            },2000);
                        }else{
                            console.log(data);
                        }
                    },error: (err) => {
                        console.log(err);
                        
                    }
                })
            }
            });
                        
        });


        $(document).ready(function () {
        
    // Enable or disable quantity input based on checkbox state
    $('#listA').on('change', '.item-checkbox', function () {
      const quantityInput = $(this).closest('li').find('.quantity-input');
      if ($(this).is(':checked')) {
        quantityInput.prop('disabled', false).focus();
      } else {
        quantityInput.prop('disabled', true).val('');
      }

      toggleAddButton();
    });

    // Enable Add button only if at least one item is selected and has quantity
    $('#listA').on('input', '.quantity-input', function () {
      toggleAddButton();
    });

    // Handle Add button click
    $('#addBtn').on('click', function () {
      $('#listA .item-checkbox:checked').each(function () {
        const listItem = $(this).closest('li');
        const itemName = $(this).val();
        const sex = $("#sex option:selected").val();
        const quantity = listItem.find('.quantity-input').val();

        if (quantity > 0) {
          // Add item to List B

        $.ajax({
            url: "../api/ac_quota_uniform.php?ac=add&pro_id="+itemName+"&qty="+quantity+'&sex='+sex,
            method: "post",
            dataType: "json",
            success: (data) => {
                if(data.status) {
                    window.location.reload(true);
                }else{
                    console.log(data);
                }
            },error: (err) => {
                console.log(err);
                
            }
        })

          // Remove the item from List A
          listItem.remove();
        }
      });

      toggleAddButton();
      
    });

    // Handle Remove button click in List B
    $('#listB1').on('click', '.remove-btn', function () {
      const listItem = $(this).closest('li');
        const itemName = $(this).data("id");
        $.ajax({
            url: "../api/ac_quota_uniform.php?ac=del&u_id="+itemName+'&sex=1',
            method: "post",
            dataType: "json",
            success: (data) => {
                if(data.status) {
                    window.location.reload(true);
                }else{
                    console.log(data);
                }
            },error: (err) => {
                console.log(err);
                
            }
        })
      // Remove the item from List B
      listItem.remove();
        
   
    });
    $('#listB2').on('click', '.remove-btn', function () {
        const listItem = $(this).closest('li');
        const itemName = $(this).data("id");
        $.ajax({
            url: "../api/ac_quota_uniform.php?ac=del&u_id="+itemName+'&sex=2',
            method: "post",
            dataType: "json",
            success: (data) => {
                if(data.status) {
                    window.location.reload(true);
                }else{
                    console.log(data);
                }
            },error: (err) => {
                console.log(err);
                
            }
        })
      // Remove the item from List B
      listItem.remove();
   
    });

    function toggleAddButton() {
      const hasValidSelection = $('#listA .item-checkbox:checked').filter(function () {
        return $(this).closest('li').find('.quantity-input').val() > 0;
      }).length > 0;

      $('#addBtn').prop('disabled', !hasValidSelection);
    }
    
});
$(document).on("click","#btn-preEdit",function() { 
    $("#frm_grade").attr("action","../api/ac_preorder.php?ac=update&pre_id="+$(this).data("id"));
    $("#pre_year").val($(this).data("year"));
    $("#start_at").val($(this).data("start"));
    $("#end_at").val($(this).data("end"));
})

$(document).on("click","#btn-endPre",function() {
            let id = $(this).data("id");
            Swal.fire({
            text: "ยืนยันการสิ้นสุดรอบการสั่งจอง?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "ใช่",
            cancelButtonText: "ไม่ใช่"
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "../api/ac_preorder.php?ac=end&pre_id="+id,
                    dataType: "json",
                    method: "delete",
                    processData: false,
                    contentType: false,
                    success: (data) => {
                        if(data.status) {
                            alertMsg(data.msg, data.type);
                            setTimeout(() => {
                                window.location.reload(true);
                            },2000);
                        }else{
                            console.log(data);
                        }
                    },error: (err) => {
                        console.log(err);
                        
                    }
                })
            }
            });
                        
        });
        $(document).on('click','#btn-recheck',function() {
                    let id = $(this).data("id");
                    let date = $(this).data("date");
                   
                    $.ajax({
                        url: '../api/ac_search.php?ac=order&order_id='+id,
                        method: 'get',
                        success: function(data) {
                            $("#txt-id").text("รหัสการสั่งซื้อ : "+id);
                            $("#txt-date").text("วันที่สั่งซื้อ : "+date);
                            $("#table-report").html(data);
                            
                            $("#btn-complete").attr("data-id",id);
                            

                            
                        },error:function(err) {
                            console.log(err);
                            
                        }
                    })
                })
                $(document).on('click','#btn-complete',function() {
                    let id = $(this).data("id");
                    $.ajax({
                        url: '../api/ac_order.php?ac=complete&order_id='+id,
                        method: 'get',
                        dataType: 'json',
                        success: function(data) {
                            if(data.status) {
                                alertMsg(data.msg,data.type);
                                setTimeout(() => {
                                    window.location.reload(true);
                                },2000);
                            }else{
                                alertMsg(data.msg,data.type);
                                setTimeout(() => {
                                    window.location.reload(true);
                                },2000);
                            }
                        },error:function(err) {
                            console.log(err);
                            
                        }
                    })
                })
                $(document).on('click','#btn-confirmReq',function() {
                    let id = $(this).data("id");
                    Swal.fire({
                            text: "ต้องการยืนยันคำร้องขอแก้ไขใช่ไหม?",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "ใช่",
                            cancelButtonText: "ไม่ใช่"
                            }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: '../api/ac_order.php?ac=confirmReq&order_id='+id,
                                    method: 'get',
                                    dataType: 'json',
                                    success: function(data) {
                                        if(data.status) {
                                            alertMsg(data.msg,data.type);
                                            setTimeout(() => {
                                                window.location.reload(true);
                                            },2000);
                                        }else{
                                            alertMsg(data.msg,data.type);
                                            setTimeout(() => {
                                                window.location.reload(true);
                                            },2000);
                                        }
                                    },error:function(err) {
                                        console.log(err);
                                        
                                    }
                                })
                            }
             
                     });
                })

                $(document).on("change","#grade",function() {
                        $.ajax({
                            url: "../api/ac_search.php?ac=admin_department&g_id="+$("#grade").val(),
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
                            url: "../api/ac_search.php?ac=admin_room&dep_id="+$("#department").val(),
                            method: "get",
                            success:function(data){
                                $("#room").html(data);
                            },error: function(err) {
                                console.log(err);
                                
                            }
                        })
                    })
                  

// ข้อมูลของแผนกต่างๆ
// const departmentData = {
//     vocational: {
//         labels: ['เทคโนโลยีสารสนเทศ', 'เทคนิคคอมพิวเตอร์', 'กลโรงงาน', 'ซ่อมบำรุง', 'เชื่อมโลหะ',
//                  'อิเล็กทรอกนิกส์', 'แมคคาทรอนิกส์', 'ก่อสร้างโยธา', 'ยนต์', 'ไฟฟ้ากำลัง'],
//         data: [50, 45, 40, 35, 30, 55, 60, 38, 42, 48]
//     },
//     high_vocational: {
//         labels: ['เทคโนโลยีสารสนเทศ', 'เทคนิคคอมพิวเตอร์', 'กลโรงงาน', 'ซ่อมบำรุง', 'เชื่อมโลหะ',
//                  'อิเล็กทรอกนิกส์', 'แมคคาทรอนิกส์', 'ก่อสร้างโยธา', 'ยนต์', 'ไฟฟ้ากำลัง'],
//         data: [70, 65, 55, 50, 45, 75, 80, 58, 62, 68]
//     }
// };

const ctx = document.getElementById('studentChart').getContext('2d');
let studentChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [], // ใช้ข้อมูลของ ปวช.
        datasets: [{
            label: 'จำนวนนักศึกษา',
            
            data: [], // ใช้ข้อมูลของ ปวช.
            backgroundColor: 'rgba(150, 220, 204, 0.97)' // ฟ้าครีมสีเดียวกันทุกแท่ง
        }],
        tooltipitem: [],
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        },
        plugins: {
            tooltip: {
                callbacks:{
                    title: function(tooltipitem) {
                        return 'ข้อมูลนักศึกษา';
                    },
                    label: function(tooltipItem){
                        const label = tooltipItem.label || [];
                        const value = tooltipItem.raw || 0;
                            return `${label}: ${value} คน`;
                    }
                }
            }
        }
    }
});

function updateChart(selectedClass) {
        $.ajax({
            url: '../api/ac_getData.php?ac=countDepartment', // ไฟล์ PHP ที่ดึงข้อมูลจากฐานข้อมูล
            method: 'GET',
            data: { class: selectedClass }, // ส่งระดับชั้นที่เลือกไปยังเซิร์ฟเวอร์
            dataType: 'json',
            success: function(response) {
                // อัปเดตข้อมูลกราฟ
                studentChart.data.labels = response.labels;
                studentChart.data.datasets[0].data = response.data;
                studentChart.data.datasets[0].label = response.grade;
                studentChart.update(); // อัปเดตกราฟ
            },
            error: function(xhr, status, error) {
                console.error("Error fetching data:", error);
            }
        });
    }

    // เมื่อผู้ใช้เลือกระดับชั้น
    $('#classSelect').on('change', function() {
        const selectedClass = $(this).val();
        updateChart(selectedClass); // อัปเดตกราฟ
    });

    // โหลดข้อมูลเริ่มต้นเมื่อหน้าเว็บโหลดเสร็จ
    $(document).ready(function() {
        const initialClass = $('#classSelect').val();
        updateChart(initialClass); // อัปเดตกราฟด้วยข้อมูลเริ่มต้น
    });

function exportToPDF() {
    // ดึงค่าจากฟอร์ม
    let pro_id = document.getElementById("pro_id").value;
    let grade = document.getElementById("grade").value;
    let department = document.getElementById("department").value;
    let room = document.getElementById("room").value;
    let quota = document.getElementById("quota").value;
    let order_round = document.getElementById("order_round").value;

    // สร้าง URL และส่งค่าพารามิเตอร์ไปที่หน้า exportPDF.php
    let url = "exportPDF.php?pro_id=" + pro_id + "&grade=" + grade + "&department=" + department + "&room=" + room + "&quota=" + quota + "&order_round=" + order_round;

    // เปิดหน้าใหม่สำหรับการสร้าง PDF
    window.open(url, "_blank");
}


    </script>
</html>