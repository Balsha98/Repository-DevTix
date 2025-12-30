class PostTicketModalView {
    #postTicketModalContainer = $(".div-post-ticket-modal-container");
    #btnsCloseModal = $(".btn-close-post-ticket-modal");

    togglePostTicketModal() {
        this.#postTicketModalContainer.toggleClass("hide-post-ticket-modal");
    }

    addEventTogglePostTicketModal(handlerFunction) {
        this.#btnsCloseModal.each((_, btn) => {
            $(btn)?.click(handlerFunction);
        });
    }
}

export default new PostTicketModalView();
