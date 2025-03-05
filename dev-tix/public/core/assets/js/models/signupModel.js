import Model from "./model.js";

class SignupModel extends Model {
    _state = {
        step: 1,
        isValid: false,
        progress: [0, 50, 100],
        css: [{ opacity: ["full", "none"] }, { opacity: ["none", "full"] }],
    };
}

export default new SignupModel();
