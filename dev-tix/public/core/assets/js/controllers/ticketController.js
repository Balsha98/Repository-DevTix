import { handleRequest } from "./../helpers/request.js";
import { isInputEmpty } from "./../helpers/validate.js";
import * as pageLoaderController from "./pageLoaderController.js";
import * as postTicketModalController from "./postTicketModalController.js";
import * as cancelTicketModalController from "./cancelTicketModalController.js";
import * as resolveTicketModalController from "./resolveTicketModalController.js";
import * as imageModalController from "./imageModalController.js";
import * as logoutModalController from "./logoutModalController.js";
import navigationView from "./../views/navigationView.js";
import * as navigationController from "./navigationController.js";
import sidebarView from "./../views/sidebarView.js";
import * as sidebarController from "./sidebarController.js";
import chatMenuView from "./../views/chatMenuView.js";
import * as chatMenuController from "./chatMenuController.js";
import ticketModel from "./../models/ticketModel.js";
import ticketView from "./../views/ticketView.js";

const controlPostRequest = function () {
    controlTogglePostTicketModal();

    // Guard clause: empty fields.
    if (isInputEmpty()) return;

    const form = $(".form-post-ticket");
    const url = form.attr("action");
    const method = $(this).data("method");

    const route = $("#view").val();
    const authToken = $("#csrf_token").val();

    const data = {};
    data["action"] = "post/request";
    data["route"] = route;
    data["csrf_token"] = authToken;
    data["user_id"] = $("#view_as_user_id").val();
    const predefinedType = $("#type").val();
    data["type"] = predefinedType !== "other" ? predefinedType : $("#custom_type").val();
    data["subject"] = $("#subject").val();
    data["question"] = $("#question").val();

    handleRequest(url, method, data);

    // Process image submission.
    const imageInputs = $(".input-image");
    const imageData = new FormData();
    imageData.append("action", "post/images");
    imageData.append("route", route);
    imageData.append("csrf_token", authToken);

    // Guard clause.
    if (imageInputs.length === 1 && !imageInputs.val()) return;

    imageInputs.each((i, upload) => {
        imageData.append(`image_${i + 1}`, upload.files[0]);
    });

    handleRequest(url, method, imageData, "form");
};

const controlAlterRequest = function () {
    const url = $(this.closest("div")).data("url");
    const method = $(this).data("method");
    const status = $(this).data("status");

    // Hide appropriate modal.
    if (status === "cancelled") controlToggleCancelTicketModal();
    else if (status === "resolved") controlToggleResolveTicketModal();

    const data = {};
    data["id"] = $("#record_id").val();
    data["action"] = `${status}/request`;
    data["route"] = $("#view").val();
    data["csrf_token"] = $("#csrf_token").val();
    data["user_id"] = $("#view_as_user_id").val();
    data["status"] = status;

    handleRequest(url, method, data);
};

const controlPostResponse = function (formEvent) {
    formEvent.preventDefault();

    // Guard clause: empty inputs.
    if (isInputEmpty()) return;

    const form = $(this.closest(".form"));
    const url = form.attr("action");
    const method = form.attr("method");

    const data = {};
    data["action"] = "post/response";
    data["route"] = $("#view").val();
    data["csrf_token"] = $("#csrf_token").val();
    data["request_id"] = $("#record_id").val();
    data["user_id"] = $("#view_as_user_id").val();
    data["response"] = $("#response").val();

    handleRequest(url, method, data);

    // Hide response modal.
    controlToggleResponseModal();
};

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
        $(this).removeClass("btn-upload-image").addClass("btn-remove");
        $(this).attr("for", `image_name_${imageID}`);
        $(this).text("Remove");

        // Guard clause: if image limit was reached.
        if (ticketModel.getStateVal("currNumImages") + 1 === ticketModel.getStateVal("maxNumImages")) {
            const totalListItems = $(".form-upload-image-inputs-list-item").length - 1;
            ticketModel.setStateVal("currNumImages", totalListItems);

            const imagesLeft = ticketModel.getStateVal("maxNumImages") - totalListItems;
            ticketView.setSpanImagesLeft(imagesLeft);

            // Clear interval.
            return clearInterval(inputInterval);
        }

        // Generate new input.
        ticketModel.setStateVal("currImageID", ticketModel.getStateVal("currImageID") + 1);
        listItem.after(ticketView.generateImageInput(ticketModel.getStateVal("currImageID")));
        $(".btn-upload-image").each((_, btn) => $(btn).click(controlGenerateImageInput));

        const totalListItems = $(".form-upload-image-inputs-list-item").length - 2;
        ticketModel.setStateVal("currNumImages", totalListItems);

        // Set number of images left.
        const imagesLeft = ticketModel.getStateVal("maxNumImages") - totalListItems;
        ticketView.setSpanImagesLeft(imagesLeft);

        // Clear interval.
        clearInterval(inputInterval);
    }, 200);
};

