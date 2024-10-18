export function add_to_search(tag, include) {
    const url = new URL(window.location.href);
    const currentSearch = url.searchParams.get('search') || '';

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

window.add_to_search = add_to_search;