class SignUpView {
    #stepContainers = $(".div-form-step-container");
    #btnsStep = $(".btn-step");
    #btnSignup = $(".btn-signup");

    addEvenSwitchStepContainer(handlerFunction) {
        this.#btnsStep.each((_, btn) => {
            $(btn).click(handlerFunction);
        });
    }

    addEventUserSignup(handlerFunction) {
        this.#btnSignup.click(handlerFunction);
    }
}

export default new SignUpView();
