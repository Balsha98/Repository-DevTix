import { redirectTo } from "./../helpers/redirect.js";
import { handleRequest } from "./../helpers/request.js";
import navigationView from "./../views/navigationView.js";

export const controlToggleDropdown = function () {
    const containerClass = $(this).attr("class").split(" ")[1];
    $(`.${containerClass} .btn-nav-icon`).toggleClass("active-btn-icon");
    $(`.${containerClass} .dropdown-menu`).toggleClass("hide-dropdown");
};

export const controlMarkNotificationsAsRead = function (formEvent) {
    formEvent.preventDefault();

    const form = $(this.closest(".form"));
    const url = form.attr("action");
    const method = form.attr("method");

    const data = {};
    data["is_read"] = $("#is_read").val();
    data["route"] = $("#partial").val();

    handleRequest(url, method, data);
};

export const controlGenerateNotificationsList = function () {
    const route = $("#partial").val();
    const url = `/api/?route=${route}`;
    const method = "GET";

    $.ajax({
        url: url,
        method: method,
        success: function (response) {
            console.log(route, response);

            // Render notification list items.
            navigationView.generateNotificationsList(response["response"]["data"]);
            navigationView.addEventViewNotificationDetails(controlViewNotificationDetails);
        },
    });
};

export const controlViewNotificationDetails = function () {
    redirectTo($(this).data("href"));
};
