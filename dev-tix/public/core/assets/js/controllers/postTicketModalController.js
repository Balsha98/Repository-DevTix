import postTicketModalView from "./../views/postTicketModalView.js";

export const controlTogglePostTicketModal = function () {
    postTicketModalView.togglePostTicketModal();
};

const initController = function () {
    postTicketModalView.addEventTogglePostTicketModal(controlTogglePostTicketModal);
};

initController();