const controlRemoveImageInput = function () {
    $(this.closest("li")).remove();

    const remainingListItems = $(".form-upload-image-inputs-list-item");
    let numRemainingListItems = remainingListItems.length - 2;
    ticketModel.setStateVal("currNumImages", numRemainingListItems);

    if ($(".btn-upload-image").length === 0) {
        const lastListItem = $(remainingListItems[remainingListItems.length - 1]);
        lastListItem.before(ticketView.generateImageInput(ticketModel.getStateVal("currImageID") + 1));

        // Attach event to new button.
        $(".btn-upload-image").click(controlGenerateImageInput);
        numRemainingListItems++;
    }

    const imagesLeft = ticketModel.getStateVal("maxNumImages") - numRemainingListItems;
    ticketView.setSpanImagesLeft(imagesLeft);
};

const controlGetTicketData = function () {
    const recordID = +$("#record_id").val();
    ticketView.toggleTicketDataContainers(recordID);
    ticketView.setResponseContainerHeight(recordID);
    ticketView.setImageContainerHeight(recordID);

    // Guard clause: id is 0.
    if (!recordID) return;

    // Set ticket visuals.
    ticketView.setSpanTicketView("existing");
    ticketView.setSpanTicketId(recordID);

    const route = $("#view").val();
    const authToken = $("#csrf_token").val();
    const url = `/api/?route=${route}&id=${recordID}&csrf_token=${authToken}`;
    const method = "GET";

    $.ajax({
        url: url,
        method: method,
        success: function (response) {
            console.log(route, response);

            const totalResponses = response["response"]["data"]["responses"]["total_responses"];
            if (!totalResponses) ticketView.toggleNoneResponsesContainer();

            const totalImages = response["response"]["data"]["images"]["total_images"];
            if (!totalImages) ticketView.toggleNoneImagesContainer();
        },
        error: function (response) {
            console.log(response.responseText);
        },
    });
};

const controlTogglePostTicketModal = function () {
    postTicketModalController.controlTogglePostTicketModal();
};

const controlToggleCancelTicketModal = function () {
    cancelTicketModalController.controlToggleCancelTicketModal();
};

const controlToggleResolveTicketModal = function () {
    resolveTicketModalController.controlToggleResolveTicketModal();
};

const controlToggleResponseModal = function () {
    ticketView.toggleResponseModal();
};

const controlToggleImageModal = function () {
    const imageSrc = $(this).attr("src");
    imageModalController.controlToggleImageModal(imageSrc);
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

    // Setup ticket view.
    ticketView.addEventPostRequest(controlPostRequest);
    ticketView.addEventAlterRequest(controlAlterRequest);
    ticketView.addEventShowPostTicketModal(controlTogglePostTicketModal);
    ticketView.addEventShowCancelTicketModal(controlToggleCancelTicketModal);
    ticketView.addEventShowResolveTicketModal(controlToggleResolveTicketModal);
    ticketView.addEventPostResponse(controlPostResponse);
    ticketView.addEventSelectTicketType(controlSelectTicketType);
    ticketView.addEventGenerateImageInput(controlGenerateImageInput);
    ticketView.addEventToggleResponseModal(controlToggleResponseModal);
    ticketView.addEventToggleImageModal(controlToggleImageModal);
    ticketView.checkCharacterLimit(ticketModel.getStateVal("charLimit"));

    controlGetTicketData();
};

initController();
