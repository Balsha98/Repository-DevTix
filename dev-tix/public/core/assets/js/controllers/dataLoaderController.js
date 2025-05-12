import dataLoaderView from "./../views/dataLoaderView.js";

export const controlHideDataLoader = function (parentContainer, seconds) {
    dataLoaderView.hideDataLoaderContainer(parentContainer, seconds);
};

export const controlShowDataLoader = function (parentContainer) {
    dataLoaderView.showDataLoaderContainer(parentContainer);
};
