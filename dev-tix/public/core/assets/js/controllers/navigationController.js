import { handleRequest } from "./../helpers/request.js";
import { getTimeAgo } from "./../helpers/date.js";
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
    data["action"] = "update/client";
    data["id"] = $("#user_id").val();
    data["client_id"] = $(`#client_id_${clientID}`).val();
    data["route"] = $("#partial").val();
    data["csrf_token"] = $("#csrf_token").val();

    handleRequest(url, method, data);
};

export const controlRevertClientData = function (formEvent) {
    formEvent.preventDefault();

    const form = $(this.closest(".form"));
    const url = form.attr("action");
    const method = form.attr("method");

    const data = {};
    data["action"] = "revert/client";
    data["id"] = $("#user_id").val();
    data["route"] = $("#partial").val();
    data["csrf_token"] = $("#csrf_token").val();

    handleRequest(url, method, data);
};

export const controlMarkAllAsRead = function (formEvent) {
    formEvent.preventDefault();

    const form = $(this.closest(".form"));
    const url = form.attr("action");
    const method = form.attr("method");

    const data = {};
    data["action"] = "mark/all";
    data["id"] = $("#view_as_user_id").val();
    data["is_read"] = $("#is_read").val();
    data["route"] = $("#partial").val();
    data["csrf_token"] = $("#csrf_token").val();

    handleRequest(url, method, data);
};

const controlMarkNotificationAsRead = function () {
    const status = +$(this).data("status");

    // Guard clause: only mark unread ones.
    if (status === 1) return;

    const url = "/api/";
    const method = $(this).data("method");

    const data = {};
    data["action"] = "mark/one";
    data["id"] = +$(this).data("notification-id");
    data["route"] = $("#view").val();
    data["csrf_token"] = $("#csrf_token").val();
    data["is_read"] = $("#is_read").val();

    handleRequest(url, method, data);
};

export const controlGenerateNavigationLists = function () {
    const route = $("#partial").val();
    const userID = $("#view_as_user_id").val();
    const authToken = $("#csrf_token").val();
    const url = `/api/?route=${route}&id=${userID}&csrf_token=${authToken}`;
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
            navigationView.generateNotificationsList(response["response"]["data"]["notifications"], getTimeAgo);
            navigationView.addEventMarkNotificationAsRead(controlMarkNotificationAsRead);
        },
        error: function (response) {
            console.log(response.responseText);
        },
    });
};
