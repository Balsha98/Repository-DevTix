import Model from "./model.js";

class ProfileModel extends Model {
    _state = {
        bioLimit: 250,
    };
}

export default new ProfileModel();
