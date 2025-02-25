export default class Model {
    _state = {};

    getStateVal(key) {
        return this._state[key];
    }

    setStateVal(key, value) {
        this._state[key] = value;
    }
}
