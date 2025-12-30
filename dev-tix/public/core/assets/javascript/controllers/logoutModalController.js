import { redirectTo } from "./../helpers/redirect.js";
import logoutModalView from "./../views/logoutModalView.js";

export const controlToggleLogoutModal = function () {
    logoutModalView.toggleLogoutModal();
};

export const controlLogoutUser = function (formEvent) {
    formEvent.preventDefault();

    const form = $(this.closest(".form"));
    const url = form.attr("action");
    const method = form.attr("method");
    const route = $(this).data("view");

    const data = {};
    data["route"] = route;
    data["id"] = $("#view_as_user_id").val();
    data["csrf_token"] = $("#csrf_token").val();
    data["is_active"] = 0;

    $.ajax({
        url: url,
        method: method,
        data: JSON.stringify(data),
        success: function (response) {
            console.log(route, response);

            // Guard clause.
            if (response["status"] === "error") return;

            // Redirect to logout view.
            redirectTo(response["redirect"]);
        },
        error: function (response) {
            console.log(response.responseText);
        },
    });
};

const initController = function () {
    logoutModalView.addEventToggleLogoutModal(controlToggleLogoutModal);
    logoutModalView.addEventLogoutUser(controlLogoutUser);
};

initController();
