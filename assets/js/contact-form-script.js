(function ($) {
    "use strict"; // Début de use strict

    // Validation et soumission du formulaire
    $("#contactForm").validator().on("submit", function (event) {
        if (event.isDefaultPrevented()) {
            // Gestion du formulaire invalide
            formError("Veuillez remplir correctement tous les champs requis.");
        } else {
            // Si tout est correct, soumission
            event.preventDefault();
            submitForm();
        }
    });

    // Fonction de soumission du formulaire
    function submitForm() {
        // Récupération des données du formulaire
        const name = $("#name").val();
        const email = $("#email").val();
        const phone_number = $("#phone_number").val();
        const subject = $("#subject").val();
        const message = $("#message").val();

        // Appel AJAX pour envoyer les données
        $.ajax({
            type: "POST",
            url: "assets/php/form-process.php",
            data: {
                name: name,
                email: email,
                phone_number: phone_number,
                subject: subject,
                message: message,
            },
            success: function (response) {
                if (response.trim() === "success") {
                    formSuccess("Votre message a été envoyé avec succès !");
                } else {
                    formError(response);
                }
            },
            error: function () {
                formError("Une erreur s'est produite. Veuillez réessayer plus tard.");
            },
        });
    }

    // Gestion des succès
    function formSuccess(message) {
        $("#contactForm")[0].reset(); // Réinitialisation du formulaire
        Swal.fire({
            icon: "success",
            title: "Succès",
            text: message,
            confirmButtonText: "OK",
        });
    }

    // Gestion des erreurs
    function formError(message) {
        Swal.fire({
            icon: "error",
            title: "Erreur",
            text: message,
            confirmButtonText: "OK",
        });
    }
})(jQuery); // Fin de use strict
