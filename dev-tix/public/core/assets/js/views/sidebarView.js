class SidebarView {
    #btnsMenu = $(".btn-sidebar-menu");
    #btnsSidebarDropdown = $(".btn-sidebar-dropdown");
    #btnSidebarLogout = $(".btn-sidebar-logout");

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

    addEventToggleLogoutModal(handlerFunction) {
        this.#btnSidebarLogout.click(handlerFunction);
    }
}

export default new SidebarView();
