class ChatMenuView {
    #chatMenuContainer = $(".div-chat-menu");
    #chatMenuBtnContainer = $(".div-show-chat-menu-btn-container");
    #btnsToggleChatMenu = $(".btn-toggle-chat-menu");

    toggleChatMenuContainer() {
        this.#chatMenuBtnContainer.toggleClass("hide-show-chat-menu-btn-container");
        this.#chatMenuContainer.toggleClass("hide-chat-menu");
    }

    addEventToggleChatMenu(handlerFunction) {
        this.#btnsToggleChatMenu.each((_, btn) => {
            $(btn).click(handlerFunction);
        });
    }
}

export default new ChatMenuView();
