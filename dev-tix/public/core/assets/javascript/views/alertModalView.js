class AlertModalView {
    #alertContainer = $(".div-alert-modal-container");
    #iconContainer = $(".div-alert-modal-icon-container");
    #alertIcon = $(".alert-modal-icon");
    #alertHeading = $(".alert-modal-heading");
    #alertMessage = $(".alert-modal-message");
    #btnClose = $(".btn-alert-modal-close");
    #alertType;
    #redirect;

    constructor() {
        this.#btnClose.click(this.toggleAlertModal.bind(this, true));
    }

    addEventToggleAlertModal(handlerFunction, response) {
        handlerFunction(response);
    }

    displayModalVisuals(response) {
        this.#alertType = response["status"];
        this.#redirect = response["redirect"];

        // Reload page after some time.
        if (this.#alertType === "success") setTimeout(this.#redirectToPage.bind(this), 2000);

        // Set alert message.
        const iconType = this.#alertType === "success" ? "check" : "x";
        this.#alertIcon.attr("src", `/core/assets/media/icons/${iconType}.svg`);
        this.#iconContainer.css("background-color", `var(--${this.#alertType}`);

        // Wait for alert to load.
        setTimeout(() => this.#alertIcon.addClass("alert-icon-animation"), 200);

        // Set alert content.
        this.#alertHeading.text(response["response"]["heading"]);
        this.#alertMessage.text(response["response"]["message"]);

        // Mark a field as invalid if validation failed.
        if (response["input_id"]) this.#markInputInvalid(response["input_id"]);

        // Set alert button.
        this.#btnClose.text(this.#alertType === "success" ? "Confirm" : "Close");
    }

    #markInputInvalid(inputID) {
        const parent = $($(`#${inputID}`).closest(".div-input-container"));
        parent.addClass("invalid-input-container");
    }

    toggleAlertModal(clicked = false) {
        this.#alertContainer.toggleClass("hide-alert");
        this.#alertIcon.removeClass("alert-icon-animation");

        if (clicked && this.#alertType === "success") this.#redirectToPage();
    }

    #redirectToPage() {
        if (this.#redirect === "this") location.reload();
        else window.open(this.#redirect, "_self");
    }
}

export default new AlertModalView();
