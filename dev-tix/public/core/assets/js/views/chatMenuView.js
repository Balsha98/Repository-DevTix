class ChatMenuView {
    #chatMenuContainer = $(".div-chat-menu");
    #chatMenuHeader = $(".chat-menu-header");
    #btnsToggleChatMenuLists = $(".btn-chat-nav-icon");
    #chatMessagesList = $(".chat-messages-list");
    #noneChatMessagesContainer = $(".div-none-chat-messages-container");
    #chatMenuPostForm = $(".form-post-chat-message");
    #chatMessageInput = $("#chat_message");
    #btnPostChatMessage = $(".btn-post-chat-message");
    #chatUsersList = $(".chat-users-list");
    #chatMenuBtnContainer = $(".div-show-chat-menu-btn-container");
    #btnsToggleChatMenu = $(".btn-toggle-chat-menu");

    toggleChatMenuContainer() {
        this.#chatMenuBtnContainer.toggleClass("hide-show-chat-menu-btn-container");
        this.#chatMenuContainer.toggleClass("hide-chat-menu");
    }

    generateChatMessage(data, renderImage, getTimeAgo, messageAuthor = "") {
        const activity = data["is_active"] === 0 ? "inactive" : "active";

        return `
            <li class="chat-messages-list-item ${messageAuthor}">
                <div class="div-chat-message-activity-container">
                    ${renderImage(data)}
                    <span class="span-chat-message-activity-status status-${activity}">&nbsp;</span>
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
        if (chatMessages.length === 0) return;

        // Clear/Reset chat message list.
        this.#chatMessagesList.children().remove();

        // Make sure tickets are processed as an array.
        chatMessages = Array.isArray(chatMessages) ? chatMessages : [chatMessages];
        const userID = +$("#view_as_user_id").val();

        for (const message of chatMessages) {
            const messageAuthor = message["user_id"] !== userID ? "message-author-other" : "";
            this.#chatMessagesList.append(this.generateChatMessage(message, renderImage, getTimeAgo, messageAuthor));
        }

        // Scroll down to the last messages.
        const [listElement] = this.#chatMessagesList;
        listElement.scrollTop = listElement.scrollHeight;
    }

    insertNewChatMessage(message, renderImage, getTimeAgo) {
        // Hide the sign if it's visible.
        if (!this.#noneChatMessagesContainer.hasClass("hide-none-chat-messages")) {
            this.#noneChatMessagesContainer.addClass("hide-none-chat-messages");
        }

        this.#chatMessagesList.append(this.generateChatMessage(message, renderImage, getTimeAgo));
        $(".chat-messages-list-item:last-child")[0].scrollIntoView({ block: "end" });

        // Clear input fields.
        this.#chatMessageInput.val("");
    }

    generateChatUsersList(chatUsers, renderImage) {
        const containerHeight = parseInt(this.#chatMenuContainer.css("height"));

        // prettier-ignore
        const innerElementsHeightTotal = [this.#chatMenuHeader, this.#chatMenuPostForm].reduce(
            (height, element) => height + parseFloat($(element).css("height")), 0
        );

        const elementHeightDifference = containerHeight - innerElementsHeightTotal - 24;
        this.#chatUsersList.css("height", `${elementHeightDifference}px`);

        // Guard clause.
        if (chatUsers.length === 0) return;

        // Clear/Reset chat message list.
        this.#chatUsersList.children().remove();

        // Make sure tickets are processed as an array.
        chatUsers = Array.isArray(chatUsers) ? chatUsers : [chatUsers];

        for (const user of chatUsers) {
            const activity = user["is_active"] === 0 ? "inactive" : "active";

            this.#chatUsersList.append(`
                <li class="chat-users-list-item">
                    <div class="div-chat-user-activity-container">
                        ${renderImage(user)}
                        <span class="span-chat-user-activity-status status-${activity}">&nbsp;</span>
                    </div>
                    <div class="div-chat-user-info-container">
                        <p>${user["first_name"]} ${user["last_name"]}</p>
                        <span>${user["email"]}</span>
                    </div>
                </li>    
            `);
        }
    }

    addEventToggleChatMenu(handlerFunction) {
        this.#btnsToggleChatMenu.each((_, btn) => {
            $(btn).click(handlerFunction);
        });
    }

    addEventToggleChatMenuLists(handlerFunction) {
        this.#btnsToggleChatMenuLists.each((_, btn) => {
            $(btn).click(handlerFunction);
        });
    }

    addEventPostChatMessage(handlerFunction) {
        this.#btnPostChatMessage.click(handlerFunction);
    }
}

export default new ChatMenuView();
