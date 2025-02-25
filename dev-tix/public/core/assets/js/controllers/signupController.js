import { handleRequest } from "../helpers/request.js";
import signupModel from "./../models/signupModel.js";
import signupView from "../views/signupView.js";

const controlSwitchStepContainer = function () {
    signupModel.setStateVal("step", +$(this).data("step"));
    const step = signupModel.getStateVal("step");

    // SSwitch input containers.
    signupView.setActiveStepContainer(signupModel.getStateVal("css")[step - 1]);

    // Switch top step indicators.
    signupView.setActiveStepIndicatorHeader(step);
    signupView.incrementProgress(signupModel.getStateVal("progress")[step - 1]);
    signupView.setActiveStepIndicatorSpan(step);
};

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

    // Wait for response.
    setTimeout(() => {
        const isValid = +localStorage.getItem("isValid");
        signupModel.setStateVal("step", +$(this).data("step"));
        const step = signupModel.getStateVal("step");

        if (isValid) {
            signupView.incrementProgress(signupModel.getStateVal("progress")[step - 1]);
            signupView.setActiveStepIndicatorSpan(step);
        }

        localStorage.clear();
    }, 200);
};

const initController = function () {
    signupView.addEvenSwitchStepContainer(controlSwitchStepContainer);
    signupView.addEventUserSignup(controlUserSignup);
};

initController();
