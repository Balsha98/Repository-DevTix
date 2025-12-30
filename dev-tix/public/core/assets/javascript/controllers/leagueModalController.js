import leagueModalView from "../views/leagueModalView.js";

export const controlToggleLeagueModal = function () {
    leagueModalView.toggleLeagueModal();
};

const controlSetLeagueModalStatusCircleProgress = function () {
    leagueModalView.setLeagueModalStatusCircleProgress();
};

const controlSetSpanLeagueRank = function () {
    leagueModalView.setSpanLeagueRank();
};

const initController = function () {
    leagueModalView.addEventToggleLeagueModal(controlToggleLeagueModal);

    controlSetLeagueModalStatusCircleProgress();
    controlSetSpanLeagueRank();
};

initController();
