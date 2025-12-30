import noneChatMessagesView from "./../views/noneChatMessagesView.js";

export const controlHideNoneChatMessagesContainer = function () {
    noneChatMessagesView.hideNoneChatMessagesContainer();
};

export const controlShowNoneChatMessagesContainer = function (seconds) {
    noneChatMessagesView.showNoneChatMessagesContainer(seconds);
};
