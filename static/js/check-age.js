import { getCookie } from './cookie.js';
 
const currentUrl = window.location.pathname;  
const ageCheckPage = '/age-check.php';
 
if (getCookie("ageCheck") !== "agree" && currentUrl !== ageCheckPage) { 
    window.location.href = ageCheckPage;
}
