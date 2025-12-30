import { isInputEmpty } from "./../helpers/validate.js";
import { handleRequest } from "./../helpers/request.js";
import * as pageLoaderController from "./pageLoaderController.js";
import loginView from "./../views/loginView.js";

const controlResetInputs = function () {
    const parent = $(this.closest(".div-input-container"));
    if (parent.hasClass("invalid-input-container")) {
        parent.removeClass("invalid-input-container");
    }
};

const controlUserLogin = function (formEvent) {
    formEvent.preventDefault();

    if (isInputEmpty()) return;

    const form = $(this.closest(".form"));
    const url = form.attr("action");
    const method = form.attr("method");

    const data = {};
    data["route"] = $("#view").val();
    data["username"] = $("#username").val();
    data["password"] = $("#password").val();
    data["csrf_token"] = $("#csrf_token").val();

    handleRequest(url, method, data);
};

const initController = function () {
    pageLoaderController.controlHidePageLoader(1);

    // Setup login view.
    loginView.addEventResetInput(controlResetInputs);
    loginView.addEventUserLogin(controlUserLogin);
};

initController();
