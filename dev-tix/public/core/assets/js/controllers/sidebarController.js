export const controlToggleSidebar = function () {
    const sidebar = $(this.closest(".div-sidebar-container"));
    const sidebarContainers = $(".div-sidebar-container > div");
    const mainContainerDiv = $(".div-main-container");

    sidebarContainers.each((_, div) => {
        if ($(div).hasClass("collapse-sidebar")) {
            $(div).removeClass("collapse-sidebar");

            const width = $(div).css("width");
            mainContainerDiv.css("max-width", `calc(100% - ${width})`);
            sidebar.css("width", width);
        } else $(div).addClass("collapse-sidebar");
    });
};

export const controlToggleSidebarDropdown = function () {
    const parent = $(this.closest("li"));
    const parentClass = parent.attr("class").split(" ")[1];
    $(`.${parentClass} .sidebar-links-list`).toggleClass("hide-element");
    $(`.${parentClass} button ion-icon`).toggleClass("rotate-chevron-to-right");
};
