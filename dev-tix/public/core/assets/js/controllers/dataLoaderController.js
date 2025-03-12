import dataLoaderView from "./../views/dataLoaderView.js";

export const controlHideDataLoader = function (seconds) {
    dataLoaderView.hideDataLoaderContainer(seconds);
};

export const controlShowDataLoader = function () {
    dataLoaderView.showDataLoaderContainer();
};
