export const controlToggleSidebar = function () {
    $(".div-sidebar-container").toggleClass("collapse-sidebar");
    $(".sidebar-overlay").toggleClass("hide-sidebar-overlay");
};

export const controlToggleSidebarDropdown = function () {
    const parent = $(this.closest("li"));
    const parentClass = parent.attr("class").split(" ")[1];
    $(`.${parentClass} .sidebar-links-list`).toggleClass("hide-element");
    $(`.${parentClass} button ion-icon`).toggleClass("rotate-chevron-to-right");
};
