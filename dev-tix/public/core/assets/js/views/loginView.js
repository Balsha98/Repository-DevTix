class LoginView {
    #btnLogin = $(".btn-login");

    addEventUserLogin(handlerFunction) {
        this.#btnLogin.click(handlerFunction);
    }
}

export default new LoginView();
