import Model from "./model.js";

class AlertModel extends Model {
    _state = {
        view: "",
        isValid: false,
    };

    addLocalStorageItem(key, value) {
        localStorage.setItem(key, value);
    }
}

export default new AlertModel();
