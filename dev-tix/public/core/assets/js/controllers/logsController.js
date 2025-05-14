import { renderListItemUserImage } from "./../helpers/image.js";
import { getTimeAgo } from "./../helpers/date.js";
import * as pageLoaderController from "./pageLoaderController.js";
import * as logoutModalController from "./logoutModalController.js";
import * as dataLoaderController from "./dataLoaderController.js";
import navigationView from "./../views/navigationView.js";
import * as navigationController from "./navigationController.js";
import sidebarView from "./../views/sidebarView.js";
import * as sidebarController from "./sidebarController.js";
import chatMenuView from "./../views/chatMenuView.js";
import * as chatMenuController from "./chatMenuController.js";
import logsView from "./../views/logsView.js";
import * as noneDataController from "./noneDataController.js";

const controlChangeFilter = function () {
    const logsListItems = $(".logs-list-item");

    // Guard clause.
    if (logsListItems.length === 0) return;

    // Show visuals.
    noneDataController.controlHideNoneDataContainer();
    dataLoaderController.controlShowDataLoader();

    // Verify filter.
    const filter = $(this).val();
    logsListItems.each((_, item) => {
        const logType = $(item).data("type");
        if (filter === "all") $(item).removeClass("hide-element");
        else if (logType !== filter) $(item).addClass("hide-element");
        else $(item).removeClass("hide-element");
    });

    logsView.setSpanFilterName(filter);

    // Get difference between filtered data.
    const { length: totalHidden } = $(".logs-list-item.hide-element");
    const totalLogsLeft = logsListItems.length - totalHidden;
    setTimeout(() => logsView.setSpanTotalUsers(totalLogsLeft), 1000);

    // Show none data container if list is empty.
    if (totalLogsLeft === 0) noneDataController.controlShowNoneDataContainer(1);

    // Hide data loader.
    dataLoaderController.controlHideDataLoader(1);
};

const controlGenerateLogsList = function () {
    const route = $("#view").val();
    const userID = $("#user_id").val();
    const authToken = $("#csrf_token").val();
    const url = `/api/?route=${route}&id=${userID}&csrf_token=${authToken}`;
    const method = "GET";

    $.ajax({
        url: url,
        method: method,
        success: function (response) {
            console.log(route, response);

            // Render log list items.
            const logs = response["response"]["data"]["logs"] ?? null;
            if (!logs || logs.length === 0) noneDataController.controlShowNoneDataContainer(0);

            logsView.generateLogsList(logs, renderListItemUserImage, getTimeAgo);
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
    navigationView.addEventMarkAllAsRead(navigationController.controlMarkAllAsRead);
    navigationView.addEventToggleLogoutModal(logoutModalController.controlToggleLogoutModal);

    // Setup sidebar.
    sidebarView.addEventToggleSidebar(sidebarController.controlToggleSidebar);
    sidebarView.addEventToggleSidebarDropdown(sidebarController.controlToggleSidebarDropdown);
    sidebarView.addEventToggleLogoutModal(logoutModalController.controlToggleLogoutModal);

    // Setup chat menu.
    chatMenuController.controlGetChatMessages();
    chatMenuView.addEventToggleChatMenu(chatMenuController.controlToggleChatMenu);
    chatMenuView.addEventToggleChatMenuLists(chatMenuController.controlToggleChatMenuLists);
    chatMenuView.addEventPostChatMessage(chatMenuController.controlPostChatMessage);

    // Setup logs.
    logsView.addEventChangeFilter(controlChangeFilter);
    controlGenerateLogsList();
};

initController();
