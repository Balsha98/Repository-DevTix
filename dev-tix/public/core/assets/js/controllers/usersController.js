import { redirectTo } from "./../helpers/redirect.js";
import { renderListItemUserImage } from "./../helpers/image.js";
import { getTimeAgo } from "./../helpers/date.js";
import * as pageLoaderController from "./pageLoaderController.js";
import * as dataLoaderController from "./dataLoaderController.js";
import navigationView from "./../views/navigationView.js";
import * as navigationController from "./navigationController.js";
import sidebarView from "./../views/sidebarView.js";
import * as sidebarController from "./sidebarController.js";
import usersView from "./../views/usersView.js";
import * as noneDataController from "./noneDataController.js";

const controlChangeFilter = function () {
    const usersListItems = $(".users-list-item");

    // Guard clause.
    if (usersListItems.length === 0) return;

    // Show visuals.
    noneDataController.controlHideNoneDataContainer();
    dataLoaderController.controlShowDataLoader();

    // Verify filter.
    const filter = isNaN($(this).val()) ? $(this).val() : +$(this).val();
    usersListItems.each((_, item) => {
        const userRoleID = +$(item).data("role-id");
        if (filter === "all") $(item).removeClass("hide-element");
        else if (userRoleID !== filter) $(item).addClass("hide-element");
        else $(item).removeClass("hide-element");
    });

    usersView.setSpanFilterName(filter);

    // Get difference between filtered data.
    const { length: totalHidden } = $(".users-list-item.hide-element");
    const totalUsersLeft = usersListItems.length - totalHidden;
    setTimeout(() => usersView.setSpanTotalUsers(totalUsersLeft), 1000);

    // Show none data container if list is empty.
    if (totalUsersLeft === 0) noneDataController.controlShowNoneDataContainer(1);

    // Hide data loader.
    dataLoaderController.controlHideDataLoader(1);
};

const controlViewUserProfile = function () {
    const status = $(this).data("status");
    const href = $(this).data("href");

    if (status !== "cancelled") redirectTo(href);
};

const controlGenerateUsersList = function () {
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

            // Render ticket list items.
            const users = response["response"]["data"]["users"] ?? null;
            if (!users || users.length === 0) noneDataController.controlShowNoneDataContainer(0);

            usersView.generateUsersList(users, renderListItemUserImage, getTimeAgo);
            usersView.addEventViewUserProfile(controlViewUserProfile);
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

    // Setup users.
    usersView.addEventChangeFilter(controlChangeFilter);
    controlGenerateUsersList();
};

initController();
