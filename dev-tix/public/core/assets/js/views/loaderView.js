class LoaderView {
    #loaderContainer = $(".div-loader-container");

    hideLoaderContainer() {
        setTimeout(() => this.#loaderContainer.addClass("hide-loader"), 2000);
    }
}

export default new LoaderView();
