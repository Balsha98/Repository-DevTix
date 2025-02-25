class SignupModel {
    #state = {
        step: 1,
        isValid: false,
        progress: [0, 50, 100],
        css: [
            { opacity: ["full", "none"], translateX: [0, 0] },
            { opacity: ["none", "full"], translateX: [-100, -100] },
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
