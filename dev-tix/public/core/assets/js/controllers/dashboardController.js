import { controlHideLoader } from "./loaderController.js";
import navigationView from "./../views/navigationView.js";
import { controlToggleDropdown } from "./navigationController.js";
import sidebarView from "./../views/sidebarView.js";
import { controlToggleSidebar, controlToggleSidebarDropdown } from "./sidebarController.js";
import dashboardView from "./../views/dashboardView.js";

const controlGenerateTicketsList = function () {
    $.ajax({
        url: "/api/?page=dashboard",
        method: "GET",
        success: function (response) {
            dashboardView.generateTicketsList(response["tickets"]);
        },
    });
};

const initController = function () {
    controlHideLoader(0.1);

    navigationView.setWelcomeMessage();
    navigationView.addEventToggleDropdown(controlToggleDropdown);

    sidebarView.addEventToggleSidebar(controlToggleSidebar);
    sidebarView.addEventToggleSidebarDropdown(controlToggleSidebarDropdown);

    controlGenerateTicketsList();
};

initController();
