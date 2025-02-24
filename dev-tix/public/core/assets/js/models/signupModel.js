class SignupModel {
    #state = {
        step: 1,
        xTranslate: [
            [0, 100],
            [-100, 0],
        ],
    };

    getStateValue(key) {
        return this.#state[key];
    }

    setStateValue(key, value) {
        this.#state[key] = value;
    }
}

export default new SignupModel();
