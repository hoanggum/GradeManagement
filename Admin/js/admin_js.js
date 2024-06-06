
const sidebarToggle = document.querySelector("#sidebar-toggle");
sidebarToggle.addEventListener("click", function () {
    document.querySelector("#sidebar").classList.toggle("collapsed");
    document.querySelector(".fixed-header").classList.toggle("fixed-header-colapsed");

    if (window.innerWidth <= 768) {
        document.querySelector(".header-center").classList.toggle("visibled");
        document.querySelector(".header-right").classList.toggle("visibled");
        document.querySelector(".main-content").classList.toggle("visibled");
    }

});
function updateCSS() {
    if (window.innerWidth <= 1024) {
        document.querySelector("#sidebar").classList.toggle("collapsed");

        const fixedHeader = document.querySelector(".fixed-header");
        if (fixedHeader) {
            fixedHeader.classList.toggle("fixed-header-colapsed");
        }
    }


    const searchBox = document.querySelector(".search-box");
    if (searchBox) {
        if (window.innerWidth < 768) {
            searchBox.style.width = "100%";
            searchBox.style.margin = "1rem 0";
        }
        else {
            searchBox.style.width = "60%";
            searchBox.style.margin = "0";
        }
    }
    const contentBoxElements = document.querySelector(".content-box");
    if (contentBoxElements) {
        const cardElements = contentBoxElements.querySelectorAll(".card");
        //const homeChartBox = document.querySelector(".home-chart-box");
        if (window.innerWidth >= 768) {
            cardElements.forEach(function (card) {
                card.classList.toggle("flex-row");
            });
            //if (homeChartBox) {
            //    homeChartBox.style.display = "block";
            //}
        }
        else {
            contentBoxElements.style.padding = "0 1rem";
            cardElements.forEach(function (card) {
                card.classList.toggle("flex-column");
            });
            //if (homeChartBox) {
            //    homeChartBox.style.display = "none";
            //}
        }
    }

    const accountInfo = document.querySelector("#account-info");
    if (accountInfo) {
        if (window.innerWidth >= 768) {
            accountInfo.style.padding = "0 calc(20%)";
            accountInfo.style.paddingTop = "2rem";
        }
        else {
            accountInfo.style.padding = "0 3rem";
            accountInfo.style.paddingTop = "2rem";
        }
    }

    const orderList = document.querySelector(".order-list");
    if (orderList) {
        if (orderList.querySelector(".order-item")) {
            const listOrderItem = orderList.querySelectorAll(".card");
            if (window.innerWidth < 768) {
                listOrderItem.forEach(function (item) {
                    item.classList.toggle("card-flex-column");
                    item.querySelector(".card-body").classList.toggle("flex-column");
                    item.querySelector(".action-btn").classList.toggle("flex-column");
                    item.querySelector(".card-serial").classList.toggle("text-center");
                    item.querySelector(".wait-for-confirm-box").classList.toggle("text-left");
                });
            }
        }
    }
}
var navToggles = document.querySelectorAll('.nav-toggle');

// Duyệt qua từng nút và thêm sự kiện click
navToggles.forEach(function(navToggle) {
    navToggle.addEventListener('click', function(event) {
        // Ngăn chặn hành vi mặc định của liên kết
        event.preventDefault();
        
        // Tìm thẻ cha (li) của nút nav-toggle
        var parentNavItem = this.closest('.nav-item');

        // Kiểm tra xem menu con (sub-menu) có đang được hiển thị không
        var subMenu = parentNavItem.querySelector('.sub-menu');
        var isActive = parentNavItem.classList.contains('active');

        // Nếu đang hiển thị, ẩn đi; nếu không, hiển thị
        if (isActive) {
            parentNavItem.classList.remove('active');
        } else {
            // Ẩn tất cả các menu con khác trước khi hiển thị menu này
            var activeNavItems = document.querySelectorAll('.nav-item.active');
            activeNavItems.forEach(function(item) {
                item.classList.remove('active');
            });

            parentNavItem.classList.add('active');
        }
    });
});
/*--*/

window.addEventListener('load', updateCSS);
window.addEventListener('resize', updateCSS);