import { redirectTo } from "./../helpers/redirect.js";
import { handleRequest } from "./../helpers/request.js";
import navigationView from "./../views/navigationView.js";

export const controlToggleDropdown = function () {
    const containerClass = $(this).attr("class").split(" ")[1];
    $(`.${containerClass} .btn-nav-icon`).toggleClass("active-btn-icon");
    $(`.${containerClass} .dropdown-menu`).toggleClass("hide-dropdown");
};

const controlSetViewAsClient = function () {
    const clientID = $(this).data("client-id");
    const form = $(`.client-form-${clientID}`);
    const url = form.attr("action");
    const method = form.attr("method");

    const data = {};
    data["id"] = $("#user_id").val();
    data["client_id"] = $(`#client_id_${clientID}`).val();
    data["route"] = $("#partial").val();
    data["csrf_token"] = $("#csrf_token").val();

    handleRequest(url, method, data);
};

export const controlMarkNotificationsAsRead = function (formEvent) {
    formEvent.preventDefault();

    const form = $(this.closest(".form"));
    const url = form.attr("action");
    const method = form.attr("method");

    const data = {};
    data["id"] = $("#user_id").val();
    data["is_read"] = $("#is_read").val();
    data["route"] = $("#partial").val();
    data["csrf_token"] = $("#csrf_token").val();

    handleRequest(url, method, data);
};

export const controlGenerateNavigationLists = function () {
    const route = $("#partial").val();
    const url = `/api/?route=${route}`;
    const method = "GET";

    $.ajax({
        url: url,
        method: method,
        success: function (response) {
            console.log(route, response);

            const clients = response["response"]["data"]["clients"] ?? null;
            if (clients) {
                navigationView.generateClientsList(clients);
                navigationView.addEventSetViewAsClient(controlSetViewAsClient);
            }

            // Render notification list items.
            navigationView.generateNotificationsList(response["response"]["data"]["notifications"]);
            navigationView.addEventViewNotificationDetails(controlViewNotificationDetails);
        },
        error: function (response) {
            console.log(response.responseText);
        },
    });
};

const controlViewNotificationDetails = function () {
    redirectTo($(this).data("href"));
};
