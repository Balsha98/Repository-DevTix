import alertModel from "./../models/alertModel.js";
import alertView from "./../views/alertView.js";

const controlAlert = function (response) {
    alertModel.setStateVal("page", location.pathname.split("/")[1]);
    if (alertModel.getStateVal("page") === "signup") {
        alertModel.addLocalStorageItem("isValid", response["status"] === "success" ? 1 : 0);
    }

    alertView.displayVisuals(response);
    alertView.toggleAlert();
};

export const initContoller = function (response) {
    alertView.addEventToggleAlert(controlAlert, response);
};
