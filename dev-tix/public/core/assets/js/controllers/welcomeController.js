import { isInputEmpty } from "./../helpers/validate.js";
import { handleRequest } from "./../helpers/request.js";
import * as pageLoaderController from "./pageLoaderController.js";
import welcomeModel from "./../models/welcomeModel.js";
import welcomeView from "./../views/welcomeView.js";

const controlToggleNav = function () {
    welcomeView.resetNavLinks();
    $(this).addClass("active-nav-link");
};

const controlToggleDropdown = function () {
    const containerClass = $(this).attr("class").split(" ")[1];
    $(`.${containerClass} .btn`).toggleClass("active-btn-dropdown");
    $(`.${containerClass} .dropdown-menu`).toggleClass("hide-dropdown");
};

const controlTurnCarouselByBtn = function () {
    let testimonialID = welcomeModel.getStateVal("testimonialID");

    // Check direction.
    if ($(this).data("direction") === "prev") {
        if (--testimonialID <= 0) return;
    } else {
        if (testimonialID++ >= 5) return;
    }

    welcomeView.resetCarouselIndicators();
    welcomeView.turnTestimonialItems(testimonialID);
    welcomeView.turnSpanIndicators(testimonialID);

    welcomeModel.setStateVal("testimonialID", testimonialID);
};

const controlTurnCarouselBySpan = function () {
    const parent = $(this.closest("li"));
    const testimonialID = +parent.data("testimonial-id");

    welcomeView.resetCarouselIndicators();
    welcomeView.turnTestimonialItems(testimonialID);
    welcomeView.turnSpanIndicators(testimonialID);

    welcomeModel.setStateVal("testimonialID", testimonialID);
};

const controlToTopBtn = function () {
    welcomeView.resetNavLinks();
    window.scrollTo(0, 0);
};

const controlResetInputs = function () {
    const parent = $(this.closest(".div-input-container"));
    if (parent.hasClass("invalid-input-container")) {
        parent.removeClass("invalid-input-container");
    }
};

const controlNewsletterSubmit = function (formEvent) {
    formEvent.preventDefault();

    if (isInputEmpty()) return;

    const form = $(this.closest(".form"));
    const url = form.attr("action");
    const method = form.attr("method");

    const data = {};
    data["email"] = $("#email").val();
    data["route"] = $("#route").val();

    handleRequest(url, method, data);
};

const initController = function () {
    pageLoaderController.controlHidePageLoader(2);

    // Setup welcome view.
    welcomeView.addEventToggleNavLinks(controlToggleNav);
    welcomeView.addEventToggleDropdown(controlToggleDropdown);
    welcomeView.addEventTurnCarouselByBtn(controlTurnCarouselByBtn);
    welcomeView.addEventTurnCarouselBySpan(controlTurnCarouselBySpan);
    welcomeView.addEventToTopBtn(controlToTopBtn);
    welcomeView.addEventResetInput(controlResetInputs);
    welcomeView.addEventNewsletterSubmit(controlNewsletterSubmit);
};

initController();
