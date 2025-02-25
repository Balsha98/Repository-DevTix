import { isInputEmpty } from "./../helpers/validate.js";
import { handleRequest } from "./../helpers/request.js";
import loginView from "./../views/loginView.js";

const controlResetInputs = function () {
    const parent = $(this.closest(".div-input-container"));
    if (parent.hasClass("empty-input-container")) {
        parent.removeClass("empty-input-container");
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
    data["page"] = $("#page").val();

    if (isInputEmpty()) return;

    handleRequest(url, method, data);
};

const initController = function () {
    loginView.addEventResetInput(controlResetInputs);
    loginView.addEventUserLogin(controlUserLogin);
};

initController();
