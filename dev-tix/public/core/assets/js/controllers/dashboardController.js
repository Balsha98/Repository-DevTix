import { redirectTo } from "./../helpers/redirect.js";
import { renderListItemUserImage } from "./../helpers/image.js";
import * as pageLoaderController from "./pageLoaderController.js";
import * as dataLoaderController from "./dataLoaderController.js";
import navigationView from "./../views/navigationView.js";
import * as navigationController from "./navigationController.js";
import sidebarView from "./../views/sidebarView.js";
import * as sidebarController from "./sidebarController.js";
import dashboardView from "./../views/dashboardView.js";
import * as noneDataController from "./noneDataController.js";

const controlChangeFilter = function () {
    const ticketListItems = $(".tickets-list-item");

    // Guard clause.
    if (ticketListItems.length === 0) return;

    // Show visuals.
    noneDataController.controlHideNoneDataContainer();
    dataLoaderController.controlShowDataLoader();

    // Verify filter.
    const filter = $(this).val();
    ticketListItems.each((_, item) => {
        const ticketStatus = $(item).data("status");
        if (filter === "all") $(item).removeClass("hide-element");
        else if (ticketStatus !== filter) $(item).addClass("hide-element");
        else $(item).removeClass("hide-element");
    });

    dashboardView.setSpanFilterName(filter);

    // Get difference between filtered data.
    const { length: totalHidden } = $(".tickets-list-item.hide-element");
    const totalTicketsLeft = ticketListItems.length - totalHidden;
    setTimeout(() => dashboardView.setSpanTotalTickets(totalTicketsLeft), 1000);

    // Show none data container if list is empty.
    if (totalTicketsLeft === 0) noneDataController.controlShowNoneDataContainer(1);

    // Hide data loader.
    dataLoaderController.controlHideDataLoader(1);
};

const controlViewTicketDetails = function () {
    const status = $(this).data("status");
    const href = $(this).data("href");

    if (status !== "cancelled") redirectTo(href);
};

const controlGenerateTicketsList = function () {
    const route = $("#view").val();
    const authToken = $("#csrf_token").val();
    const url = `/api/?route=${route}&csrf_token=${authToken}`;
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
            if (!tickets || tickets.length === 0) noneDataController.controlShowNoneDataContainer(0);

            dashboardView.generateTicketsList(tickets, renderListItemUserImage);
            dashboardView.addEventViewTicketDetails(controlViewTicketDetails);
        },
        error: function (response) {
            console.log(response.responseText);
        },
    });
};

const initController = function () {
    pageLoaderController.controlHidePageLoader(1);

    // Setup navigation.
    navigationView.setWelcomeMessage();
    navigationController.controlGenerateNavigationLists();
    navigationView.addEventToggleDropdown(navigationController.controlToggleDropdown);
    navigationView.addEventRevertClientData(navigationController.controlRevertClientData);
    navigationView.addEventMarkNotificationsAsRead(navigationController.controlMarkNotificationsAsRead);

    // Setup sidebar.
    sidebarView.addEventToggleSidebar(sidebarController.controlToggleSidebar);
    sidebarView.addEventToggleSidebarDropdown(sidebarController.controlToggleSidebarDropdown);

    // Setup dashboard.
    dashboardView.addEventChangeFilter(controlChangeFilter);
    controlGenerateTicketsList();
};

initController();
