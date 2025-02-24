import { handleRequest } from "../helpers/request.js";
import signupModel from "./../models/signupModel.js";
import signupView from "../views/signupView.js";

const controlSwitchStepContainer = function () {};

const controlUserSignup = function (formEvent) {
    formEvent.preventDefault();

    const form = $(this.closest(".form"));
    const url = form.attr("action");
    const method = form.attr("method");

    const data = {};
    data["first_name"] = $("#first_name").val();
    data["last_name"] = $("#last_name").val();
    data["email"] = $("#email").val();
    data["password"] = $("#password").val();
    data["page"] = $("#page").val();

    handleRequest(url, method, data);
};

const initController = function () {
    signupView.addEvenSwitchStepContainer(controlSwitchStepContainer);
    signupView.addEventUserSignup(controlUserSignup);
};

initController();
