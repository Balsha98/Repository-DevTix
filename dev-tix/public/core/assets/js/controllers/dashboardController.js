import { redirectTo } from "./../helpers/redirect.js";
import { renderTicketPatronImage } from "./../helpers/image.js";
import { controlHidePageLoader } from "./pageLoaderController.js";
import { controlHideDataLoader, controlShowDataLoader } from "./dataLoaderController.js";
import navigationView from "./../views/navigationView.js";
import * as navigationController from "./navigationController.js";
import sidebarView from "./../views/sidebarView.js";
import { controlToggleSidebar, controlToggleSidebarDropdown } from "./sidebarController.js";
import dashboardView from "./../views/dashboardView.js";

const controlChangeFilter = function () {
    const filter = $(this).val();
    const ticketListItems = $(".tickets-list-item");

    // Show data loader.
    controlShowDataLoader();

    $(".tickets-list-item").each((_, item) => {
        const ticketStatus = $(item).data("status");
        if (filter === "all") $(item).removeClass("hide-element");
        else if (ticketStatus !== filter) $(item).addClass("hide-element");
        else $(item).removeClass("hide-element");
    });

    const { length: totalHidden } = $(".tickets-list-item.hide-element");
    setTimeout(() => dashboardView.setFilterSpanIndicators(filter, ticketListItems.length - totalHidden), 1000);

    // Hide data loader.
    controlHideDataLoader(1);
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

            const overviews = response["response"]["data"]["overviews"] ?? null;
            if (overviews) dashboardView.loadAdminOverviewData(overviews);

            // Render ticket list items.
            const tickets = response["response"]["data"]["tickets"];
            dashboardView.generateTicketsList(tickets, renderTicketPatronImage);
            dashboardView.addEventViewTicketDetails(controlViewTicketDetails);
        },
    });
};

const initController = function () {
    controlHidePageLoader(0.1);

    // Setup navigation.
    navigationView.setWelcomeMessage();
    navigationView.addEventToggleDropdown(navigationController.controlToggleDropdown);
    navigationView.addEventMarkNotificationsAsRead(navigationController.controlMarkNotificationsAsRead);
    navigationController.controlGenerateNotificationsList();

    // Setup sidebar.
    sidebarView.addEventToggleSidebar(controlToggleSidebar);
    sidebarView.addEventToggleSidebarDropdown(controlToggleSidebarDropdown);

    // Setup dashboard.
    dashboardView.addEventChangeFilter(controlChangeFilter);
    controlGenerateTicketsList();
};

initController();
