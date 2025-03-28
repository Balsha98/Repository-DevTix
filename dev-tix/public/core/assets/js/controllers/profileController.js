import { handleRequest } from "./../helpers/request.js";
import { isInputEmpty } from "./../helpers/validate.js";
import * as pageLoaderController from "./pageLoaderController.js";
import navigationView from "./../views/navigationView.js";
import * as navigationController from "./navigationController.js";
import sidebarView from "./../views/sidebarView.js";
import * as sidebarController from "./sidebarController.js";
import profileView from "./../views/profileView.js";

const controlToggleInputImage = function () {
    const inputInterval = setInterval(() => {
        const imagePath = $("#image").val();

        // Guard clause.
        if (!imagePath) return;

        // Get image name.
        const imageName = imagePath.split("\\")[2];
        $("#image_name").val(imageName);

        // Switch.
        $(this).off();
        $(this).click(controlRemoveImageInput);
        $(this).removeClass("btn-primary").addClass("btn-error");
        $(this).removeClass("btn-upload-image").addClass("btn-remove");
        $(this).attr("for", "image_name");
        $(this).text("Remove");

        // Clear interval.
        clearInterval(inputInterval);
    }, 200);
};

const controlRemoveImageInput = function () {
    $(this.closest(".div-input-image-outer-container")).remove();
    const profileImageContainer = $(".div-profile-image-container");
    profileImageContainer.after(profileView.generateImageInput());

    // Attach event to new button.
    $(".btn-upload-image").click(controlToggleInputImage);
};

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

    // Setup profile view.
    profileView.addEventToggleInputImage(controlToggleInputImage);
};

initController();
