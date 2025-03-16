class DashboardView {
    #btnPost = $(".btn-post");
    #btnAssign = $(".btn-assign");
    #btnUpdate = $(".btn-update");
    #btnResolve = $(".btn-resolve");
    #btnCancel = $(".btn-cancel");
    #spanTicketID = $(".span-ticket-id");
    #ticketForms = $(".form");
    #ticketSelectType = $(".ticket-select-type");
    #btnsUpload = $(".btn-upload");
    #spanImagesLeft = $(".span-images-left");
    #spanRequestAction = $(".span-request-action");

    addEventPostRequest(handlerFunction) {
        this.#btnPost?.click(handlerFunction);
    }

    addEventAssignRequest(handlerFunction) {
        this.#btnAssign?.click(handlerFunction);
    }

    addEventUpdateRequest(handlerFunction) {
        this.#btnUpdate?.click(handlerFunction);
    }

    addEventResolveRequest(handlerFunction) {
        this.#btnResolve?.click(handlerFunction);
    }

    addEventCancelRequest(handlerFunction) {
        this.#btnCancel?.click(handlerFunction);
    }

    addEventSelectTicketType(handlerFunction) {
        this.#ticketSelectType?.change(handlerFunction);
    }

    addEventGenerateImageInput(handlerFunction) {
        this.#btnsUpload?.click(handlerFunction);
    }

    toggleTicketForms(recordID) {
        const formType = recordID ? "alter" : "create";
        this.#ticketForms.each((_, form) => {
            const currFormType = $(form).data("form-type");
            if (currFormType === formType) $(form).removeClass("hide-element");
            else $(form).remove();
        });
    }

    setSpanTicketId(ticketID) {
        this.#spanTicketID.text(`#${ticketID}`);
    }

    generateCustomTicketTypeField() {
        return `
            <div class="div-input-container div-custom-ticket-type-container required-container">
                <label class="absolute-y-center" for="custom_type">
                    <ion-icon src="/core/assets/media/icons/filter.svg"></ion-icon>
                </label>
                <input id="custom_type" type="text" name="custom_type" placeholder="Custom Ticket Type" required>
            </div>
        `;
    }

    generateImageInput(imageID) {
        return `
            <li class="form-create-image-inputs-list-item" data-image-id="${imageID}">
                <label class="absolute-y-center input-image-label flex-center" for="image_name_${imageID}">
                    <ion-icon src="/core/assets/media/icons/image.svg"></ion-icon>
                </label>
                <div class="div-input-image-container">
                    <input id="image_name_${imageID}" class="input-image-name" type="text" name="image_name" value="Image Name" readonly>
                    <label class="btn btn-primary btn-upload" for="image_${imageID}" role="button">Upload</label>
                    <input id="image_${imageID}" class="input-image" type="file" name="image">
                </div>
            </li>
        `;
    }

    setSpanImagesLeft(imagesLeft) {
        this.#spanImagesLeft.text(imagesLeft);
    }

    setSpanRequestAction(action) {
        this.#spanRequestAction.text(action[0].toUpperCase() + action.slice(1));
    }
}

export default new DashboardView();
