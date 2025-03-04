<?php 
    session_start();
    if(!$_SESSION['user_id']) {
        header("Location: ../login.php");
    }
    include '../api/function.php';
    $sql_profile = db()->query("SELECT * FROM tb_user WHERE user_id='".$_SESSION['user_id']."' ");
    $fet_profile = $sql_profile->fetch_object();
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
                $(document).on("change","#grade",function() {
                        $.ajax({
                            url: "../api/ac_search.php?ac=roomHead&g_id="+$("#grade").val() + "&department=<?= getDepartment($fet_profile->dep_id); ?>",
                            method: "get",
                            success:function(data){
                                $("#room").html(data);
                            },error: function(err) {
                                console.log(err);
                                
                            }
                        })
                    })
                       
                  





    </script>
</html>