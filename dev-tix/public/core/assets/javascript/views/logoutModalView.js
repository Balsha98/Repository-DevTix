class LogoutModalView {
    #logoutModalContainer = $(".div-logout-modal-container");
    #btnsCloseModal = $(".btn-close-logout-modal");
    #btnLogout = $(".btn-logout");

    toggleLogoutModal() {
        this.#logoutModalContainer.toggleClass("hide-logout-modal");
    }

    addEventToggleLogoutModal(handlerFunction) {
        this.#btnsCloseModal.each((_, btn) => {
            $(btn)?.click(handlerFunction);
        });
    }

    addEventLogoutUser(handlerFunction) {
        this.#btnLogout.click(handlerFunction);
    }
}

export default new LogoutModalView();
