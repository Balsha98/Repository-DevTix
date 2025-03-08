export const controlToggleSidebar = function () {
    const sidebar = $(this.closest(".div-sidebar-container"));
    const sidebarContainers = $(".div-sidebar-container > div");

    sidebarContainers.each((_, div) => {
        if ($(div).hasClass("collapse-sidebar")) {
            $(div).removeClass("collapse-sidebar");
            sidebar.css("width", $(div).css("width"));
        } else $(div).addClass("collapse-sidebar");
    });
};

export const controlToggleSidebarDropdown = function () {
    const parent = $(this.closest("li"));
    const parentClass = parent.attr("class").split(" ")[1];
    $(`.${parentClass} .sidebar-links-list`).toggleClass("hide-element");
    $(`.${parentClass} button ion-icon`).toggleClass("rotate-chevron-to-right");
};
