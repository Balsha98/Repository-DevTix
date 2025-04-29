class ResolveTicketModalView {
    #resolveTicketModalContainer = $(".div-resolve-ticket-modal-container");
    #btnsCloseModal = $(".btn-close-resolve-ticket-modal");

    toggleResolveTicketModal() {
        this.#resolveTicketModalContainer.toggleClass("hide-resolve-ticket-modal");
    }

    addEventToggleResolveTicketModal(handlerFunction) {
        this.#btnsCloseModal.each((_, btn) => {
            $(btn)?.click(handlerFunction);
        });
    }
}

export default new ResolveTicketModalView();
