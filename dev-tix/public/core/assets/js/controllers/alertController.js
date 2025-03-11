import alertModel from "./../models/alertModel.js";
import alertView from "./../views/alertView.js";

const controlAlert = function (response) {
    alertModel.setStateVal("view", location.pathname.split("/")[1]);
    if (alertModel.getStateVal("view") === "signup") {
        alertModel.addLocalStorageItem("isValid", response["status"] === "success" ? 1 : 0);
    }

    alertView.displayVisuals(response);
    alertView.toggleAlert();
};

export const initController = function (response) {
    alertView.addEventToggleAlert(controlAlert, response);
};
