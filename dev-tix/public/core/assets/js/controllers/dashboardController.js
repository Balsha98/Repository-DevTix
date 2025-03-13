import { redirectTo } from "./../helpers/redirect.js";
import { renderTicketPatronImage } from "./../helpers/image.js";
import { controlHidePageLoader } from "./pageLoaderController.js";
import { controlHideDataLoader, controlShowDataLoader } from "./dataLoaderController.js";
import navigationView from "./../views/navigationView.js";
import * as navigationController from "./navigationController.js";
import sidebarView from "./../views/sidebarView.js";
import { controlToggleSidebar, controlToggleSidebarDropdown } from "./sidebarController.js";
import dashboardView from "./../views/dashboardView.js";
import { controlHideNoneDataContainer, controlShowNoneDataContainer } from "./noneDataController.js";

const controlChangeFilter = function () {
    const filter = $(this).val();
    dashboardView.setSpanFilterName(filter);
    const ticketListItems = $(".tickets-list-item");

    // Guard clause.
    if (ticketListItems.length === 0) return;

    // Show visuals.
    controlHideNoneDataContainer();
    controlShowDataLoader();

    ticketListItems.each((_, item) => {
        const ticketStatus = $(item).data("status");
        if (filter === "all") $(item).removeClass("hide-element");
        else if (ticketStatus !== filter) $(item).addClass("hide-element");
        else $(item).removeClass("hide-element");
    });

    // Get difference between filtered data.
    const { length: totalHidden } = $(".tickets-list-item.hide-element");
    const totalTicketsLeft = ticketListItems.length - totalHidden;
    setTimeout(() => dashboardView.setSpanTotalTickets(totalTicketsLeft), 1000);

    // Show none data container if list is empty.
    if (totalTicketsLeft === 0) controlShowNoneDataContainer(1);

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
            const tickets = response["response"]["data"]["tickets"] ?? null;
            if (!tickets || tickets.length === 0) controlShowNoneDataContainer(0);

            dashboardView.generateTicketsList(tickets, renderTicketPatronImage);
            dashboardView.addEventViewTicketDetails(controlViewTicketDetails);
        },
        error: function (response) {
            console.log(response.responseText);
        },
    });
};

const initController = function () {
    controlHidePageLoader(0.1);

    // Setup navigation.
    navigationView.setWelcomeMessage();
    navigationController.controlGenerateNavigationLists();
    navigationView.addEventToggleDropdown(navigationController.controlToggleDropdown);
    navigationView.addEventMarkNotificationsAsRead(navigationController.controlMarkNotificationsAsRead);

    // Setup sidebar.
    sidebarView.addEventToggleSidebar(controlToggleSidebar);
    sidebarView.addEventToggleSidebarDropdown(controlToggleSidebarDropdown);

    // Setup dashboard.
    dashboardView.addEventChangeFilter(controlChangeFilter);
    controlGenerateTicketsList();
};

initController();
