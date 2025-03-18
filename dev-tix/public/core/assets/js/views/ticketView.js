class DashboardView {
    #ticketContentContainer = $(".div-ticket-content-container");
    #ticketContentContainerHeader = $(".ticket-container-header");
    #btnPost = $(".btn-post");
    #btnAssign = $(".btn-assign");
    #btnResolve = $(".btn-resolve");
    #btnCancel = $(".btn-cancel");
    #spanTicketID = $(".span-ticket-id");
    #ticketDataContainers = $(".div-ticket-data-container");
    #scrollableResponsesContainer = $(".div-scrollable-responses-container");
    #ticketImagesContainerHeader = $(".ticket-images-container-header");
    #ticketImagesList = $(".ticket-images-list");
    #ticketSelectType = $(".ticket-select-type");
    #btnUpload = $(".btn-upload");
    #spanImagesLeft = $(".span-images-left");
    #noneResponsesData = $(".div-none-responses-container");
    #noneImagesData = $(".div-none-images-container");
    #ticketImages = $(".ticket-image");
    #spanRequestAction = $(".span-request-action");
    #ticketContentContainerFooter = $(".ticket-container-footer");

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
        this.#btnUpload?.click(handlerFunction);
    }

    addEventToggleImageModal(handlerFunction) {
        this.#ticketImages.each((_, image) => {
            $(image)?.click(handlerFunction);
        });
    }

    toggleTicketDataContainers(recordID) {
        const containerType = recordID ? "response" : "request";
        this.#ticketDataContainers.each((_, container) => {
            const currContainerType = $(container).data("container-type");
            if (currContainerType === containerType) $(container).removeClass("hide-element");
            else $(container).remove();
        });
    }

    setResponseContainerHeight(recordID) {
        // Guard clause: is is 0.
        if (!recordID) return;

        const containerHeight = parseFloat(this.#ticketContentContainer.css("height"));

        const innerElementsHeightTotal = [
            this.#ticketContentContainerHeader,
            this.#ticketImagesContainerHeader,
            this.#ticketContentContainerFooter,
        ].reduce((total, element) => {
            return total + parseFloat($(element).css("height"));
        }, 0);

        const elementHeightDifference = containerHeight - innerElementsHeightTotal;

        this.#ticketImagesList.css("height", `calc(${elementHeightDifference}px - 48px - 16px)`);
    }

    setImageContainerHeight(recordID) {
        // Guard clause: is is 0.
        if (!recordID) return;

        const containerHeight = parseFloat(this.#ticketContentContainer.css("height"));

        const innerElementsHeightTotal = [
            this.#ticketContentContainerHeader,
            this.#ticketContentContainerFooter,
        ].reduce((total, element) => {
            return total + parseFloat($(element).css("height"));
        }, 0);

        const elementHeightDifference = containerHeight - innerElementsHeightTotal;

        this.#scrollableResponsesContainer.css("height", `calc(${elementHeightDifference}px - 48px)`);
    }

    toggleNoneResponsesContainer() {
        this.#noneResponsesData.toggleClass("hide-none-responses");
    }

    toggleNoneImagesContainer() {
        this.#noneImagesData.toggleClass("hide-none-images");
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
