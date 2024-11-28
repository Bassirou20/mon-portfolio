class MessageHandler {
    constructor(selector) {
        this.messageElement = document.querySelector(selector);
        if (!this.messageElement) {
            console.error(`Element with selector "${selector}" not found.`);
            return;
        }
    }

    showMessage(isValid, msg) {
        if (!this.messageElement) return;

        // Classes en fonction de la validité
        const msgClasses = isValid
            ? "h4 text-left tada animated text-success"
            : "h4 text-left text-danger";

        // Appliquer les classes et afficher le message
        this.messageElement.className = msgClasses;
        this.messageElement.textContent = msg;

        // Rendre visible l'élément
        this.messageElement.style.display = "block";
    }

    hideMessage() {
        if (this.messageElement) {
            this.messageElement.style.display = "none";
        }
    }
}
