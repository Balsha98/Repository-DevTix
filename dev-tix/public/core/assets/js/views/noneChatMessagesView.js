class NoneChatMessagesView {
    #noneChatMessagesContainer = $(".div-none-chat-messages-container");

    showNoneChatMessagesContainer(seconds) {
        setTimeout(() => this.#noneChatMessagesContainer.removeClass("hide-none-chat-messages"), seconds * 1000);
    }

    hideNoneChatMessagesContainer() {
        this.#noneChatMessagesContainer.addClass("hide-none-chat-messages");
    }
}

export default new NoneChatMessagesView();
