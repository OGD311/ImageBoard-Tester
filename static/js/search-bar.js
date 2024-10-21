export function add_and_search(tag, include) { 
    const currentSearch = document.getElementById("searchBox").value || '';

    let tagLook;
    if (include) {
        tagLook = '-' + tag;
    } else {
        tagLook = tag.replace('-', '');
    }

    // Corrected regex to properly use tagLook
    const updatedSearch = currentSearch
        .replace(new RegExp(`(?:[^\\w]|\\b)${tagLook}\\b(?!\\w)`, 'g'), '')
        .replace(new RegExp(`(?:[^\\w]|\\b)${tag}\\b(?!\\w)`, 'g'), '')
        .replace(/\s+/g, ' ') 
        .trim();


    const newSearch = updatedSearch ? `${updatedSearch} ${tag}` : tag;

 
    let newUrl = '/core/main.php?search=' + newSearch;


    document.location.href = newUrl.toString();


    return "";
}

export function add_to_search(tag, include) { 
    const currentSearch = document.getElementById("searchBox").value || '';

    let tagLook;
    if (include) {
        tagLook = '-' + tag;
    } else {
        tagLook = tag.replace('-', '');
    }

    // Corrected regex to properly use tagLook
    const updatedSearch = currentSearch
        .replace(new RegExp(`(?:[^\\w]|\\b)${tagLook}\\b(?!\\w)`, 'g'), '')
        .replace(new RegExp(`(?:[^\\w]|\\b)${tag}\\b(?!\\w)`, 'g'), '')
        .replace(/\s+/g, ' ') 
        .trim();


    const newSearch = updatedSearch ? `${updatedSearch} ${tag}` : tag;

 
    document.getElementById("searchBox").value = newSearch;

    console.log(newSearch);


    return "";
}

export function remove_from_search(tag) { 
    const currentSearch = document.getElementById("searchBox").value || '';

    const updatedSearch = currentSearch 
        .replace(new RegExp(`(?:[^\\w]|\\b)${tag}\\b(?!\\w)`, 'g'), '')
        .replace(/\s+/g, ' ') 
        .trim();


    const newSearch = updatedSearch;  

 
    document.getElementById("searchBox").value = newSearch;

    console.log(newSearch);


    return "";
}

window.remove_from_search = remove_from_search;
 
window.add_and_search = add_and_search;

window.add_to_search = add_to_search;