import { getCookie } from './cookie.js';

if (getCookie("ageCheck") !== "agree") {
    window.location.href = "http://localhost:8080/age-check.php";
}
