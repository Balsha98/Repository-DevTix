import resolveTicketModalView from "../views/resolveTicketModalView.js";

export const controlToggleResolveTicketModal = function () {
    resolveTicketModalView.toggleResolveTicketModal();
};

const initController = function () {
    resolveTicketModalView.addEventToggleResolveTicketModal(controlToggleResolveTicketModal);
};

initController();
