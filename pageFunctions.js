function sortData() {
    // Get the selected sort option from the sort form
    let sortOrder = document.querySelector('#sortForm input[name="sort"]:checked').value;
    // Get the selected direction from the direction form
    let direction = document.querySelector('#directionForm input[name="direction"]:checked').value;
    
    // Reload the page with separate sort and direction parameters
    window.location.href = "patients.php?sort=" + sortOrder + "&direction=" + direction;
}
