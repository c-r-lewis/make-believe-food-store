const offcanvasWidth = 992;
document.addEventListener("DOMContentLoaded", function() {
    checkScreenWidth();

    window.addEventListener('resize', function () {
        checkScreenWidth();
    });
})

function checkScreenWidth() {
    let screenWidth = window.innerWidth || window.documentElement.clientWidth || window.document.body.clientWidth;
    const offCanvas = document.getElementById("sidebar-nav");
    offCanvas.setAttribute("data-bs-backdrop", screenWidth >= offcanvasWidth ? 'false' : 'true');
}