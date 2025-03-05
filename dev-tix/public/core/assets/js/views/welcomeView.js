class WelcomeView {
    #heroContent = $(".div-hero-content-container");
    #navLinks = $(".nav-link");
    #btnsDropdown = $(".btn-dropdown");
    #testimonialItems = $(".testimonials-list-item");
    #btnsStep = $(".btn-testimonials-step");
    #spanIndicators = $(".span-indicator");

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

    addEventTurnCarouselByBtn(handlerFunction) {
        this.#btnsStep.each((_, btn) => {
            $(btn).click(handlerFunction);
        });
    }

    addEventTurnCarouselBySpan(handlerFunction) {
        this.#spanIndicators.each((_, span) => {
            $(span).click(handlerFunction);
        });
    }

    turnTestimonialItems(id) {
        this.#testimonialItems.each((_, item) => {
            if (+$(item).data("testimonial-id") === id) {
                $(item).addClass("active-testimonial");
            }

            $(item).css("transform", `translateX(${(id - 1) * -105}%)`);
        });
    }

    turnSpanIndicators(id) {
        this.#spanIndicators.each((_, span) => {
            const parent = $(span.closest("li"));
            if (+parent.data("testimonial-id") === id) {
                $(span).addClass("active-span-indicator");
            }
        });
    }

    resetCarouselIndicators() {
        this.#resetTestimonialItems();
        this.#resetSpanIndicators();
    }

    #resetTestimonialItems() {
        this.#testimonialItems.each((_, item) => {
            if ($(item).hasClass("active-testimonial")) {
                $(item).removeClass("active-testimonial");
            }
        });
    }

    #resetSpanIndicators() {
        this.#spanIndicators.each((_, span) => {
            if ($(span).hasClass("active-span-indicator")) {
                $(span).removeClass("active-span-indicator");
            }
        });
    }
}

export default new WelcomeView();
