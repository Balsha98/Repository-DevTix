import Model from "./model.js";

class SignupModel extends Model {
    _state = {
        step: 1,
        isValid: false,
        progress: [0, 50, 100],
        css: [
            { opacity: ["full", "none"], translateX: [0, 0] },
            { opacity: ["none", "full"], translateX: [-100, -100] },
        ],
    };
}

export default new SignupModel();
