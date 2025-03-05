class WelcomeView {
    #pageHeader = $(".page-header");
    #sectionHero = $(".section-hero");
    #heroContent = $(".div-hero-content-container");
    #navLinks = $(".nav-link");
    #btnsDropdown = $(".btn-dropdown");
    #contentSections = $(".section-content");
    #testimonialItems = $(".testimonials-list-item");
    #btnsStep = $(".btn-testimonials-step");
    #spanIndicators = $(".span-indicator");
    #btnToTopContainer = $(".div-to-top-btn-container");
    #btnToTop = $(".btn-to-top");

    constructor() {
        setTimeout(() => this.#heroContent.removeClass("hide-hero-content"), 200);
        this.#observeHeroSection();
        this.#observeContentSections();
    }

    #observeHeroSection() {
        const observer = new IntersectionObserver(
            (entry) => {
                const [{ isIntersecting }] = entry;

                if (!isIntersecting) {
                    this.#pageHeader.addClass("fixed-header");
                    this.#btnToTopContainer.removeClass("hide-to-top-btn");
                    return;
                }

                this.#pageHeader.removeClass("fixed-header");
                this.#btnToTopContainer.addClass("hide-to-top-btn");
            },
            { root: null, rootMargin: "-80px", threshold: 0 }
        );

        const [heroElement] = this.#sectionHero;
        observer.observe(heroElement);
    }

    #observeContentSections() {
        const observer = new IntersectionObserver(
            (entry, observer) => {
                const [{ target, isIntersecting }] = entry;

                if (isIntersecting) {
                    $(target).removeClass("hide-section");
                    observer.unobserve(target);
                }
            },
            { root: null, threshold: 0.5 }
        );

        this.#contentSections.each((_, section) => {
            observer.observe(section);
        });
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

    addEventToTopBtn(handlerFunction) {
        this.#btnToTop.click(handlerFunction);
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
