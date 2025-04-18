import logoutModalView from "./../views/logoutModalView.js";

export const controlToggleLogoutModal = function () {
    logoutModalView.toggleLogoutModal();
};

const initController = function () {
    logoutModalView.addEventToggleLogoutModal(controlToggleLogoutModal);
};

initController();
