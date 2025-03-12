import { isInputEmpty } from "./../helpers/validate.js";
import { handleRequest } from "./../helpers/request.js";
import { controlHidePageLoader } from "./pageLoaderController.js";
import loginView from "./../views/loginView.js";

const controlResetInputs = function () {
    const parent = $(this.closest(".div-input-container"));
    if (parent.hasClass("invalid-input-container")) {
        parent.removeClass("invalid-input-container");
    }
};

const controlUserLogin = function (formEvent) {
    formEvent.preventDefault();

    const form = $(this.closest(".form"));
    const url = form.attr("action");
    const method = form.attr("method");

    const data = {};
    data["username"] = $("#username").val();
    data["password"] = $("#password").val();
    data["route"] = $("#view").val();

    if (isInputEmpty()) return;

    handleRequest(url, method, data);
};

const initController = function () {
    controlHidePageLoader(1);

    loginView.addEventResetInput(controlResetInputs);
    loginView.addEventUserLogin(controlUserLogin);
};

initController();
