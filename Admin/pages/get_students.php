<?php
require_once '../../config.php';
require_once BASE_PATH . '/Library/Db.class.php';

$departmentId = $_GET['departmentId'] ?? null;
$classId = $_GET['classId'] ?? null;
$search = $_GET['search'] ?? '';
$page = $_GET['page'] ?? 1;
$limit = 30;
$offset = ($page - 1) * $limit;

$params = [];
$where = [];

if ($departmentId) {
    $where[] = "d.DepartmentID = ?";
    $params[] = $departmentId;
}

if ($classId) {
    $where[] = "s.ClassID = ?";
    $params[] = $classId;
}

if ($search) {
    $where[] = "(s.StudentID LIKE ? OR u.FullName LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

$whereSql = '';
if ($where) {
    $whereSql = 'WHERE ' . implode(' AND ', $where);
}

$db = new Db();
$students = $db->selectQuery("SELECT s.StudentID, u.FullName, c.className, d.DepartmentName 
    FROM student s
    JOIN users u ON s.UserID = u.UserID
    JOIN class c ON s.ClassID = c.ClassID
    JOIN department d ON c.DepartmentID = d.DepartmentID
    $whereSql
    LIMIT $limit OFFSET $offset", $params);

$totalStudents = $db->selectQuery("SELECT COUNT(*) as total FROM student s
    JOIN users u ON s.UserID = u.UserID
    JOIN class c ON s.ClassID = c.ClassID
    JOIN department d ON c.DepartmentID = d.DepartmentID
    $whereSql", $params);

$totalPages = ceil($totalStudents[0]['total'] / $limit);

echo json_encode([
    'students' => $students,
    'totalPages' => $totalPages
]);
?>
