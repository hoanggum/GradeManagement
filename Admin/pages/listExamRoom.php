<?php
require_once '../Model/ExamRoom.php'; // Include the ExamRoom model

// Initialize the ExamRoom object
$examRoomObj = new ExamRoom();

// Fetch all rooms
$rooms = $examRoomObj->getAllRooms();
?>

<div id="main-content-wp" class="list-product-page">
    <div class="wrap clearfix">
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h2 id="index" class="fl-left">Danh sách phòng thi</h2>
                    <hr>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <div class="table-responsive">
                        <table class="table list-table-wp" id="tblRooms">
                            <thead class="table-dark">
                                <tr>
                                    <th>STT</th>
                                    <th>Tên phòng thi</th>
                                    <th>Sức chứa</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rooms as $key => $room) : ?>
                                    <tr>
                                        <td><?php echo $key + 1; ?></td>
                                        <td><?php echo $room['room_name']; ?></td>
                                        <td><?php echo $room['capacity']; ?></td>
                                        <td>
                                            <!-- Liên kết chi tiết phòng thi -->
                                            <a href="?page=DetailExamRoom&id=<?php echo $room['room_id']; ?>" title="Chi tiết">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <!-- Liên kết sửa thông tin phòng thi -->
                                            <a href="?page=editRoom&id=<?php echo $room['room_id']; ?>" title="Sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <!-- Liên kết xóa phòng thi -->
                                            <a href="?page=deleteRoom&id=<?php echo $room['room_id']; ?>" title="Xóa">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    new DataTable('#tblRooms');
</script>
