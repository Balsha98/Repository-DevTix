class SignupView {
    #divIndicators = $(".div-step-indicator");
    #spanIndicators = $(".span-circle-indicator");
    #stepContainers = $(".div-form-step-container");
    #divProgress = $(".div-progress");
    #requiredInputs = $("*[required]");
    #btnsStep = $(".btn-step");
    #btnSignup = $(".btn-signup");

    isInputEmpty(handlerFunction, step) {
        const clName = `.step-validate-${step}`;
        return handlerFunction(true, clName);
    }

    addEventResetInput(handlerFunction) {
        this.#requiredInputs.each((_, input) => {
            $(input).click(handlerFunction);
        });
    }

    addEvenSwitchStepContainer(handlerFunction) {
        this.#btnsStep.each((_, btn) => {
            $(btn).click(handlerFunction);
        });
    }

    addEventUserSignup(handlerFunction) {
        this.#btnSignup.click(handlerFunction);
    }

    setActiveStepContainer(step, css) {
        this.#stepContainers.each((i, div) => {
            $(div).css("transform", `translateX(${(step - 1) * -100}%)`);
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
}

export default new SignupView();
