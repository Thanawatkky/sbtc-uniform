<?php 
    session_start();
    include 'function.php';
    if(isset($_REQUEST['ac'])) {
        switch ($_REQUEST['ac']) {
            case 'countDepartment':
                $selectedGrade = $_REQUEST['class']; // รับระดับชั้นที่เลือก
                $where = 'WHERE user_role = 2';
                $grade = '';
                if(!empty($selectedGrade)) {
                    $where .= " AND g_id = '$selectedGrade'";

                 
                }
              
                $sql = db()->query("
                    SELECT g_id,dep_id, COUNT(user_id) AS CountUser FROM tb_user $where  GROUP BY dep_id 
                    
                ");                
                $users = [];
                $labels = [];
                $data = [];
                while($row = $sql->fetch_assoc()){
                    
                        if(getGrade($row['g_id']) == "ประกาศนียบัตรวิชาชีพชั้นสูง") {
                            $grade = "ปวส.";
                        }else if(getGrade($row['g_id']) == "ประกาศนียบัตรวิชาชีพ") {
                            $grade = "ปวช.";
                        }else if(getGrade($row['g_id']) == "ปริญญาตรี") {
                            $grade = "ป.ตรี";
                        }
                    
                    $dep = getDepartment($row['dep_id']);

                    $labels[] = empty($selectedGrade) ? "$grade $dep" : "$dep";
                    $data[] = $row['CountUser'];
                }
                echo json_encode([
                    'labels' => $labels,
                    'data' => $data,
                    'grade' => empty($selectedGrade) ? "จำนวนนักศึกษาทั้งหมด" : "จำนวนนักศึกษา ระดับชั้น $grade"
                ]);
                break;
                case 'getData':
                    $selectedDepartment = $_REQUEST['department'];
                    $selectedGrade = $_REQUEST['grade'];
        
                    $where = "WHERE user_role = 2";
                    if (!empty($selectedDepartment)) {
                        $where .= " AND tb_department.department = '$selectedDepartment'";
                    }
                    if (!empty($selectedGrade)) {
                        $where .= " AND tb_grade.grade = '$selectedGrade'";
                    }
        
                    $sql = db()->query("
                        SELECT tb_department.department,tb_user.*, COUNT(tb_user.user_id) AS count ,tb_grade.grade
                        FROM tb_user 
                        LEFT JOIN tb_department ON tb_user.dep_id = tb_department.dep_id
                        LEFT JOIN tb_grade ON tb_user.g_id = tb_grade.g_id
                        $where
                        GROUP BY tb_user.room
                    ");
        
                    $labels = [];
                    $data = [];
                    while ($row = $sql->fetch_assoc()) {
                        $labels[] = "ห้อง: ".$row['room'];
                        $data[] = $row['count'];
                    }
        
                    echo json_encode([
                        'labels' => $labels,
                        'data' => $data
                    ]);
                    break;
        
                default:
                    // คดีอื่นๆ
                    break;
        }
    }
?>