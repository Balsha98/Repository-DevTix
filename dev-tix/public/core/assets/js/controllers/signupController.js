import { isInputEmpty } from "./../helpers/validate.js";
import { handleRequest } from "./../helpers/request.js";
import * as pageLoaderController from "./pageLoaderController.js";
import signupModel from "./../models/signupModel.js";
import signupView from "./../views/signupView.js";

const controlResetInputs = function () {
    const parent = $(this.closest(".div-input-container"));
    if (parent.hasClass("invalid-input-container")) {
        parent.removeClass("invalid-input-container");
    }
};

const controlSwitchStepContainer = function () {
    signupModel.setStateVal("step", +$(this).data("step"));
    const step = signupModel.getStateVal("step");

    if (signupView.isInputEmpty(isInputEmpty, step - 1)) return;

    // SSwitch input containers.
    signupView.setActiveStepContainer(step, signupModel.getStateVal("css")[step - 1]);

    // Switch top step indicators.
    signupView.setActiveStepIndicatorHeader(step);
    signupView.incrementProgress(signupModel.getStateVal("progress")[step - 1]);
    signupView.setActiveStepIndicatorSpan(step);
};

const controlUserSignup = function (formEvent) {
    formEvent.preventDefault();

    // Guard clause: empty inputs.
    if (signupView.isInputEmpty(isInputEmpty, signupModel.getStateVal("step"))) return;

    const form = $(this.closest(".form"));
    const url = form.attr("action");
    const method = form.attr("method");

    const data = {};
    data["first_name"] = $("#first_name").val();
    data["last_name"] = $("#last_name").val();
    data["email"] = $("#email").val();
    data["age"] = $("#age").val();
    data["gender"] = $("#gender").val();
    data["username"] = $("#username").val();
    data["role"] = $("#role").val();
    data["password"] = $("#password").val();
    data["route"] = $("#view").val();

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
    pageLoaderController.controlHidePageLoader(1);

    // Setup signup view.
    signupView.addEventResetInput(controlResetInputs);
    signupView.addEvenSwitchStepContainer(controlSwitchStepContainer);
    signupView.addEventUserSignup(controlUserSignup);
};

initController();
