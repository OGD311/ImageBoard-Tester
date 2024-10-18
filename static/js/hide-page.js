window.onload = function() {
    localStorage.setItem('lastVisited', window.location.href);
};

document.addEventListener('keydown', function(e) {

    if (e.keyCode === 120) { 
        const currentUrl = window.location.href;
        
        if (currentUrl.includes("hide")) {

            const lastVisited = localStorage.getItem('lastVisited');
            if (lastVisited) {
                window.location.href = lastVisited;
            } else {
                window.location.href = "/core/main.php"; 
            }
        } else {
            window.location.href = "/core/hide.php";
        }
    }
});
