class DashboardView {
    #btnDelete = $(".btn-delete");
    #btnSave = $(".btn-save");
    #spanTicketID = $(".span-ticket-id");
    #ticketForms = $(".form");
    #spanRequestAction = $(".span-request-action");

    toggleTicketForms(recordID) {
        const formType = recordID ? "alter" : "create";
        this.#ticketForms.each((_, form) => {
            if ($(form).data("form-type") === formType) $(form).removeClass("hide-element");
            else $(form).remove();
        });
    }

    setBtnSaveRequestMethod(recordID) {
        this.#btnSave.data("method", recordID ? "PUT" : "POST");
    }

    setSpanRequestAction(action) {
        this.#spanRequestAction.text(action[0].toUpperCase() + action.slice(1));
    }

    setSpanTicketId(ticketID) {
        this.#spanTicketID.text(`#${ticketID}`);
    }
}

export default new DashboardView();
