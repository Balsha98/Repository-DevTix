class CancelTicketModalView {
    #cancelTicketModalContainer = $(".div-cancel-ticket-modal-container");
    #btnsCloseModal = $(".btn-close-cancel-ticket-modal");

    toggleCancelTicketModal() {
        this.#cancelTicketModalContainer.toggleClass("hide-cancel-ticket-modal");
    }

    addEventToggleCancelTicketModal(handlerFunction) {
        this.#btnsCloseModal.each((_, btn) => {
            $(btn)?.click(handlerFunction);
        });
    }
}

export default new CancelTicketModalView();
