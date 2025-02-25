import Model from "./model.js";

class AlertModel extends Model {
    _state = {
        page: "",
        isValid: false,
    };

    addLocalStorageItem(key, value) {
        localStorage.setItem(key, value);
    }
}

export default new AlertModel();
