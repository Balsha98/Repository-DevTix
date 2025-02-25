class LoginView {
    #requiredInputs = $("input[required]");
    #btnLogin = $(".btn-login");

    addEventUserLogin(handlerFunction) {
        this.#btnLogin.click(handlerFunction);
    }

    addEventResetInput(handlerFunction) {
        this.#requiredInputs.each((_, input) => {
            $(input).click(handlerFunction);
        });
    }
}

export default new LoginView();
