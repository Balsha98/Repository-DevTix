export const controlToggleDropdown = function () {
    $(this).toggleClass("active-btn-icon");

    const container = $(this.closest(".dropdown-container"));
    const containerClass = container.attr("class").split(" ")[1];
    $(`.${containerClass} .dropdown-menu`).toggleClass("hide-dropdown");
};
