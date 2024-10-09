import { getCookie } from './cookie.js';

if (getCookie("ageCheck") !== "agree") {
    window.location.href = "age-check.php";
}
