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

const initController = function () {
    welcomeView.addEventToggleNavLinks(controlToggleNav);
    welcomeView.addEventToggleDropdown(controlToggleDropdown);
};

initController();
