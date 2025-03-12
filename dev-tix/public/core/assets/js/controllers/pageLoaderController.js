import pageLoaderView from "./../views/pageLoaderView.js";

export const controlHidePageLoader = function (seconds) {
    pageLoaderView.hidePageLoaderContainer(seconds);
};
