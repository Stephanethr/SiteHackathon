
    // Fonction pour rediriger vers l'accueil
    function retourAccueil() {
        window.location.href = "index.html";
    }

    // Gestion de l'événement pour le formulaire d'envoi
    var uploadForm = document.getElementById('uploadForm');
    uploadForm.addEventListener('submit', function(event) {
        event.preventDefault();
        var formData = new FormData(uploadForm);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'upload.php', true);

        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log(xhr.responseText);
                retourAccueil();
            } else {
                console.error('Erreur lors du téléversement : ' + xhr.status);
            }
        };

        xhr.onerror = function() {
            console.error('Erreur lors de la requête AJAX');
        };

        xhr.send(formData);
    });

    // Gestion de l'événement pour le bouton "Retour à l'accueil"
    var retourAccueilBtn = document.createElement('button');
    retourAccueilBtn.textContent = "Retour à l'accueil";
    retourAccueilBtn.id = 'retourAccueilBtn';
    document.body.appendChild(retourAccueilBtn);

    retourAccueilBtn.addEventListener('click', function() {
        retourAccueil();
    });