class SidebarView {
    #btnsMenu = $(".btn-sidebar-menu");
    #btnsSidebarDropdown = $(".btn-sidebar-dropdown");

    addEventToggleSidebar(handlerFunction) {
        this.#btnsMenu.each((_, btn) => {
            $(btn).click(handlerFunction);
        });
    }

    addEventToggleSidebarDropdown(handlerFunction) {
        this.#btnsSidebarDropdown.each((_, btn) => {
            $(btn).click(handlerFunction);
        });
    }
}

export default new SidebarView();
