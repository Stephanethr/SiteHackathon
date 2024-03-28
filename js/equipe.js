document.addEventListener("DOMContentLoaded", function () {
    // Récupérer le formulaire de création d'équipe
    const createTeamForm = document.getElementById('createTeamForm');
    // Ajouter un écouteur d'événement pour la soumission du formulaire
    createTeamForm.addEventListener('submit', function (event) {
        event.preventDefault(); // Empêcher la soumission par défaut du formulaire

        // Récupérer le nom de l'équipe depuis le formulaire
        const teamName = document.getElementById('teamName').value;

        // Effectuer une requête AJAX pour créer une équipe
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'php/equipe.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Recharger la page pour afficher la nouvelle équipe créée
                    window.location.reload();
                } else {
                    console.error('Erreur lors de la création de l\'équipe:', xhr.responseText);
                }
            }
        };
        xhr.send('action=create&teamName=' + encodeURIComponent(teamName));
        console.log('Création de l\'équipe:', teamName);
    });

    // Charger les équipes existantes au chargement de la page
    loadTeams();
});

function loadTeams() {
    // Effectuer une requête AJAX pour charger les équipes depuis la base de données
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'php/equipe.php?action=fetch', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                const teams = JSON.parse(xhr.responseText);
                displayTeams(teams);
            } else {
                console.error('Erreur lors du chargement des équipes:', xhr.responseText);
            }
        }
    };
    xhr.send();
}

function displayTeams(teams) {
    const teamTableBody = document.getElementById('teamTableBody');
    teamTableBody.innerHTML = ''; // Nettoyer le contenu existant du tableau
    if (teams !== null) {
        teams.forEach(function (team) {
            const row = document.createElement('tr');
            row.innerHTML = `
            <td>${team.id}</td>
            <td>${team.name}</td>
            <td>${team.date}</td>
            <td>
                <button class="button is-primary" onclick="applyToTeam(${team.id})">Postuler</button>
                <button class="button is-info" onclick="inviteToTeam(${team.id})">Inviter</button>
            </td>
        `;
            teamTableBody.appendChild(row);
        });
    }
}

function applyToTeam(teamId) {
    // Implémenter la logique pour postuler à une équipe
}

function inviteToTeam(teamId) {
    // Implémenter la logique pour inviter un étudiant dans une équipe
}
