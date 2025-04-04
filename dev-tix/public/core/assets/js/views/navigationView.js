class NavigationView {
    #iconWelcome = $(".icon-welcome");
    #spanWelcomeMessage = $(".span-welcome-message");
    #dropdownContainers = $(".dropdown-container");
    #spanTotalClients = $(".span-total-clients");
    #btnRevert = $(".btn-revert");
    #clientsMenuList = $(".clients-menu-list");
    #noneNotificationsData = $(".div-none-notifications-container");
    #spanNotificationsIndicator = $(".span-notifications-indicator");
    #spanTotalUnread = $(".span-total-unread");
    #btnMarkAsRead = $(".btn-mark-as-read");
    #notificationsMenuList = $(".notifications-menu-list");
    #spanClientName = $(".span-client-name");

    setWelcomeMessage() {
        const hours = new Date().getHours();

        let timeOfDay;
        if (hours < 12) timeOfDay = "morning";
        else if (hours >= 12 && hours <= 18) timeOfDay = "afternoon";
        else timeOfDay = "evening";

        this.#spanWelcomeMessage.text(`Good ${timeOfDay}`);
        this.#setWelcomeIcon(timeOfDay);
    }

    #setWelcomeIcon(timeOfDay) {
        let icon;
        if (timeOfDay === "morning" || timeOfDay === "afternoon") icon = "sun";
        else if (timeOfDay === "evening") icon = "moon";

        this.#iconWelcome.attr("src", `/core/assets/media/icons/${icon}.svg`);
        this.#iconWelcome.addClass(`icon-${timeOfDay}`);
    }

    generateClientsList(data) {
        const isArray = Array.isArray(data["clients_list"]);
        const clientsList = isArray ? data["clients_list"] : [data["clients_list"]];
        const totalClients = data["total_clients"];

        const userID = +$("#user_id").val();
        const viewAsUserID = +$("#view_as_user_id").val();

        // Remove client visuals.
        if (userID === viewAsUserID) {
            const [element] = this.#btnRevert;
            $(element.closest(".form")).remove();
        }

        for (const item of clientsList) {
            const viewingAsClient = viewAsUserID ? (viewAsUserID === item["user_id"] ? "viewing-as-client" : "") : "";

            // Visually show client's name; has to consistent across required pages.
            if (viewingAsClient && this.#spanClientName) this.#spanClientName.text(item["first_name"]);

            this.#clientsMenuList.append(`
                <li 
                    class="dropdown-menu-list-item clients-menu-list-item ${viewingAsClient}" 
                    data-client-id="${item["user_id"]}"
                >
                    <form class="form client-form-${item["user_id"]}" action="/api/" method="PUT">
                        <div class="div-notifications-icon-container flex-center">
                            <ion-icon src="/core/assets/media/icons/user.svg"></ion-icon>
                        </div>
                        <div class="div-notifications-info-container">
                            <h4>${item["first_name"]} ${item["last_name"]}</h4>
                            <span>${item["email"]}</span>
                        </div>
                        <div class="div-hidden-inputs">
                            <input id="client_id_${item["user_id"]}" type="hidden" name="client_id" value="${item["user_id"]}">
                        </div>
                    </form>
                </li>
            `);
        }

        // Add scroll overflow to list.
        if (totalClients > 5) this.#clientsMenuList.css("overflow-y", "scroll");

        this.#spanTotalClients.text(totalClients);
    }

    generateNotificationsList(data, getTimeAgo) {
        const isArray = Array.isArray(data["notifications_list"]);
        const notificationsList = isArray ? data["notifications_list"] : [data["notifications_list"]];
        const totalUnread = data["total_unread"];

        // Remove certain visuals.
        if (totalUnread === 0) {
            this.#spanNotificationsIndicator.remove();

            // Remove notification form.
            const [element] = this.#btnMarkAsRead;
            $(element.closest(".form")).remove();
        }

        if (notificationsList.length === 0) return this.#noneNotificationsData.removeClass("hide-none-notifications");

        for (const item of notificationsList) {
            const isUnread = item["is_read"] === 0 ? "unread-notification" : "";

            this.#notificationsMenuList.append(`
                <li 
                    class="dropdown-menu-list-item notifications-menu-list-item ${isUnread}" 
                    data-notification-id="${item["notification_id"]}" 
                    data-status="${item["is_read"]}" 
                    data-method="PUT"
                >
                    <div class="div-notifications-icon-container flex-center">
                        <ion-icon src="/core/assets/media/icons/${this.#getIconType(item["type"])}.svg"></ion-icon>
                    </div>
                    <div class="div-notifications-info-container">
                        <h4>${item["title"]}</h4>
                        <span>${getTimeAgo(item["sent_at"])}</span>
                    </div>
                </li>
            `);
        }

        // Add scroll overflow to list.
        if (notificationsList.length > 5) this.#notificationsMenuList.css("overflow-y", "scroll");

        this.#spanTotalUnread.text(totalUnread);
    }

    #getIconType(type) {
        if (type === "signup") return "user-plus";
        else if (type === "profile") return "user";
        else if (type === "request") return "paperclip";
        else if (type === "response") return "wind";
        else if (type === "league") return "award";
        else if (type === "leaderboard") return "bar-chart-2";
    }

    addEventToggleDropdown(handlerFunction) {
        this.#dropdownContainers.each((_, div) => {
            $(div).click(handlerFunction);
        });
    }

    addEventSetViewAsClient(handlerFunction) {
        const clientListItems = $(".clients-menu-list-item");

        // Guard clause: no clients available.
        if (clientListItems.length === 0) return;

        clientListItems.each((_, item) => {
            $(item).click(handlerFunction);
        });
    }

    addEventRevertClientData(handlerFunction) {
        this.#btnRevert.click(handlerFunction);
    }

    addEventMarkAllAsRead(handlerFunction) {
        this.#btnMarkAsRead.click(handlerFunction);
    }

    addEventMarkNotificationAsRead(handlerFunction) {
        const notificationListItems = $(".notifications-menu-list-item");

        // Guard clause: no unread notifications.
        if (notificationListItems.length === 0) return;

        notificationListItems.each((_, item) => {
            $(item).click(handlerFunction);
        });
    }
}

export default new NavigationView();
