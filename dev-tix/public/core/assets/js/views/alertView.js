class AlertView {
    #alertContainer = $(".div-alert-container");
    #iconContainer = $(".div-icon-container");
    #alertIcon = $(".alert-icon");
    #alertHeading = $(".alert-heading");
    #alertMessage = $(".alert-message");
    #btnClose = $(".btn-alert-close");

    constructor() {
        this.#btnClose.click(this.toggleAlert.bind(this, true));
    }

    addEventToggleAlert(handlerFunction, response) {
        handlerFunction(response);
    }

    displayVisuals(response) {
        const alertType = response["status"];

        // Use localStorage for user signup.
        const page = location.pathname.split("/")[1];
        if (page === "signup") localStorage.setItem("isValid", alertType === "success" ? 1 : 0);

        // Reload page after some time.
        if (alertType === "success") setTimeout(() => location.reload(), 2000);

        // Set alert message.
        const serverPath = this.#alertIcon.data("server-path");
        const iconType = alertType === "success" ? "check" : "x";
        this.#alertIcon.attr("src", `${serverPath}/core/assets/media/icons/${iconType}.svg`);
        this.#iconContainer.css("background-color", `var(--${alertType}`);

        // Wait for alert to load.
        setTimeout(() => this.#alertIcon.addClass("icon-animation"), 200);

        // Set alert content.
        this.#alertHeading.text(response["response"]["heading"]);
        this.#alertMessage.text(response["response"]["message"]);

        // Set alert button.
        this.#btnClose.text(alertType === "success" ? "Confirm" : "Close");
        this.#btnClose.data("alert-type", alertType);
    }

    toggleAlert(clicked = false) {
        this.#alertContainer.toggleClass("hide-alert");
        this.#alertIcon.removeClass("icon-animation");

        const alertType = this.#btnClose.data("alert-type");
        if (clicked && alertType === "success") location.reload();
    }
}

export default new AlertView();
