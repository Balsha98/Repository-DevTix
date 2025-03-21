import alertModalModel from "../models/alertModalModel.js";
import alertModalView from "../views/alertModalView.js";

const controlAlertModal = function (response) {
    alertModalModel.setStateVal("view", location.pathname.split("/")[1]);
    if (alertModalModel.getStateVal("view") === "signup") {
        alertModalModel.addLocalStorageItem("isValid", response["status"] === "success" ? 1 : 0);
    }

    alertModalView.displayModalVisuals(response);
    alertModalView.toggleAlertModal();
};

export const initController = function (response) {
    alertModalView.addEventToggleAlertModal(controlAlertModal, response);
};
