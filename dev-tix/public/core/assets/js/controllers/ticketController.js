import { controlHidePageLoader } from "./pageLoaderController.js";
import navigationView from "./../views/navigationView.js";
import * as navigationController from "./navigationController.js";
import sidebarView from "./../views/sidebarView.js";
import * as sidebarController from "./sidebarController.js";
import ticketModel from "./../models/ticketModel.js";
import ticketView from "./../views/ticketView.js";

const controlSelectTicketType = function () {
    const value = $(this).val();

    // Guard clause.
    if (value !== "other") {
        const customInputContainer = $(".div-custom-ticket-type-container");
        if (customInputContainer) customInputContainer.remove();

        return;
    }

    $(this.closest("div")).after(ticketView.generateCustomTicketTypeField());
};

const controlGenerateImageInput = function () {
    const listItem = $(this.closest("li"));
    const imageID = listItem.data("image-id");
    ticketModel.setStateVal("currImageID", imageID);

    const inputInterval = setInterval(() => {
        const imagePath = $(`#image_${imageID}`).val();

        // Guard clause.
        if (!imagePath) return;

        // Get image name.
        const imageName = imagePath.split("\\")[2];
        $(`#image_name_${imageID}`).val(imageName);

        // Switch button from upload to remove.
        $(this).removeClass("btn-primary").addClass("btn-error");
        $(this).removeClass("btn-upload").addClass("btn-remove");
        $(this).attr("for", `image_name_${imageID}`);
        $(this).text("Remove");

        // Generate new input.
        ticketModel.setStateVal("currImageID", ticketModel.getStateVal("currImageID") + 1);
        listItem.after(ticketView.generateImageInput(ticketModel.getStateVal("currImageID")));
        $(".btn-upload").each((_, btn) => $(btn).click(controlGenerateImageInput));

        // Reset values.
        $(`#image_${imageID}`).val("");
        clearInterval(inputInterval);
    }, 1000);
};

const controlGetTicketData = function () {
    const recordID = +$("#record_id").val();
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

            // TODO: Load ticket data.
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

    // Setup ticket view.
    ticketView.addEventSelectTicketType(controlSelectTicketType);
    ticketView.addEventGenerateImageInput(controlGenerateImageInput);

    // Setup ticket view.
    controlSelectTicketType();
    controlGetTicketData();
};

initController();
