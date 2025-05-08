import { getTimeAgo } from "./../helpers/date.js";
import { renderListItemUserImage } from "./../helpers/image.js";
import { isInputEmpty } from "./../helpers/validate.js";
import chatMenuView from "./../views/chatMenuView.js";
import * as alertModalController from "./alertModalController.js";

export const controlToggleChatMenu = function () {
    chatMenuView.toggleChatMenuContainer();
};

export const controlGetChatMessages = function () {
    const route = $("#partial_menu").val();
    const authToken = $("#csrf_token").val();
    const url = `/api/?route=${route}&csrf_token=${authToken}`;
    const method = "GET";

    setInterval(() => {
        $.ajax({
            url: url,
            method: method,
            success: function (response) {
                console.log(response);
                const chatMessages = response["response"]["data"]["chat_messages"] ?? null;

                // prettier-ignore
                if (chatMessages) chatMenuView.generateChatMessagesList(chatMessages, renderListItemUserImage, getTimeAgo);
            },
            error: function (response) {
                console.log(response.responseText);
            },
        });
    }, 3000);
};

export const controlPostChatMessage = function (formEvent) {
    formEvent.preventDefault();

    // Guard clause: empty inputs.
    if (isInputEmpty()) return;

    const form = $(this.closest(".form"));
    const url = form.attr("action");
    const method = form.attr("method");
    const route = $("#partial_menu").val();

    const data = {};
    data["route"] = route;
    data["user_id"] = $("#user_id").val();
    data["chat_message"] = $("#chat_message").val();
    data["csrf_token"] = $("#csrf_token").val();

    $.ajax({
        url: url,
        method: method,
        data: JSON.stringify(data),
        success: function (response) {
            console.log(route, response);

            // Guard clause: show alert if inputs are invalid.
            if (response["status"] === "error") return alertModalController.initController(response);

            // Render new chat message.
            const chatMessage = response["response"]["data"]["chat_message"] ?? null;
            if (chatMessage) chatMenuView.insertNewChatMessage(chatMessage, renderListItemUserImage, getTimeAgo);
        },
        error: function (response) {
            console.log(response.responseText);
        },
    });
};
