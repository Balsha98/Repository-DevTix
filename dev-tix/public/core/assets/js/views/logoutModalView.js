class LogoutModalView {
    #logoutModalContainer = $(".div-logout-modal-container");
    #btnsCloseModal = $(".btn-close-logout-modal");

    toggleLogoutModal() {
        this.#logoutModalContainer.toggleClass("hide-logout-modal");
    }

    addEventToggleLogoutModal(handlerFunction) {
        this.#btnsCloseModal.each((_, btn) => {
            $(btn)?.click(handlerFunction);
        });
    }
}

export default new LogoutModalView();
