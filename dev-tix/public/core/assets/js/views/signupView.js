class SignUpView {
    #btnSignup = $(".btn-signup");

    addEventUserSignup(handlerFunction) {
        this.#btnSignup.click(handlerFunction);
    }
}

export default new SignUpView();
