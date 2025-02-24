import alertView from "./../views/alertView.js";

const controlAlert = function (response) {
    alertView.displayVisuals(response);
    alertView.toggleAlert();
};

export const initContoller = function (response) {
    alertView.addEventToggleAlert(controlAlert, response);
};
