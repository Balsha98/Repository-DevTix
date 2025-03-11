import { redirectTo } from "./../helpers/redirect.js";
import { renderTicketPatronImage } from "./../helpers/image.js";
import { controlHideLoader } from "./loaderController.js";
import navigationView from "./../views/navigationView.js";
import { controlToggleDropdown, controlGenerateNotificationsList } from "./navigationController.js";
import sidebarView from "./../views/sidebarView.js";
import { controlToggleSidebar, controlToggleSidebarDropdown } from "./sidebarController.js";
import dashboardView from "./../views/dashboardView.js";

const controlViewTicketDetails = function () {
    redirectTo($(this).data("href"));
};

const controlGenerateTicketsList = function () {
    const route = $("#view").val();
    const url = `/api/?route=${route}`;
    const method = "GET";

    $.ajax({
        url: url,
        method: method,
        success: function (response) {
            console.log("DASHBOARD", response);

            // Render ticket list items.
            dashboardView.generateTicketsList(response["response"]["data"], renderTicketPatronImage);
            dashboardView.addEventViewTicketDetails(controlViewTicketDetails);
        },
    });
};

const initController = function () {
    controlHideLoader(2);

    navigationView.setWelcomeMessage();
    navigationView.addEventToggleDropdown(controlToggleDropdown);

    sidebarView.addEventToggleSidebar(controlToggleSidebar);
    sidebarView.addEventToggleSidebarDropdown(controlToggleSidebarDropdown);

    controlGenerateNotificationsList();
    controlGenerateTicketsList();
};

initController();
