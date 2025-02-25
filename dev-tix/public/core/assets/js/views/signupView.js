class SignUpView {
    #divIndicators = $(".div-step-indicator");
    #spanIndicators = $(".span-circle-indicator");
    #stepContainers = $(".div-form-step-container");
    #divProgress = $(".div-progress");
    #btnsStep = $(".btn-step");
    #btnSignup = $(".btn-signup");

    isInputEmpty(handlerFunction, step) {
        const clName = `.step-validate-${step}`;
        return handlerFunction(true, clName);
    }

    addEvenSwitchStepContainer(handlerFunction) {
        this.#btnsStep.each((_, btn) => {
            $(btn).click(handlerFunction);
        });
    }

    setActiveStepContainer(css) {
        this.#stepContainers.each((i, div) => {
            $(div).css("transform", `translateX(calc(${css["translateX"][i]}%))`);
            $(div).css("opacity", `var(--opacity-${css["opacity"][i]})`);
        });
    }

    setActiveStepIndicatorHeader(step) {
        this.#divIndicators.each((_, div) => {
            if (+$(div).data("step") <= step) {
                $(div).addClass("active-header-indicator");
            } else {
                $(div).removeClass("active-header-indicator");
            }
        });
    }

    incrementProgress(progress) {
        this.#divProgress.css("width", `${progress}%`);
    }

    setActiveStepIndicatorSpan(step) {
        this.#spanIndicators.each((_, span) => {
            if (+$(span).data("step") <= step) {
                $(span).addClass("active-span-indicator");
            } else {
                $(span).removeClass("active-span-indicator");
            }
        });
    }

    addEventUserSignup(handlerFunction) {
        this.#btnSignup.click(handlerFunction);
    }
}

export default new SignUpView();
