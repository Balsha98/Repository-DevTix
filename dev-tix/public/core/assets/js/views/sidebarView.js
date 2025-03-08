class SidebarView {
    #btnsMenu = $(".btn-sidebar-menu");

    addEventToggleSidebar(handlerFunction) {
        this.#btnsMenu.each((_, btn) => {
            $(btn).click(handlerFunction);
        });
    }
}

export default new SidebarView();
