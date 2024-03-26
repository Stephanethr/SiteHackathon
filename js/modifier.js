document.addEventListener("DOMContentLoaded", async function() {
    // Récupérer l'ID de l'étudiant depuis l'URL
    var params = new URLSearchParams(window.location.search);
    var etudiantId = params.get('id');
    var etudiant;

    if (etudiantId) {
        try {
            // Récupérer les données de l'étudiant
            etudiant = await Etudiant.getById(etudiantId);

            // Vérifier si l'étudiant a été trouvé
            if (etudiant) {
                // Mettre à jour les champs du formulaire avec les données de l'étudiant
                document.getElementById('nom').value = etudiant.getNom();
                document.getElementById('prenom').value = etudiant.getPrenom();
                document.getElementById('promo').value = etudiant.getPromo();
                if (etudiant.getSkills() != null){
                    document.getElementById('skills').value = etudiant.getSkills();
                }
            } else {
                console.error("Aucun étudiant trouvé avec l'ID:", etudiantId);
            }
        } catch (error) {
            console.error('Erreur lors de la récupération des données de l\'étudiant:', error);
        }
    } else {
        console.error("ID de l'étudiant non trouvé dans l'URL.");
    }

    // Événement pour sauvegarder les modifications lorsque l'utilisateur clique sur "Enregistrer"
    document.getElementById('enregistrer').addEventListener('click', async function(event) {
        // Empêcher le comportement par défaut du bouton (soumission du formulaire)
        event.preventDefault();

        // Récupérer les valeurs des champs du formulaire
        var nom = document.getElementById('nom').value;
        var prenom = document.getElementById('prenom').value;
        var promo = document.getElementById('promo').value;
        var skills = document.getElementById('skills').value;

        // Mettre à jour les attributs de l'étudiant avec les nouvelles valeurs du formulaire
        etudiant.setNom(nom);
        etudiant.setPrenom(prenom);
        etudiant.setPromo(promo);
        etudiant.setSkills(skills);

        console.log("objet etudiant : " + etudiant.getId() + " " + etudiant.getNom() + " " + etudiant.getPrenom() + " " + etudiant.getPromo() + " " + etudiant.getSkills());
    });

    // Événement pour retourner au menu (index.html)
    document.getElementById('retour').addEventListener('click', function() {
        window.location.href = "index.html";
    });

    // Intercepter le départ de la page pour sauvegarder les modifications en base de données
    window.addEventListener('beforeunload', async function() {
        // Sauvegarder les données de l'étudiant en base de données
        if (etudiant) {
            var saved = await etudiant.saveEtudiant();

            // Vérifier si la sauvegarde a réussi
            if (saved) {
                console.log('Modifications sauvegardées en base de données.');
            } else {
                console.error('Erreur lors de la sauvegarde en base de données.');
            }
        }
    });
});
