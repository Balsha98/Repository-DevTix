import { controlHidePageLoader } from "./pageLoaderController.js";
import navigationView from "./../views/navigationView.js";
import * as navigationController from "./navigationController.js";
import sidebarView from "./../views/sidebarView.js";
import * as sidebarController from "./sidebarController.js";
import ticketView from "./../views/ticketView.js";

const controlGetTicketData = function () {
    const recordID = +$("#record_id").val();
    ticketView.setBtnSaveRequestMethod(recordID);
    ticketView.toggleTicketForms(recordID);

    const route = $("#view").val();
    const url = `/api/?route=${route}&id=${recordID}`;
    const method = "GET";

    // Guard clause: id is 0.
    if (!recordID) return;

    ticketView.setSpanRequestAction("alter");
    ticketView.setSpanTicketId(recordID);

    $.ajax({
        url: url,
        method: method,
        success: function (response) {
            console.log(response);
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
    sidebarView.addEventToggleSidebar(sidebarController.controlToggleSidebar);
    sidebarView.addEventToggleSidebarDropdown(sidebarController.controlToggleSidebarDropdown);

    // Load ticket.
    controlGetTicketData();
};

initController();
