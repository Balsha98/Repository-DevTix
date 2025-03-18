class DashboardView {
    #btnPost = $(".btn-post");
    #btnAssign = $(".btn-assign");
    #btnResolve = $(".btn-resolve");
    #btnCancel = $(".btn-cancel");
    #spanTicketID = $(".span-ticket-id");
    #ticketDataContainers = $(".div-ticket-data-container");
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
        const containerType = recordID ? "response" : "request";
        this.#ticketDataContainers.each((_, container) => {
            const currContainerType = $(container).data("container-type");
            if (currContainerType === containerType) $(container).removeClass("hide-element");
            else $(container).remove();
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
            <li class="form-upload-image-inputs-list-item" data-image-id="${imageID}">
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
