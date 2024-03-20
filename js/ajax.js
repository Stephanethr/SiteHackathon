$(document).ready(function(){
    $('#search').keyup(function(){
        var query = $(this).val();
        if(query !== ''){
            $.ajax({
                url: 'php/search.php',
                method: 'POST',
                data: {query: query},
                success: function(data){
                    $('#search-results').html(data);
                }                
            });
            console.log(query);
        } else {
            $('#search-results').html('');
        }
    });
});

// Fonction pour rediriger vers l'accueil
function retourAccueil() {
    window.location.href = "index.html";
}

document.addEventListener("DOMContentLoaded", function() {
    var form = document.getElementById('uploadForm');
    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Empêche le comportement par défaut du formulaire
        
        var formData = new FormData(form); // Récupère les données du formulaire
        var xhr = new XMLHttpRequest(); // Crée une requête AJAX
        
        // Configure la requête AJAX
        xhr.open('POST', 'upload.php', true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        
        // Gestionnaire d'événement de chargement
        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log(xhr.responseText); // Affiche la réponse du serveur
                retourAccueil(); // Redirige vers la page index.html après le téléversement réussi
            } else {
                console.error('Erreur lors du téléversement : ' + xhr.status);
            }
        };
        
        // Gestionnaire d'événement d'erreur
        xhr.onerror = function() {
            console.error('Erreur lors de la requête AJAX');
        };
        
        // Envoie de la requête avec les données du formulaire
        xhr.send(formData);
    });

    // Création du bouton "Retour à l'accueil"
    var retourAccueilBtn = document.createElement('button');
    retourAccueilBtn.textContent = "Retour à l'accueil";
    retourAccueilBtn.id = 'retourAccueilBtn';
    document.body.appendChild(retourAccueilBtn);

    // Gestion de l'événement pour le bouton "Retour à l'accueil"
    retourAccueilBtn.addEventListener('click', function() {
        retourAccueil();
    });
});
