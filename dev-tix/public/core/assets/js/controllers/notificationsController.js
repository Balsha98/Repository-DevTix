import { getTimeAgo } from "./../helpers/date.js";
import { handleRequest } from "./../helpers/request.js";
import { renderListItemUserImage } from "./../helpers/image.js";
import * as pageLoaderController from "./pageLoaderController.js";
import * as logoutModalController from "./logoutModalController.js";
import * as dataLoaderController from "./dataLoaderController.js";
import navigationView from "./../views/navigationView.js";
import * as navigationController from "./navigationController.js";
import sidebarView from "./../views/sidebarView.js";
import * as sidebarController from "./sidebarController.js";
import notificationsView from "./../views/notificationsView.js";
import * as noneDataController from "./noneDataController.js";

const controlChangeFilter = function () {
    const notificationListItems = $(".notifications-list-item");

    // Guard clause.
    if (notificationListItems.length === 0) return;

    // Show visuals.
    noneDataController.controlHideNoneDataContainer();
    dataLoaderController.controlShowDataLoader();

    // Verify filter.
    const filter = isNaN($(this).val()) ? $(this).val() : +$(this).val();
    notificationListItems.each((_, item) => {
        const isRead = $(item).data("status");
        if (filter === "all") $(item).removeClass("hide-element");
        else if (isRead !== filter) $(item).addClass("hide-element");
        else $(item).removeClass("hide-element");
    });

    notificationsView.setSpanFilterName(filter);

    // Get difference between filtered data.
    const { length: totalHidden } = $(".notifications-list-item.hide-element");
    const totalNotifications = notificationListItems.length - totalHidden;
    setTimeout(() => notificationsView.setSpanTotalNotifications(totalNotifications), 1000);

    // Show none data container if list is empty.
    if (totalNotifications === 0) noneDataController.controlShowNoneDataContainer(1);

    // Hide data loader.
    dataLoaderController.controlHideDataLoader(1);
};

const controlMarkAllAsRead = function () {
    const url = "/api/";
    const method = $(this).data("method");

    const data = {};
    data["action"] = "mark/all";
    data["id"] = $("#view_as_user_id").val();
    data["route"] = $("#view").val();
    data["csrf_token"] = $("#csrf_token").val();
    data["is_read"] = $("#is_read").val();

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

const controlGenerateNotificationsList = function () {
    const route = $("#view").val();
    const userID = $("#view_as_user_id").val();
    const authToken = $("#csrf_token").val();
    const url = `/api/?route=${route}&id=${userID}&csrf_token=${authToken}`;
    const method = "GET";

    $.ajax({
        url: url,
        method: method,
        success: function (response) {
            console.log(route, response);

            // Render ticket list items.
            const data = response["response"]["data"] ?? null;
            if (!data || data["notifications"].length === 0) noneDataController.controlShowNoneDataContainer(0);

            notificationsView.generateNotificationsList(data, renderListItemUserImage, getTimeAgo);
            notificationsView.addEventMarkNotificationAsRead(controlMarkNotificationAsRead);
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

    // Setup dashboard.
    notificationsView.addEventChangeFilter(controlChangeFilter);
    notificationsView.addEventMarkAllAsRead(controlMarkAllAsRead);
    controlGenerateNotificationsList();
};

initController();
