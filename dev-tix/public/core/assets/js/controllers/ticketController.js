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

        // Switch.
        $(this).off();
        $(this).click(controlRemoveImageInput);
        $(this).removeClass("btn-primary").addClass("btn-error");
        $(this).removeClass("btn-upload").addClass("btn-remove");
        $(this).attr("for", `image_name_${imageID}`);
        $(this).text("Remove");

        // Guard clause: if image limit was reached.
        if (ticketModel.getStateVal("currNumImages") + 1 === ticketModel.getStateVal("maxNumImages")) {
            const totalListItems = $(".form-create-image-inputs-list-item").length - 1;
            ticketModel.setStateVal("currNumImages", totalListItems);

            const imagesLeft = ticketModel.getStateVal("maxNumImages") - totalListItems;
            ticketView.setSpanImagesLeft(imagesLeft);

            return clearInterval(inputInterval);
        }

        // Generate new input.
        ticketModel.setStateVal("currImageID", ticketModel.getStateVal("currImageID") + 1);
        listItem.after(ticketView.generateImageInput(ticketModel.getStateVal("currImageID")));
        $(".btn-upload").each((_, btn) => $(btn).click(controlGenerateImageInput));

        const totalListItems = $(".form-create-image-inputs-list-item").length - 2;
        ticketModel.setStateVal("currNumImages", totalListItems);

        // Set number of images left.
        const imagesLeft = ticketModel.getStateVal("maxNumImages") - totalListItems;
        ticketView.setSpanImagesLeft(imagesLeft);

        // Reset values.
        $(`#image_${imageID}`).val("");
        clearInterval(inputInterval);
    }, 200);
};

const controlRemoveImageInput = function () {
    $(this.closest("li")).remove();

    const remainingListItems = $(".form-create-image-inputs-list-item");
    let numRemainingListItems = remainingListItems.length - 2;
    ticketModel.setStateVal("currNumImages", numRemainingListItems);

    if ($(".btn-upload").length === 0) {
        const lastListItem = $(remainingListItems[remainingListItems.length - 1]);
        lastListItem.before(ticketView.generateImageInput(ticketModel.getStateVal("currImageID") + 1));

        // Attach event to new button.
        $(".btn-upload").click(controlGenerateImageInput);
        numRemainingListItems++;
    }

    const imagesLeft = ticketModel.getStateVal("maxNumImages") - numRemainingListItems;
    ticketView.setSpanImagesLeft(imagesLeft);
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
