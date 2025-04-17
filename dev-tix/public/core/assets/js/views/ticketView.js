class TicketView {
    #ticketContentContainer = $(".div-ticket-content-container");
    #ticketContentContainerHeader = $(".ticket-container-header");
    #btnPostRequest = $(".btn-post-request");
    #btnsAlterRequest = $(".btn-alter-request");
    #btnPostResponse = $(".btn-post-response");
    #spanTicketID = $(".span-ticket-id");
    #ticketDataContainers = $(".div-ticket-data-container");
    #responseModalContainer = $(".div-response-modal-container");
    #scrollableResponsesContainer = $(".div-scrollable-responses-container");
    #ticketImagesContainerHeader = $(".ticket-images-container-header");
    #ticketImagesList = $(".ticket-images-list");
    #ticketImagesListItems = $(".ticket-images-list-item");
    #ticketSelectType = $(".ticket-select-type");
    #textareaInputs = $("textarea");
    #btnUploadImage = $(".btn-upload-image");
    #spanImagesLeft = $(".span-images-left");
    #btnsToggleResponseModal = $(".btn-toggle-response-modal");
    #noneResponsesData = $(".div-none-responses-container");
    #noneImagesData = $(".div-none-images-container");
    #ticketImages = $(".ticket-image");
    #spanTicketView = $(".span-ticket-view");
    #ticketContentContainerFooter = $(".ticket-container-footer");

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
            this.#ticketContentContainerFooter,
        ].reduce((total, element) => {
            return total + parseFloat($(element).css("height"));
        }, 0);

        const elementHeightDifference = containerHeight - innerElementsHeightTotal - 48;
        this.#scrollableResponsesContainer.css("height", `${elementHeightDifference}px`);
    }

    setImageContainerHeight(recordID) {
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

        if (this.#ticketImagesListItems.length > 1) {
            this.#ticketImagesList.css("padding-right", "12px");
            this.#ticketImagesList.css("overflow-y", "scroll");
        }

        const elementHeightDifference = containerHeight - innerElementsHeightTotal - 64;
        this.#ticketImagesList.css("height", `${elementHeightDifference}px`);
    }

    toggleResponseModal() {
        this.#responseModalContainer.toggleClass("hide-response-modal");
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

    checkCharacterLimit(charactersLimit) {
        setInterval(() => {
            this.#textareaInputs.each((_, textarea) => {
                const textareaID = $(textarea).attr("id");
                const writtenCharacters = $(textarea).val().split("").length;
                $(`.${textareaID}-limit`).css("color", "var(--gray-shade)");

                // Guard clause: character limit reached.
                if (writtenCharacters > charactersLimit) return $(`.${textareaID}-limit`).css("color", "var(--error)");

                $(`.${textareaID}-written`).text(writtenCharacters);
            });
        }, 100);
    }

    generateImageInput(imageID) {
        return `
            <li class="form-upload-image-inputs-list-item" data-image-id="${imageID}">
                <label class="absolute-y-center input-image-label flex-center" for="image_${imageID}">
                    <ion-icon src="/core/assets/media/icons/image.svg"></ion-icon>
                </label>
                <div class="div-input-image-container">
                    <input id="image_name_${imageID}" class="input-image-name" type="text" name="image_name" placeholder="Image Name" readonly>
                    <label class="btn btn-primary btn-upload-image" for="image_${imageID}" role="button">Upload</label>
                    <input id="image_${imageID}" class="input-image" type="file" name="image">
                </div>
            </li>
        `;
    }

    setSpanImagesLeft(imagesLeft) {
        this.#spanImagesLeft.text(imagesLeft);
    }

    setSpanTicketView(viewType) {
        this.#spanTicketView.text(viewType[0].toUpperCase() + viewType.slice(1));
    }

    addEventPostRequest(handlerFunction) {
        this.#btnPostRequest?.click(handlerFunction);
    }

    addEventPostResponse(handlerFunction) {
        this.#btnPostResponse?.click(handlerFunction);
    }

    addEventAlterRequest(handlerFunction) {
        this.#btnsAlterRequest.each((_, btn) => {
            $(btn)?.click(handlerFunction);
        });
    }

    addEventSelectTicketType(handlerFunction) {
        this.#ticketSelectType?.change(handlerFunction);
    }

    addEventGenerateImageInput(handlerFunction) {
        this.#btnUploadImage?.click(handlerFunction);
    }

    addEventToggleResponseModal(handlerFunction) {
        this.#btnsToggleResponseModal.each((_, btn) => {
            $(btn)?.click(handlerFunction);
        });
    }

    addEventToggleImageModal(handlerFunction) {
        this.#ticketImages.each((_, image) => {
            $(image)?.click(handlerFunction);
        });
    }
}

export default new TicketView();
