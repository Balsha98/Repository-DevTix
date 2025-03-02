class WelcomeView {
    #heroContent = $(".div-hero-content-container");
    #navLinks = $(".nav-link");
    #btnsDropdown = $(".btn-dropdown");

    constructor() {
        setTimeout(() => this.#heroContent.removeClass("hide-hero-content"), 1000);
    }

    addEventToggleNavLinks(handlerFunction) {
        this.#navLinks.each((_, link) => {
            $(link).click(handlerFunction);
        });
    }

    resetNavLinks() {
        this.#navLinks.each((_, link) => {
            if ($(link).hasClass("active-nav-link")) {
                $(link).removeClass("active-nav-link");
            }
        });
    }

    addEventToggleDropdown(handlerFunction) {
        this.#btnsDropdown.each((_, btn) => {
            $(btn).click(handlerFunction);
        });
    }
}

export default new WelcomeView();
