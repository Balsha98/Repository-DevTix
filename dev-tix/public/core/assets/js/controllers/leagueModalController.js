import leagueModalView from "../views/leagueModalView.js";

export const controlToggleLeagueModal = function () {
    leagueModalView.toggleLeagueModal();
};

const initController = function () {
    leagueModalView.addEventToggleLeagueModal(controlToggleLeagueModal);
};

initController();
