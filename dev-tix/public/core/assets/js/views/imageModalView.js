class ImageModalView {
    #imageModalContainer = $(".div-image-modal-container");
    #btnCloseModal = $(".btn-close-image-modal");
    #modalImage = $(".modal-image");

    addEventToggleImageModal(handlerFunction) {
        this.#btnCloseModal?.click(handlerFunction);
    }

    toggleImageModal() {
        this.#imageModalContainer.toggleClass("hide-modal");
    }

    setModalImageSource(imageSrc) {
        this.#modalImage.attr("src", imageSrc);
    }
}

export default new ImageModalView();
