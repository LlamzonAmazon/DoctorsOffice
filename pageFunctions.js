function sortData(sortingAttribute) {
    // Redirect to the current page with the selected sorting attribute
    const currentUrl = window.location.href.split('?')[0]; // Remove existing query parameters
    window.location.href = `${currentUrl}?sort=${sortingAttribute}`;
}
