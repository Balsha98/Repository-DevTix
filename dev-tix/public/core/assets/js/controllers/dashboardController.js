import { redirectTo } from "./../helpers/redirect.js";
import { renderTicketPatronImage } from "./../helpers/image.js";
import { controlHideLoader } from "./loaderController.js";
import navigationView from "./../views/navigationView.js";
import * as navigationController from "./navigationController.js";
import sidebarView from "./../views/sidebarView.js";
import { controlToggleSidebar, controlToggleSidebarDropdown } from "./sidebarController.js";
import dashboardView from "./../views/dashboardView.js";

const controlChangeFilter = function () {
    const filter = $(this).val();
    const ticketListItems = $(".tickets-list-item");

    $(".tickets-list-item").each((_, item) => {
        const ticketStatus = $(item).data("status");
        if (filter === "all") $(item).removeClass("hide-element");
        else if (ticketStatus !== filter) $(item).addClass("hide-element");
        else $(item).removeClass("hide-element");
    });

    const { length: totalHidden } = $(".tickets-list-item.hide-element");
    dashboardView.setFilterSpanIndicators(filter, ticketListItems.length - totalHidden);
};

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
            console.log(route, response);

            // Render ticket list items.
            dashboardView.generateTicketsList(response["response"]["data"], renderTicketPatronImage);
            dashboardView.addEventViewTicketDetails(controlViewTicketDetails);
        },
    });
};

const initController = function () {
    controlHideLoader(0.1);

    navigationView.setWelcomeMessage();
    navigationView.addEventToggleDropdown(navigationController.controlToggleDropdown);
    navigationView.addEventMarkNotificationsAsRead(navigationController.controlMarkNotificationsAsRead);

    sidebarView.addEventToggleSidebar(controlToggleSidebar);
    sidebarView.addEventToggleSidebarDropdown(controlToggleSidebarDropdown);

    navigationController.controlGenerateNotificationsList();

    dashboardView.addEventChangeFilter(controlChangeFilter);
    controlGenerateTicketsList();
};

initController();
