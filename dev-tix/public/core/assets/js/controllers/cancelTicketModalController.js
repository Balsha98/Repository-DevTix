import cancelTicketModalView from "./../views/cancelTicketModalView.js";

export const controlToggleCancelTicketModal = function () {
    cancelTicketModalView.toggleCancelTicketModal();
};

const initController = function () {
    cancelTicketModalView.addEventToggleCancelTicketModal(controlToggleCancelTicketModal);
};

initController();
