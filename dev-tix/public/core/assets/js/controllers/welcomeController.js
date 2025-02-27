import welcomeView from "./../views/welcomeView.js";

const controlToggleNav = function () {
    welcomeView.resetNavLinks();

    if ($(this).hasClass("dropdown-container")) {
        return welcomeView.toggleDropdrownMenu(this);
    }

    $(".dropdown-container").each((_, item) => {
        const itemClass = $(item).attr("class").split(" ")[2];
        $(`.${itemClass} .dropdown-menu-list`).addClass("hide-dropdown");
    });

    $(this.querySelector(".nav-link")).addClass("active-nav-link");
};

const initController = function () {
    welcomeView.addEventToggleNavLinks(controlToggleNav);
};

initController();
