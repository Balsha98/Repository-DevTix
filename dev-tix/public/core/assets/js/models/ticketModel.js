import Model from "./model.js";

class TicketModel extends Model {
    _state = {
        currImageID: 1,
        maxNumImages: 5,
    };
}

export default new TicketModel();
