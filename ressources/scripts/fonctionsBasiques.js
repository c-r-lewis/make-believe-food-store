document.addEventListener('DOMContentLoaded', (event) => {
    document.querySelectorAll(".quantite").forEach(input => {
        mettreAJourPrixTotal(input);
    });
});

function mettreAJourPrixTotal(input) {
    const prixItem = parseFloat(input.dataset.price);
    const quantite = input.value;
    const total = prixItem * quantite;

    document.getElementById("prixTotalItem").textContent = total + "€";
}

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

document.getElementById('itemUpdate').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    // Fetch API to submit the form data asynchronously
    fetch(this.action, {
        method: this.method,
        body: new FormData(this),
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json(); // Assuming your response is JSON, adjust accordingly
        })
        .then(data => {
            // Handle the response data if needed
            console.log(data);
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
});
