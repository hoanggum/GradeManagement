<script src="https://kit.fontawesome.com/bfc21e4b01.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</html>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Lắng nghe sự kiện click vào hình ảnh người dùng
        document.getElementById('userAvatar').addEventListener("click", function() {
            // Toggle (bật/tắt) lớp 'active' trên thanh taskbar
            document.querySelector('.sidebar').classList.toggle('active');
        });

        // Lắng nghe sự kiện click vào nút đóng sidebar
        document.getElementById('closeSidebar').addEventListener("click", function() {
            // Xóa lớp 'active' để đóng sidebar
            document.querySelector('.sidebar').classList.remove('active');
        });
    });
</script>
