class DataLoaderView {
    #dataLoaderContainer = $(".div-data-loader-container");

    hideDataLoaderContainer(seconds) {
        setTimeout(() => this.#dataLoaderContainer.addClass("hide-data-loader"), seconds * 1000);
    }

    showDataLoaderContainer() {
        this.#dataLoaderContainer.removeClass("hide-data-loader");
    }
}

export default new DataLoaderView();
