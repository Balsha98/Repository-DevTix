import * as pageLoaderController from "./pageLoaderController.js";
import navigationView from "./../views/navigationView.js";
import * as navigationController from "./navigationController.js";
import sidebarView from "./../views/sidebarView.js";
import * as sidebarController from "./sidebarController.js";
import leaderboardView from "./../views/leaderboardView.js";

const initController = function () {
    pageLoaderController.controlHidePageLoader(0.1);

    // Setup navigation.
    navigationView.setWelcomeMessage();
    navigationController.controlGenerateNavigationLists();
    navigationView.addEventToggleDropdown(navigationController.controlToggleDropdown);
    navigationView.addEventRevertClientData(navigationController.controlRevertClientData);
    navigationView.addEventMarkNotificationsAsRead(navigationController.controlMarkNotificationsAsRead);

    // Setup sidebar.
    sidebarView.addEventToggleSidebar(sidebarController.controlToggleSidebar);
    sidebarView.addEventToggleSidebarDropdown(sidebarController.controlToggleSidebarDropdown);

    // Setup leaderboard.
};

initController();
