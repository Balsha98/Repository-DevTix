class DataLoaderView {
    hideDataLoaderContainer(parentContainer, seconds) {
        setTimeout(() => {
            $(`.${parentContainer} .div-data-loader-container`).addClass("hide-data-loader");
        }, seconds * 1000);
    }

    showDataLoaderContainer(parentContainer) {
        $(`.${parentContainer} .div-data-loader-container`).removeClass("hide-data-loader");
    }
}

export default new DataLoaderView();
