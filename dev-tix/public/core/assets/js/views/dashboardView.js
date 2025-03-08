class DashboardView {
    #btnsIcon = $(".btn-nav-icon");

    addEventToggleDropdown(handlerFunction) {
        this.#btnsIcon.each((_, btn) => {
            $(btn).click(handlerFunction);
        });
    }
}

export default new DashboardView();
