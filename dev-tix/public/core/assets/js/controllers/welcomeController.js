import welcomeModel from "./../models/welcomeModel.js";
import welcomeView from "./../views/welcomeView.js";

const controlToggleNav = function () {
    welcomeView.resetNavLinks();
    $(this).addClass("active-nav-link");
};

const controlToggleDropdown = function () {
    $(this).toggleClass("active-btn-dropdown");

    const container = $(this.closest(".dropdown-container"));
    const containerClass = container.attr("class").split(" ")[1];
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

const initController = function () {
    welcomeView.addEventToggleNavLinks(controlToggleNav);
    welcomeView.addEventToggleDropdown(controlToggleDropdown);
    welcomeView.addEventTurnCarouselByBtn(controlTurnCarouselByBtn);
    welcomeView.addEventTurnCarouselBySpan(controlTurnCarouselBySpan);
    welcomeView.addEventToTopBtn(controlToTopBtn);
};

initController();
