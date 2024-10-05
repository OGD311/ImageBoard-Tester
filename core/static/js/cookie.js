export function getCookie(name) {
    const cookieArr = document.cookie.split('; ');

    for (const cookie of cookieArr) {
        const [key, value] = cookie.split('=');
        if (key.trim() === decodeURIComponent(name)) {
            return decodeURIComponent(value);
        }
    }

    return ""; 
}


export function setCookie(name, value, days) {
    let expires = "";
    if (days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}