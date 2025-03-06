class LoaderView {
    #loaderContainer = $(".div-loader-container");

    hideLoaderContainer(seconds) {
        setTimeout(() => this.#loaderContainer.addClass("hide-loader"), seconds * 1000);
    }
}

export default new LoaderView();
