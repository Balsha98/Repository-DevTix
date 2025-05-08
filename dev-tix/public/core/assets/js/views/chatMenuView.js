class ChatMenuView {
    #chatMenuContainer = $(".div-chat-menu");
    #chatMenuHeader = $(".chat-menu-header");
    #chatMessagesList = $(".chat-messages-list");
    #chatMenuPostForm = $(".form-post-chat-message");
    #chatMenuBtnContainer = $(".div-show-chat-menu-btn-container");
    #btnsToggleChatMenu = $(".btn-toggle-chat-menu");
    #chatMessageInput = $("#chat_message");
    #btnPostChatMessage = $(".btn-post-chat-message");

    toggleChatMenuContainer() {
        this.#chatMenuBtnContainer.toggleClass("hide-show-chat-menu-btn-container");
        this.#chatMenuContainer.toggleClass("hide-chat-menu");
    }

    generateChatMessage(data, renderImage, getTimeAgo, messageAuthor = "") {
        return `
            <li class="chat-messages-list-item ${messageAuthor}">
                <div class="div-chat-user-identifier-container">
                    ${renderImage(data)}
                    <span class="span-chat-activity-status status-active">&nbsp;</span>
                </div>
                <div class="div-chat-message-data-container">
                    <p class="text-chat-message">${data["chat_message"]}</p>
                    <span class="span-chat-message-timestamp">
                        ${getTimeAgo(data["sent_at"])}
                    </span>
                </div>
            </li>
        `;
    }

    generateChatMessagesList(chatMessages, renderImage, getTimeAgo) {
        const containerHeight = parseInt(this.#chatMenuContainer.css("height"));

        // prettier-ignore
        const innerElementsHeightTotal = [this.#chatMenuHeader, this.#chatMenuPostForm].reduce(
            (height, element) => height + parseFloat($(element).css("height")), 0
        );

        const elementHeightDifference = containerHeight - innerElementsHeightTotal - 24;
        this.#chatMessagesList.css("height", `${elementHeightDifference}px`);

        // Guard clause.
        if (!chatMessages) return;

        // Clear/Reset chat message list.
        this.#chatMessagesList.children().remove();

        // Make sure tickets are processed as an array.
        chatMessages = Array.isArray(chatMessages) ? chatMessages : [chatMessages];
        const userID = +$("#user_id").val();

        for (const message of chatMessages) {
            const messageAuthor = message["user_id"] !== userID ? "message-author-other" : "";
            this.#chatMessagesList.append(this.generateChatMessage(message, renderImage, getTimeAgo, messageAuthor));
        }
    }

    insertNewChatMessage(message, renderImage, getTimeAgo) {
        this.#chatMessagesList.append(this.generateChatMessage(message, renderImage, getTimeAgo));

        // Clear input fields.
        this.#chatMessageInput.val("");
    }

    addEventToggleChatMenu(handlerFunction) {
        this.#btnsToggleChatMenu.each((_, btn) => {
            $(btn).click(handlerFunction);
        });
    }

    addEventPostChatMessage(handlerFunction) {
        this.#btnPostChatMessage.click(handlerFunction);
    }
}

export default new ChatMenuView();
