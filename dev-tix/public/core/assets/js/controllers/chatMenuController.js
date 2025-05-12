import { getTimeAgo } from "./../helpers/date.js";
import { renderListItemUserImage } from "./../helpers/image.js";
import { isInputEmpty } from "./../helpers/validate.js";
import * as alertModalController from "./alertModalController.js";
import * as dataLoaderController from "./dataLoaderController.js";
import chatMenuView from "./../views/chatMenuView.js";
import * as noneChatMessagesController from "./noneChatMessagesController.js";

export const controlToggleChatMenu = function () {
    chatMenuView.toggleChatMenuContainer();
};

export const controlToggleChatMenuLists = function () {
    if ($(this).attr("class").includes("toggle")) return;

    dataLoaderController.controlShowDataLoader("div-chat-overview-container");

    // Toggle chat nav icon buttons.
    $(".btn-chat-nav-icon").each((_, btn) => {
        $(btn).removeClass("active-btn-icon");

        if (!$(this).hasClass("active-btn-icon")) {
            $(this).addClass("active-btn-icon");
        }
    });

    // Toggle chat menu lists.
    const chatList = $(this).data("chat-list");
    $(".div-chat-list-container").each((_, container) => {
        $(container).addClass("hide-element");

        if ($(`.div-chat-${chatList}-list-container`).length !== 0) {
            if (chatList === "messages") {
                const chatMessageListItems = $(".chat-messages-list-item");

                if (chatMessageListItems.length !== 0) {
                    noneChatMessagesController.controlHideNoneChatMessagesContainer();
                }
            }

            // Show targeted list container.
            $(`.div-chat-${chatList}-list-container`).removeClass("hide-element");
        }
    });

    // Setup visuals.
    $(".chat-menu-header-heading").text($(this).data("header-title"));
    dataLoaderController.controlHideDataLoader("div-chat-overview-container", 1);
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
                const chatMessages = response["response"]["data"]["chat_messages"] ?? null;

                if (chatMessages) {
                    chatMenuView.generateChatMessagesList(chatMessages, renderListItemUserImage, getTimeAgo);

                    if (chatMessages.length === 0) {
                        noneChatMessagesController.controlShowNoneChatMessagesContainer(0);
                    }
                }

                // Render chat users, both active and inactive.
                const chatUsers = response["response"]["data"]["chat_users"] ?? null;
                if (chatUsers) chatMenuView.generateChatUsersList(chatUsers, renderListItemUserImage);
            },
            error: function (response) {
                console.log(response.responseText);
            },
        });
    }, 2000);
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
    data["user_id"] = $("#view_as_user_id").val();
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
