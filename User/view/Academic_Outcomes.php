<?php
require_once '../Model/Semester.php';
// Assuming you have a way to get the current user's ID, for example through session
session_start();
$userId = $_SESSION['UserID'];

// Instantiate the Semester class
$semesterObj = new Semester();
$semesters = $semesterObj->getSemestersByUserId($userId);

// Group the grades by semester
$gradesBySemester = [];
foreach ($semesters as $semester) {
    $gradesBySemester[$semester['semester']][] = $semester;
}
$passedCredits = 0;
?>
<style>
    .grade-report-container {
    font-family: Arial, sans-serif;
    width: 100%;
    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.header {
    text-align: center;
    margin-bottom: 20px;
}

.student-info {
    margin-bottom: 20px;
}

.student-info p {
    margin: 5px 0;
}

.semester-container {
    margin-top: 20px;
}

.semester-section {
    margin-bottom: 30px;
}

.semester-section h2 {
    margin-bottom: 10px;
    color: #333;
}

.grade-table {
    width: 100%;
    border-collapse: collapse;
}

.grade-table th, .grade-table td {
    padding: 10px;
    border: 1px solid #ccc;
}

.grade-table th {
    background-color: #f2f2f2;
    font-weight: bold;
    text-align: center;
}

.grade-table td {
    text-align: center;
}

.footer {
    text-align: center;
    margin-top: 20px;
    color: #777;
}

</style>
<div class="grade-report-container">
    <header>
        <h1>Student Grade Report</h1>
        <div class="student-info">
            <p>Name: <span class="student-name"><?php echo htmlspecialchars($semesters[0]['FullName']); ?></span></p>
            <p>ID: <span class="student-id"><?php echo htmlspecialchars($semesters[0]['StudentID']); ?></span></p>
        </div>
    </header>
    <main class="semester-container">
        <?php foreach ($gradesBySemester as $semester => $grades): ?>
            <section class="semester-section">
                <h4>HK<?php echo htmlspecialchars($semester); ?></h4>
                <table class="grade-table">
                    <thead>
                        <tr>
                            <th>Tên môn học/ học phần</th>
                            <th>Số tín chỉ</th>
                            <th>Điểm tại lớp</th>
                            <th>Điểm thi</th>
                            <th>Điểm tổng kết</th>
                            <th>Thang điểm 4</th>
                            <th>Điểm chữ</th>
                            <th>Xếp loại</th>
                            <th>Đạt</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($grades as $grade): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($grade['SubjectName']); ?></td>
                                <td><?php echo htmlspecialchars($grade['NumOfCredits']); ?></td>
                                <td><?php echo htmlspecialchars($grade['GradeInClass']); ?></td>
                                <td><?php echo htmlspecialchars($grade['Grade']); ?></td>
                                <?php
                                $finalGrade = $semesterObj->calculateFinalGrade($grade['GradeInClass'], $grade['Grade']);
                                $gradePoint4 = $semesterObj->convertToGradePoint4($finalGrade);
                                $letterGrade = $semesterObj->convertToLetterGrade($finalGrade);
                                $evaluation = $semesterObj->evaluateGrade($finalGrade);
                                if ($gradePoint4 != 0.0) {
                                    $pass = true;
                                    $passedCredits += $grade['NumOfCredits'];
                                }
                                ?>
                                <td><?php echo htmlspecialchars($finalGrade); ?></td>
                                <td><?php echo htmlspecialchars($gradePoint4); ?></td>
                                <td><?php echo htmlspecialchars($letterGrade); ?></td>
                                <td><?php echo htmlspecialchars($evaluation); ?></td>
                                <td><?php if ($pass): ?>
                                    <p style="color: #4CAF50">&#10004; Đạt</p>
                                <?php endif; ?></td>
                                
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        <?php endforeach; ?>
    </main>
    <footer>
        <p>&copy; 2024 Your School Name</p>
    </footer>
</div>
