<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                
            </div>
            <div class="col-md-6">
                <div class="text-end">
                    <div id="visitorCount"></div>
                </div>
            </div>
        </div>
    </div>
</footer>

<script>
    var visitorCountElement = document.getElementById('visitorCount');

    var webSocket = new WebSocket('ws://localhost:8080/counter');

    webSocket.onmessage = function(event) {
        var data = JSON.parse(event.data);
        var visitorCount = data.visitorCount;
        var totalVisitors = data.totalVisitors;
        visitorCountElement.innerHTML = 'Đang truy cập: ' + visitorCount + ' | Tổng lượt truy cập: ' + totalVisitors;
    };
</script>
