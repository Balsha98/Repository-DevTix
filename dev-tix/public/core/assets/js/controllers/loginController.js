import { handleRequest } from "../helpers/request.js";
import loginView from "../views/loginView.js";

const controlUserLogin = function (formEvent) {
    formEvent.preventDefault();

    const form = $(this.closest(".form"));
    const url = form.attr("action");
    const method = form.attr("method");

    const data = {};
    data["username"] = $("#username").val();
    data["password"] = $("#password").val();
    data["page"] = $("#page").val();

    handleRequest(url, method, data);
};

const initController = function () {
    loginView.addEventUserLogin(controlUserLogin);
};

initController();
