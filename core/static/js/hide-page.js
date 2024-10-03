window.onload = function() {
    localStorage.setItem('lastVisited', window.location.href);
};

document.addEventListener('keydown', function(e) {
    console.log(e.keyCode);

    if (e.keyCode === 120) { 
        const currentUrl = window.location.href;
        
        if (currentUrl.includes("hide")) {

            const lastVisited = localStorage.getItem('lastVisited');
            if (lastVisited) {
                window.location.href = lastVisited;
            } else {
                window.location.href = "http://localhost:8080/core/index.php"; 
            }
        } else {
            window.location.href = "http://localhost:8080/core/hide.php";
        }
    }
});
