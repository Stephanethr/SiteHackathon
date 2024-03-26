document.addEventListener("DOMContentLoaded", function () {
    var searchInput = document.getElementById('search');
    var searchResults = document.getElementById('search-results');

    searchInput.addEventListener('keyup', function () {
        var query = this.value.trim();

        if (query !== '') {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'php/search.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        searchResults.innerHTML = xhr.responseText;
                    } else {
                        console.error('Erreur lors de la requête AJAX : ' + xhr.status);
                    }
                }
            };

            xhr.send('query=' + encodeURIComponent(query));
        } else {
            searchResults.innerHTML = '';
        }
    });

    // Gestion de l'événement pour les boutons de modification
    searchResults.addEventListener('click', function (event) {
        if (event.target.classList.contains('edit-button')) {
            var etudiantId = event.target.dataset.id;
            window.location.href = 'modifier.html?id=' + etudiantId; // Redirection vers modifier.html avec l'ID dans l'URL
        }
    });
});
