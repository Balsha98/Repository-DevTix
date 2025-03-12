class PageLoaderView {
    #pageLoaderContainer = $(".div-page-loader-container");

    hidePageLoaderContainer(seconds) {
        setTimeout(() => this.#pageLoaderContainer.addClass("hide-page-loader"), seconds * 1000);
    }
}

export default new PageLoaderView();
