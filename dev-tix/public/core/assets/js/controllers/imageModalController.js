import imageModalView from "./../views/imageModalView.js";

const controlBtnToggleImageModal = function () {
    imageModalView.toggleImageModal();
};

export const controlToggleImageModal = function (imageSrc) {
    imageModalView.setModalImageSource(imageSrc);
    imageModalView.toggleImageModal();
};

const initController = function () {
    imageModalView.addEventToggleImageModal(controlBtnToggleImageModal);
};

initController();
