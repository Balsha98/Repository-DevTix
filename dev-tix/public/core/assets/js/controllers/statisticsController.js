import * as pageLoaderController from "./pageLoaderController.js";
import navigationView from "./../views/navigationView.js";
import * as navigationController from "./navigationController.js";
import sidebarView from "./../views/sidebarView.js";
import * as sidebarController from "./sidebarController.js";
import statisticsView from "./../views/statisticsView.js";

const controlGenerateStatistics = function () {};

const initController = function () {
    pageLoaderController.controlHidePageLoader(1);

    // Setup navigation.
    navigationView.setWelcomeMessage();
    navigationController.controlGenerateNavigationLists();
    navigationView.addEventToggleDropdown(navigationController.controlToggleDropdown);
    navigationView.addEventRevertClientData(navigationController.controlRevertClientData);
    navigationView.addEventMarkAllAsRead(navigationController.controlMarkAllAsRead);

    // Setup sidebar.
    sidebarView.addEventToggleSidebar(sidebarController.controlToggleSidebar);
    sidebarView.addEventToggleSidebarDropdown(sidebarController.controlToggleSidebarDropdown);

    // Setup statistics.
};

initController();
