import welcomeView from "./../views/welcomeView.js";

const controlToggleNav = function () {
    if ($(this).hasClass("dropdown-container")) {
        return welcomeView.toggleDropdrownMenu(this);
    }

    welcomeView.resetNavLinks();

    $(".dropdown-container").each((_, item) => {
        const itemClass = $(item).attr("class").split(" ")[2];
        $(`.${itemClass} ion-icon`).removeClass("rotate-chevron-down");
        $(`.${itemClass} .dropdown-menu-list`).addClass("hide-dropdown");
    });

    $(this.querySelector(".nav-link")).addClass("active-nav-link");
};

const initController = function () {
    welcomeView.addEventToggleNavLinks(controlToggleNav);
};

initController();
