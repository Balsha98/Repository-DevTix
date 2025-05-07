import chatMenuView from "./../views/chatMenuView.js";

export const controlToggleChatMenu = function () {
    chatMenuView.toggleChatMenuContainer();
};

const initController = function () {
    chatMenuView.addEventToggleChatMenu(controlToggleChatMenu);
};

initController();
