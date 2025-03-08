import { controlHideLoader } from "./loaderController.js";
import dashboardView from "./../views/dashboardView.js";

const controlToggleDropdown = function () {
    $(this).toggleClass("active-btn-icon");

    const container = $(this.closest(".dropdown-container"));
    const containerClass = container.attr("class").split(" ")[1];
    $(`.${containerClass} .dropdown-menu`).toggleClass("hide-dropdown");
};

const initController = function () {
    controlHideLoader(0.1);

    dashboardView.setWelcomeMessage();
    dashboardView.addEventToggleDropdown(controlToggleDropdown);
};

initController();
