class WelcomeView {
    #navListItems = $(".nav-list-item");

    addEventToggleNavLinks(handlerFunction) {
        this.#navListItems.each((_, item) => {
            $(item).click(handlerFunction);
        });
    }

    resetNavLinks() {
        this.#navListItems.each((_, item) => {
            if ($(item).hasClass("dropdown-container")) {
                $(item.querySelector(".btn-dropdown")).removeClass("active-btn-dropdown");
            } else $(item.querySelector(".nav-link")).removeClass("active-nav-link");
        });
    }

    toggleDropdrownMenu(container) {
        const containerClass = $(container).attr("class").split(" ")[2];
        $(`.${containerClass} .btn-dropdown`).toggleClass("active-btn-dropdown");
        $(`.${containerClass} .dropdown-menu-list`).toggleClass("hide-dropdown");
    }
}

export default new WelcomeView();
