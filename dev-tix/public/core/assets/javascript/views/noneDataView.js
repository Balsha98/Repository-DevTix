class NoneDataView {
    #noneDataContainer = $(".div-none-data-container");

    showNoneDataContainer(seconds) {
        setTimeout(() => this.#noneDataContainer.removeClass("hide-none-data"), seconds * 1000);
    }

    hideNoneDataContainer() {
        this.#noneDataContainer.addClass("hide-none-data");
    }
}

export default new NoneDataView();
