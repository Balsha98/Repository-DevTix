import noneDataView from "./../views/noneDataView.js";

export const controlHideNoneDataContainer = function () {
    noneDataView.hideNoneDataContainer();
};

export const controlShowNoneDataContainer = function (seconds) {
    noneDataView.showNoneDataContainer(seconds);
};
