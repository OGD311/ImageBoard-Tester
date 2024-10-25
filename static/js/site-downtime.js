const currentUrl = window.location.pathname;  
const downtimePage = '/downtime.php';
 
if (currentUrl !== downtimePage) { 
    window.location.href = downtimePage;
}
