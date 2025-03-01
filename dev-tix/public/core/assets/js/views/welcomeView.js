class WelcomeView {
    #navLinks = $(".nav-link");
    #btnsDropdown = $(".btn-dropdown");

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
