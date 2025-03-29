import { handleRequest } from "./../helpers/request.js";
import { isInputEmpty } from "./../helpers/validate.js";
import * as pageLoaderController from "./pageLoaderController.js";
import navigationView from "./../views/navigationView.js";
import * as navigationController from "./navigationController.js";
import sidebarView from "./../views/sidebarView.js";
import * as sidebarController from "./sidebarController.js";
import profileView from "./../views/profileView.js";

const controlUpdateProfile = function () {
    // Guard clause: empty input.
    if (isInputEmpty()) return;

    const form = $(".form-profile");
    const url = form.attr("action");
    const method = $(this).data("method");

    const data = {};
    data["id"] = $("#record_id").val();
    data["route"] = $("#view").val();
    data["csrf_token"] = $("#csrf_token").val();
    $(`.profile-input`).each((_, input) => {
        data[$(input).attr("id")] = $(input).val();
    });

    handleRequest(url, method, data);

    // Guard clause: image not set.
    if (!$("#image").val()) return;

    const imageData = new FormData();
    imageData.append("action", "update/image");
    imageData.append("id", $("#record_id").val());
    imageData.append("route", $("#view").val());
    imageData.append("csrf_token", $("#csrf_token").val());
    imageData.append("image", $("#image")[0].files[0]);

    handleRequest(url, "POST", imageData, "form");
};

const controlGetProfileData = function () {
    const recordID = +$("#record_id").val();

    // Guard clause.
    if (!recordID) return;

    profileView.setSpanProfileView("existing");

    const route = $("#view").val();
    const authToken = $("#csrf_token").val();
    const url = `/api/?route=${route}&id=${recordID}&csrf_token=${authToken}`;
    const method = "GET";

    $.ajax({
        url: url,
        method: method,
        success: function (response) {
            console.log(route, response);

            profileView.populateUserInputs(response["response"]["data"]);
        },
        error: function (response) {
            console.log(response.responseText);
        },
    });
};

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
    profileView.addEventUpdateProfile(controlUpdateProfile);
    profileView.addEventToggleInputImage(controlToggleInputImage);

    controlGetProfileData();
};

initController();
