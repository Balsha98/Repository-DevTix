import * as pageLoaderController from "./pageLoaderController.js";
import * as logoutModalController from "./logoutModalController.js";
import navigationView from "./../views/navigationView.js";
import * as navigationController from "./navigationController.js";
import sidebarView from "./../views/sidebarView.js";
import * as sidebarController from "./sidebarController.js";
import chatMenuView from "./../views/chatMenuView.js";
import * as chatMenuController from "./chatMenuController.js";
import leaguesView from "./../views/leaguesView.js";

const controlGenerateLeagueLeaders = function () {
    const route = $("#view").val();
    const authToken = $("#csrf_token").val();
    const url = `/api/?route=${route}&csrf_token=${authToken}`;
    const method = "GET";

    $.ajax({
        url: url,
        method: method,
        success: function (response) {
            console.log(route, response);

            const leaders = response["response"]["data"];
            if (leaders) leaguesView.setLeagueLeaders(leaders);
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

    // Setup leagues.
    controlGenerateLeagueLeaders();
};

initController();
