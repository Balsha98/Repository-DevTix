import { controlHideLoader } from "./loaderController.js";
import navigationView from "./../views/navigationView.js";
import { controlToggleDropdown } from "./navigationController.js";
import sidebarView from "./../views/sidebarView.js";
import { controlToggleSidebar, controlToggleSidebarDropdown } from "./sidebarController.js";

const initController = function () {
    controlHideLoader(2);

    navigationView.setWelcomeMessage();
    navigationView.addEventToggleDropdown(controlToggleDropdown);
    sidebarView.addEventToggleSidebar(controlToggleSidebar);
    sidebarView.addEventToggleSidebarDropdown(controlToggleSidebarDropdown);
};

initController();
