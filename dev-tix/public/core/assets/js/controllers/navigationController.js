import { redirectTo } from "./../helpers/redirect.js";
import navigationView from "./../views/navigationView.js";

export const controlToggleDropdown = function () {
    $(this).toggleClass("active-btn-icon");

    const container = $(this.closest(".dropdown-container"));
    const containerClass = container.attr("class").split(" ")[1];
    $(`.${containerClass} .dropdown-menu`).toggleClass("hide-dropdown");
};

export const controlViewNotificationDetails = function () {
    redirectTo($(this).data("href"));
};

export const controlGenerateNotificationsList = function () {
    const route = $("#partial").val();
    const url = `/api/?route=${route}`;
    const method = "GET";

    $.ajax({
        url: url,
        method: method,
        success: function (response) {
            console.log("NAVIGATION", response);

            // Render notification list items.
            navigationView.generateNotificationsList(response["response"]["data"]);
            navigationView.addEventViewNotificationDetails(controlViewNotificationDetails);
        },
    });
};
