document.addEventListener('DOMContentLoaded', (event) => {

    const flashMessage = document.querySelector('.alert');

    if (flashMessage) {
        setTimeout(hideMessage, 3000);
    }
});


const offcanvasWidth = 992;
document.addEventListener("DOMContentLoaded", function() {
    console.log("Script loaded");
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


function hideMessage() {
    const messageDiv = document.getElementById('message-flash');
    if (messageDiv) {
        messageDiv.style.display = 'none';
    }
}
