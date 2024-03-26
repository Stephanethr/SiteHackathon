// Définition de la classe Etudiant en JavaScript
class Etudiant {
    constructor(id, nom, prenom, promo, skills) {
        this.id = id;
        this.nom = nom;
        this.prenom = prenom;
        this.promo = promo;
        this.skills = skills;
    }

    // Méthode statique pour récupérer un étudiant par son ID
    static getById(id) {
        console.log("id dans la fonction getById de Etudiant.js : " + id)
        return fetch('php/getEtudiant.php?id=' + encodeURIComponent(id))
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur lors de la récupération des données de l\'étudiant');
                }
                return response.json();
            })
            .then(data => {
                console.log("data dans la fonction getById de Etudiant.js : " + data.id + " " + data.nom + " " + data.prenom + " " + data.promo + " " + data.skills)
                return new Etudiant(data.id, data.nom, data.prenom, data.promo, data.skills);
            })
            .catch(error => {
                console.error('Erreur lors de la récupération des données de l\'étudiant:', error);
                return null;
            });
    }

    // Méthode pour sauvegarder les données de l'étudiant
    saveEtudiant() {
        console.log(this);
        return fetch('php/saveEtudiant.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                id: this.id,
                nom: this.nom,
                prenom: this.prenom,
                promo: this.promo,
                skills: this.skills
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur lors de la sauvegarde des données de l\'étudiant');
            }
            return true;
        })
        .catch(error => {
            console.error('Erreur lors de la sauvegarde des données de l\'étudiant:', error);
            return false;
        });
    }

    // Getters et setters
    getId() {
        return this.id;
    }

    getNom() {
        return this.nom;
    }

    getPrenom() {
        return this.prenom;
    }

    getPromo() {
        return this.promo;
    }

    getSkills() {
        return this.skills;
    }

    setId(id) {
        this.id = id;
    }

    setNom(nom) {
        this.nom = nom;
    }

    setPrenom(prenom) {
        this.prenom = prenom;
    }

    setPromo(promo) {
        this.promo = promo;
    }

    setSkills(skills) {
        this.skills = skills;
    }
}
