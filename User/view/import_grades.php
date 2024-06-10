<?php
require_once '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

if (isset($_POST['btn_import_file_excel'])) {

    $excelMimes = array('text/xls', 'text/xlsx', 'application/excel', 'application/vnd.msexcel', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    ini_set('memory_limit', '512M');

    if (!empty($_FILES['excel-file']['name']) && in_array($_FILES['excel-file']['type'], $excelMimes)) {

        if (is_uploaded_file($_FILES['excel-file']['tmp_name'])) {
            $reader = new Xlsx();
            $spreadsheet = $reader->load($_FILES['excel-file']['tmp_name']);
            $worksheet = $spreadsheet->getActiveSheet();
            $worksheet_arr = $worksheet->toArray();


            unset($worksheet_arr[0]);

            foreach ($worksheet_arr as $row) {
                if (!empty(array_filter($row))) {
                    $sectionID = $row[0];
                    $studentName = $row[1];
                    if (!empty($studentName)) {
                        $student = $teacherObj->getSudent_by_Id($studentName);
                        $id_student = $student[0]["StudentID"];
                    }
             
                    $grade = $row[2];
                    $semester = $row[3];
                    $gradeInClass = $row[4];
                    $result = $teacherObj->import_file_excel_point($sectionID, $id_student, $grade, $semester, $gradeInClass);
                  
                    if ($result > 0) {
                        $success_message = "Dữ liệu đã được nhập thành công từ tệp Excel.";
                    } else {
                        $error_message = "Có lỗi xảy ra trong quá trình nhập dữ liệu.";
                    }
                }
            }

            $redirect_url = "/admin/index.php?page=listSalary";
        } else {
            $error_message = "thêm không thành công";
            $redirect_url = "/admin/index.php?page=listSalary";
        }
    } else {
        $error_message = "Không tìm tháy file";
        $redirect_url = "/admin/index.php?page=listSalary";
    }
}

// Redirect to the listing page
echo "<script>";
if (isset($success_message)) {
    echo "alert('$success_message');";
}
if (isset($error_message)) {
    echo "alert('$error_message');";
}
echo "window.location='$redirect_url';";
echo "</script>";
