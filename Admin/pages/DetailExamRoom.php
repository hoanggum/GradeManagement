<?php
// Include the necessary files
include_once '../Model/ExamRoom.php'; // Assuming you have an ExamRoomController.php file
include_once '../Model/Student.php'; // Assuming you have a StudentController.php file

// Check if the room ID is set and not empty
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $roomId = $_GET['id'];
    
    // Instantiate the ExamRoomController object
    $examRoomController = new ExamRoom();
    // Get the room details by ID
    $room = $examRoomController->getRoomById($roomId);

    if($room) {
        // Instantiate the StudentController object
        $studentController = new Student();
        // Get the list of students in the room by room ID
        $students = $studentController->getStudentsByRoomId($roomId);
    } else {
        // Redirect to the list of exam rooms if the room ID is invalid
        header("Location: listRooms.php");
        exit();
    }
} else {
    // Redirect to the list of exam rooms if the room ID is not set
    header("Location: listRooms.php");
    exit();
}
?>
<style>
    .container {
        position: relative;
    }

    .back-btn {
        position: absolute;
        top: 30px;
        left: 15px;
        font-size: 24px;
        color: #007bff;
        cursor: pointer;
    }

    .back-btn:hover {
        color: #0056b3;
    }

    .card-body {
        text-align: center;
    }

    .card-title {
        color: #007bff;
    }

    .student-image {
        width: 90px;
        height: auto;
        float: right;
    }

    .table td {
        font-size: 14px;
    }
</style>

<div class="container mt-5">
    <div class="card mb-3">
        <a href="?page=listExamRoom" class="back-btn"><i class="fa-solid fa-arrow-left"></i></a>
        <div class="card-body">
            <h1 class="card-title font-weight-bold text-primary"><?php echo $room[0]['room_name']; ?></h1>
            <p class="card-text"><strong>Sức chứa:</strong> <?php echo $room[0]['capacity']; ?></p>
        </div>
    </div>
    <h2>Danh sách sinh viên trong phòng thi</h2>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Hình ảnh</th>
                <th scope="col">Họ và tên</th>
                <th scope="col">Ngày sinh</th>
                <th scope="col">Giới tính</th>
                <th scope="col">Email</th>
                <th scope="col">Địa chỉ</th>
                <th scope="col">Số điện thoại</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $key => $student): ?>
            <tr>
                <th scope="row"><?php echo $key + 1; ?></th>
                <td><img class="student-image" src="../img/<?php echo $student['Urls']; ?>" alt="Hình ảnh sinh viên"></td>
                <td><?php echo $student['FullName']; ?></td>
                <td><?php echo $student['DateOfBirth']; ?></td>
                <td><?php echo $student['Gender']; ?></td>
                <td><?php echo $student['Email']; ?></td>
                <td><?php echo $student['Address']; ?></td>
                <td><?php echo $student['Phone']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
